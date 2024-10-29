<?php

namespace app\queue\redis;

use app\queue\send\SendQueue;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Webman\RedisQueue\Consumer;

/**
 * 导入表格消费端
 */
class ImportXlsxClient implements Consumer
{
    /**
     * 队列和配置初始化
     */
    public function __construct() {
        $this->connection = getenv('REDIS_QUEUE_CONNECTION','');
        $this->queue = SendQueue::$QUEUE_TABLE_PUSH;
    }

    // 要消费的队列名
    public string $queue = '';

    // 连接名，对应 plugin/webman/redis-queue/redis.php 里的连接`
    public string $connection = '';


    /**
     * 消费端 解析导入的 .xlsx/.xls/.csv 格式的表格，异步分段读取，解决了内存溢出问题
     * @param $data {
     *     "file_src":"文件地址",
     *     "admin_id":"操作人员",
     *     "get_config_key":"头配置key 可选默认 def_import_template",
     *     "head_index":"头_index 可选默认0",
     *     "handler_max_index":"处理条数 可选默认5000",
     * }
     * @return void
     */
    public function consume($data): void
    {
        // 无需反序列化
        var_export($data);
        //表格文件所在目录
        $filePath = $data['file_src'];
        //用户id
        $adminId = $data['admin_id'];
        $get_config_key = $data['get_config_key'];
        if (!$get_config_key){
            $get_config_key = 'def_import_template';
        }
        //头配置对应key
        $config_key = 'import_handler_keys.'.$get_config_key;
        //表格头所在行
        $head_index = 0;
        if (isset($data['head_index'])){
            $head_index = $data['head_index'];
        }
        //最多处理表格数据量
        $max_row = 5000;
        if (isset($data['handler_max_index'])){
            $max_row = $data['handler_max_index'];
        }
        //表格头配置示例:
        //[
        //    "姓名"=>"name",
        //    "电话号码"=>"mobile",
        //    "年月(格式:年/月)"=>'wages_year_month',
        //    "时间(格式:年/月/日)"=>"payday"
        //]
        $excel_keys_config = config($config_key,[]);
        try{
            // 指令输出
            print("----开始执行----\r\n");
            // 实例化对象
            if (str_contains($filePath, '.xlsx')) {
                // 对应文件类型为 .xlsx
                $PHPReader = new Xlsx();
            } elseif (str_contains($filePath, '.xls')) {
                // 对应文件类型为 .xls
                $PHPReader = new Xls();
            } elseif (str_contains($filePath, '.csv')) {
                $PHPReader = new Csv();
            } else {
                // 文件类型无法识别
                print("文件类型无法处理\r\n");
                return;
            }
            // 构建读取过滤器
            $chunkFilter = new ChunkReadFilter($head_index,1);
            // 设置读取过滤器 实现分片读取
            $PHPReader->setReadFilter($chunkFilter);
            // 载入Excel文件
            $PHPExcel = $PHPReader->load(public_path() . $filePath);
            // 获得sheet1
            $sheet = $PHPExcel->getActiveSheet(0);
            // 获取Excel数据
            $arr = $sheet->toArray();
            // 解析
            $data = [];
            //数据长度
            $length = count($arr);

            if ($length < 1) {
                print("未找到标题\r\n");
                return;
            }
            //获取key值
            $keys_list = [];
            //是否常规配置方式处理的key,其他归属other_info
            $isSaveKeys = [];
            for ($keys_index = 0; $keys_index < count($arr[0]); $keys_index++) {
                $rowTitle = $arr[0][$keys_index];
                if (is_string($rowTitle)){
                    $rowTitle = trim($rowTitle);
                }
                if (empty($rowTitle)){
                    continue;
                }
                if (isset($excel_keys_config[$rowTitle])) {
                    $keys_list[] = [
                        'index' => $keys_index,
                        'name' => $rowTitle,
                        'key' => $excel_keys_config[$rowTitle]
                    ];
                    $isSaveKeys[] = $excel_keys_config[$rowTitle];
                }else{
                    $keys_list[] = [
                        'index' => $keys_index,
                        'name' => $rowTitle,
                        'key' => str_replace(["\r","\n"," "], '', $rowTitle)
                    ];
                }
            }

            //表格分批处理数据量
            $chunkSize = 200;
            //数据库每多少条保存执行操作
            $chunkSaveNumber = 500;
            //导入缓存数组
            $save_list = [];
            //导入时间
            $importTime = time();
            //处理条数
            $handlerNumber = 0;
            //保存条数
            $saveOkNumber = 0;
            /**  Loop to read our worksheet in "chunk size" blocks  **/
            for ($startRow = $head_index+1; $startRow <= $max_row; $startRow += $chunkSize) {
                /**  Create a new Instance of our Read Filter, passing in the limits on which rows we want to read  **/
                $chunkFilter = new ChunkReadFilter($startRow,$chunkSize);
                /**  Tell the Reader that we want to use the new Read Filter that we've just Instantiated  **/
                $PHPReader->setReadFilter($chunkFilter);
                // 载入Excel文件
                $PHPExcel = $PHPReader->load(public_path(). $filePath);
                // 获得sheet1
                $sheet = $PHPExcel->getActiveSheet(0);
                // 获取Excel数据
                $arr = $sheet->toArray();
                $length = count($arr);
                if ($length < 1) {
                    break;
                }
                $handlerNumber += $length;
                for ($i = 1; $i < $length; $i++) {
                    $other_item = [];
                    $save_item = $this->getInitItem($startRow,$adminId,$importTime);
                    // 为什么i从1开始？因为i=0是列标题！
                    for ($j = 0; $j < count($arr[$i]); $j++) {
                        foreach ($keys_list as $item) {
                            if ($item['index'] === $j) {
                                $val = '';
                                if (isset($arr[$i][$j])){
                                    $val = $arr[$i][$j];
                                    if (is_string($val)){
                                        $val = trim($val);
                                    }
                                }
                                if (in_array($item['key'],$isSaveKeys)){
                                    switch ($this->getKeyType($item)){
                                        case 1:
                                            if ($val){
                                                $val = $val."-01";
                                            }
                                        case 2:
                                            $time = null;
                                            if ($val){
                                                $val = str_replace(["/",".","年","月"," "],"-",$val);
                                                $val = str_replace("日","",$val);
                                                $val = str_replace("--","-",$val);
                                                if (strtotime($val)!==false){
                                                    $time = strtotime($val);
                                                }
                                            }
                                            $save_item[$item['key']] = $time;
                                            break;
                                        default:
                                            $save_item[$item['key']] = $val;
                                            break;
                                    }
                                }else{
                                    $other_item[$item['key']] = $val;
                                }
                            }
                        }
                    }
                    if (empty($save_item['name'])){
                        continue;
                    }
                    $save_item['other_info'] = $other_item;
                    $save_list[] = $save_item;
                    //分批保存操作
                    if (count($save_list) === $chunkSaveNumber){
                        $this->handlerBatchSaveList($save_list);
                        $save_list = [];
                    }
                    $saveOkNumber++;
                }
            }
            $this->handlerBatchSaveList($save_list);
            //更新插入数量
            $this->handlerEndCallback($handlerNumber,$saveOkNumber,$data);
            print("----执行结束----\r\n");
        }catch (\Exception $e){
            print("----执行错误----\r\n");
        }
    }
    public function getKeyType($key_item): int
    {
        if (str_contains($key_item['name'],'年/月/日')){
            return 2;
        }
        if (str_contains($key_item['name'],'年/月')){
            return 1;
        }
        return 3;
    }
    public function getInitItem($startRow,$adminId,$importTime): array
    {
        return  [
            'create_time'=>$importTime,
            'update_time'=>$importTime,
        ];
    }

    /**
     * 分批保存回调函数
     * @param $save_list
     * @return void
     */
    public function handlerBatchSaveList($save_list){

    }

    /**
     * 结束回调
     * @param $handlerNumber int 执行row数量
     * @param $saveOkNumber int 保存数量
     * @param mixed $data 队列参数
     * @return void
     */
    public function handlerEndCallback(int $handlerNumber, int $saveOkNumber, mixed $data){

    }
    // 消费失败回调
    /*
    $package = [
        'id' => 1357277951, // 消息ID
        'time' => 1709170510, // 消息时间
        'delay' => 0, // 延迟时间
        'attempts' => 2, // 消费次数
        'queue' => 'send-mail', // 队列名
        'data' => ['to' => 'tom@gmail.com', 'content' => 'hello'], // 消息内容
        'max_attempts' => 5, // 最大重试次数
        'error' => '错误信息' // 错误信息
    ]
    */
    public function onConsumeFailure(\Throwable $e, $package): void
    {
        echo "consume failure\n";
        echo $e->getMessage() . "\n";
        // 无需反序列化
        var_export($package);
    }
}
