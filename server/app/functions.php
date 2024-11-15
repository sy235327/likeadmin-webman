<?php
/**
 * Here is your custom functions.
 */

use app\common\service\FileService;
use support\Container;
use think\facade\Cache;

if (!function_exists('download')) {
    /**
     * 获取\think\response\Download对象实例
     * @param string $filename 要下载的文件
     * @param string $name     显示文件名
     */
    function download(string $filename, string $name = ''): \Webman\Http\Response {
        return (new Webman\Http\Response())->download($filename,$name);
    }
}
if(!function_exists('substr_symbol_behind')){
    /**
     * @notes 截取某字符字符串
     * @param $str
     * @param string $symbol
     * @return string
     * @author 乔峰
     * @date 2021/12/28 18:24
     */
    function substr_symbol_behind($str, $symbol = '.') : string
    {
        $result = strripos($str, $symbol);
        if ($result === false) {
            return $str;
        }
        return substr($str, $result + 1);
    }
}

if (!function_exists('root_path')) {
    /**
     * 获取项目根目录
     *
     * @param string $path
     * @return string
     */
    function root_path($path = '')
    {
        return base_path() . DIRECTORY_SEPARATOR;
    }
}


if (!function_exists('generate_path')) {
    /**
     * 获取项目根目录
     *
     * @param string $path
     * @return string
     */
    function generate_path()
    {
        return root_path() . 'app/';
    }
}


if (!function_exists('cache')) {
    /**
     * 缓存管理
     * @param string $name    缓存名称
     * @param mixed  $value   缓存值
     * @param mixed  $options 缓存参数
     * @param string $tag     缓存标签
     * @return mixed
     */
    function cache(string $name = null, $value = '', $options = null, $tag = null)
    {
        if (is_null($name)) {
            return Cache::getFacadeClass();
        }

        if ('' === $value) {
            // 获取缓存
            return 0 === strpos($name, '?') ? Cache::has(substr($name, 1)) : Cache::get($name);
        } elseif (is_null($value)) {
            // 删除缓存
            return Cache::delete($name);
        }

        // 缓存数据
        if (is_array($options)) {
            $expire = $options['expire'] ?? null; //修复查询缓存无法设置过期时间
        } else {
            $expire = $options;
        }

        if (is_null($tag)) {
            return Cache::set($name, $value, $expire);
        } else {
            return Cache::tag($tag)->set($name, $value, $expire);
        }
    }
}
/**
 * IOC容器,单进程中获取唯一对象
 */
if (!function_exists('make')) {
    function make(string $abstract, array $vars = [], bool $newInstance = false): mixed
    {
        $isObj = Container::has($abstract);
        if ($isObj&&!$newInstance){
            try{
                return Container::get($abstract);
            }catch (\Webman\Exception\NotFoundException $e){
                return null;
            }
        }
        return Container::make($abstract,$vars);
    }
}
if (!function_exists('strUcwords')){
    function strUcwords($str): string
    {
        $strArr = explode('_', $str);
        $str = implode(' ', $strArr);
        $str = implode('', explode(' ', ucwords($str)));
        return $str;
    }
}
if (!function_exists('strToUnderLineSpacing')){
    function strToUnderLineSpacing($str): string {
        $tmp_array = [];

        for ($i = 0; $i < strlen($str); $i++) {
            $ascii_code = ord($str[$i]);
            if ($ascii_code >= 65 && $ascii_code <= 90) {
                if ($i == 0) {
                    $tmp_array[] = chr($ascii_code + 32);
                } else {
                    $tmp_array[] = '_' . chr($ascii_code + 32);
                }
            } else {
                $tmp_array[] = $str[$i];
            }
        }

        return implode('', $tmp_array);
    }
}
if (!function_exists('url')) {
    /**
     * Url生成
     * @param string      $url    路由地址
     * @param array       $vars   变量
     * @param bool|string $suffix 生成的URL后缀
     * @param bool|string $domain 域名
     * @return string
     */
    function url(string $url = '', array $vars = [], $suffix = true, $domain = false): string
    {
        $url = $suffix?$url.'.'.$suffix:$url;
        $host = getAgreementHost();
        $httpQuery = $vars?"?".http_build_query($vars):'';
        if ($domain){
            return $host.DIRECTORY_SEPARATOR.$url.$httpQuery;
        }
        return DIRECTORY_SEPARATOR.$url.$httpQuery;
    }
}

if (!function_exists('format_amount')) {

    /**
     * @notes 格式化金额
     * @param string|float|int $float 需要格式化的金额
     * @return string $precision 小数位数
     * @return string 格式化后的金额
     * @author 段誉
     * @date 2023/2/24 11:20
     */
    function format_amount(string|float|int $float,int $precision = 1): string
    {
        $intFloat = intval($float);
        $float_format = sprintf('%.'.$precision.'f', $float);
        if ($float == $intFloat) {
            return (string) $intFloat;
        } elseif ($float == $float_format) {
            return $float_format;
        }
        return (string) $float;
    }
}


if (!function_exists('del_target_dir')) {

    /**
     * @notes 删除目标目录
     * @param string $path
     * @param string $delDir
     * @return bool
     * @author bingo
     * @date 2022/4/8 16:30
     */
    function del_target_dir(string $path,string $delDir): bool
    {
        //没找到，不处理
        if (!file_exists($path)) {
            return false;
        }

        //打开目录句柄
        $handle = opendir($path);
        if ($handle) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if (is_dir("$path/$item")) {
                        del_target_dir("$path/$item", $delDir);
                    } else {
                        unlink("$path/$item");
                    }
                }
            }
            closedir($handle);
            if ($delDir) {
                return rmdir($path);
            }
        } else {
            if (file_exists($path)) {
                return unlink($path);
            }
            return false;
        }
        return true;
    }
}

if (!function_exists('get_no_prefix_table_name')) {

    /**
     * @notes 获取无前缀数据表名
     * @param string $tableName
     * @return string
     * @author bingo
     * @date 2022/12/12 15:23
     */
    function get_no_prefix_table_name(string $tableName): string
    {
        $tablePrefix = getenv('DB_PREFIX');
        $prefixIndex = strpos($tableName, $tablePrefix);
        if ($prefixIndex !== 0) {
            return $tableName;
        }
        $tableName = substr_replace($tableName, '', 0, strlen($tablePrefix));
        return trim($tableName);
    }
}
if (!function_exists('compare_php')) {

    /**
     * @notes 对比php版本
     * @param string $version
     * @return bool
     * @author 乔峰
     * @date 2021/12/28 18:27
     */
    function compare_php(string $version): bool
    {
        return version_compare(PHP_VERSION, $version) >= 0 ? true : false;
    }
}
if (!function_exists('check_dir_write')) {

    /**
     * @notes 检查文件是否可写
     * @param string $dir
     * @return bool
     * @author 乔峰
     * @date 2021/12/28 18:27
     */
    function check_dir_write(string $dir = ''): bool
    {
        $route = base_path() . '/' . $dir;
        return is_writable($route);
    }
}
if (!function_exists('create_token')) {

    /**
     * @notes 随机生成token值
     * @param string $extra
     * @return string
     * @author 乔峰
     * @date 2021/12/28 18:24
     */
    function create_token(string $extra = ''): string
    {
        return md5($extra . time());
    }
}
if (!function_exists('linear_to_tree')) {

    /**
     * 多级线性结构排序
     * 转换前：
     * [{"id":1,"pid":0,"name":"a"},{"id":2,"pid":0,"name":"b"},{"id":3,"pid":1,"name":"c"},
     * {"id":4,"pid":2,"name":"d"},{"id":5,"pid":4,"name":"e"},{"id":6,"pid":5,"name":"f"},
     * {"id":7,"pid":3,"name":"g"}]
     * 转换后：
     * [{"id":1,"pid":0,"name":"a","level":1},{"id":3,"pid":1,"name":"c","level":2},{"id":7,"pid":3,"name":"g","level":3},
     * {"id":2,"pid":0,"name":"b","level":1},{"id":4,"pid":2,"name":"d","level":2},{"id":5,"pid":4,"name":"e","level":3},
     * {"id":6,"pid":5,"name":"f","level":4}]
     * @param array $data 线性结构数组
     * @param string $symbol 名称前面加符号
     * @param string $name 名称
     * @param string $id_name 数组id名
     * @param string $parent_id_name 数组祖先id名
     * @param int $level 此值请勿给参数
     * @param int $parent_id 此值请勿给参数
     * @return array
     */
    function linear_to_tree($data, $sub_key_name = 'sub', $id_name = 'id', $parent_id_name = 'pid', $parent_id = 0)
    {
        $tree = [];
        foreach ($data as $row) {
            if ($row[$parent_id_name] == $parent_id) {
                $temp = $row;
                $child = linear_to_tree($data, $sub_key_name, $id_name, $parent_id_name, $row[$id_name]);
                if ($child) {
                    $temp[$sub_key_name] = $child;
                }
                $tree[] = $temp;
            }
        }
        return $tree;
    }
}

if (!function_exists('createDir')) {

    function createDir($path)
    {
        if (is_dir($path)) {
            return true;
        }

        $parent = dirname($path);
        if (!is_dir($parent)) {
            if (!createDir($parent)) {
                return false;
            }
        }
        return mkdir($path);
    }
}

if (!function_exists('create_password')) {

    /**
     * @notes 生成密码加密密钥
     * @param string $plaintext
     * @param string $salt
     * @return string
     * @author 段誉
     * @date 2021/12/28 18:24
     */
    function create_password(string $plaintext, string $salt) : string
    {
        return md5($salt . md5($plaintext . $salt));
    }
}

if (!function_exists('generate_sn')) {


    /**
     * @notes 生成编码
     * @param $table
     * @param $field
     * @param string $prefix
     * @param int $randSuffixLength
     * @param array $pool
     * @return string
     * @author 段誉
     * @date 2023/2/23 11:35
     */
    function generate_sn($table, $field, $prefix = '', $randSuffixLength = 4, $pool = []) : string
    {
        $suffix = '';
        for ($i = 0; $i < $randSuffixLength; $i++) {
            if (empty($pool)) {
                $suffix .= rand(0, 9);
            } else {
                $suffix .= $pool[array_rand($pool)];
            }
        }
        $sn = $prefix . date('YmdHis') . $suffix;
        if ($table::where($field, $sn)->find()) {
            return generate_sn($table, $field, $prefix, $randSuffixLength, $pool);
        }
        return $sn;
    }
}
if (!function_exists('get_file_domain')) {

    /**
     * @notes 设置内容图片域名
     * @param $content
     * @return array|string|string[]|null
     * @author 段誉
     * @date 2022/9/26 10:43
     */
    function get_file_domain($content)
    {
        $preg = '/(<img .*?src=")[^https|^http](.*?)(".*?>)/is';
        $fileUrl = FileService::getFileUrl();
        return preg_replace($preg, "\${1}$fileUrl\${2}\${3}", $content);
    }
}
if (!function_exists('clear_file_domain')) {


    /**
     * @notes 去除内容图片域名
     * @param $content
     * @return array|string|string[]
     * @author 段誉
     * @date 2022/9/26 10:43
     */
    function clear_file_domain($content)
    {
        $fileUrl = FileService::getFileUrl();
        return str_replace($fileUrl, '/', $content);
    }
}
if (!function_exists('download_file')) {



    /**
     * @notes 下载文件
     * @param $url
     * @param $saveDir
     * @param $fileName
     * @return string
     * @author 段誉
     * @date 2022/9/16 9:53
     */
    function download_file($url, $saveDir, $fileName)
    {
        if (!file_exists($saveDir)) {
            mkdir($saveDir, 0775, true);
        }
        $fileSrc = public_path()."/".$saveDir . $fileName;
        file_exists($fileSrc) && unlink($fileSrc);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        $file = curl_exec($ch);
        curl_close($ch);
        $resource = fopen($fileSrc, 'a');
        fwrite($resource, $file);
        fclose($resource);
        if (filesize($fileSrc) == 0) {
            unlink($fileSrc);
            return '';
        }
        return $saveDir . $fileName;
    }
}

if (!function_exists('handle_file_url')) {
    function handle_file_url($list,$fileNameList = [])
    {
        foreach ($list as &$item){
            foreach ($fileNameList as $name){
                if (isset($item[$name])){
                    $item[$name] = $item[$name]?FileService::getFileUrl($item[$name]):$item[$name];
                }
            }
        }
        return $list;
    }
}
if (!function_exists('formatDateStrToTime')){
    /**
     * 时间格式化 时间字符串 按照指定格式解析返回时间戳
     */
    function formatDateStrToTime($dateStr,$format){
        $date = DateTime::createFromFormat($format,$dateStr);
        return $date->getTimestamp();
    }
}
if (!function_exists('findChildren')){
    /**
     * 查找树表中 本身+子项+子子项。。。得数组
     */
    function findChildren($data, $targetId,&$list,$childrenKey = 'children',$idKey='id',$pidKey='pid') {
        foreach ($data as $item) {
            if ($item[$idKey] == $targetId){
                $insertData = [];
                foreach ($item as $key=>$value){
                    if ($key == $childrenKey){
                        continue;
                    }
                    $insertData[$key] = $value;
                }
                $list[] = $insertData;
            }
            if ($item[$pidKey] == $targetId){
                $insertData = [];
                foreach ($item as $key=>$value){
                    if ($key == $childrenKey){
                        continue;
                    }
                    $insertData[$key] = $value;
                }
                $list[] = $insertData;
                findChildren($item[$childrenKey],$item[$idKey],$list,$childrenKey,$idKey,$pidKey);
            }
            findChildren($item[$childrenKey],$targetId,$list,$childrenKey,$idKey,$pidKey);
        }
    }
}
if (!function_exists('getAgreementHost')){
    /**
     * proxy_set_header Scheme $scheme;
     * 获取单域名配置上的协议拼接域名
     * 如果是后台有单独域名部署那么直接从 host 请求头上拿域名
     * @return array|string|null
     */
    function getAgreementHost() {
        //兼容脚本环境使用
        if (!request()){
            return getenv('SERVER_LISTEN','http://127.0.0.1');
        }
        if(!strstr(request()->host(), 'http://') && !strstr(request()->host(), 'https://')){
            return request()->header('Scheme','http')."://".request()->host();
        }
        return request()->host();
    }
}

if (!function_exists('getRealIP')){
    /**
     * 获取客户端真实IP
     * nginx/apache将客户端真实ip通过http header传递进来，例如nginx配置中location里的加上proxy_set_header X-Real-IP $remote_addr;
     * 如果不是则默认$_SERVER['REMOTE_ADDR']
     */
    function getRealIP(): string {
        //兼容脚本环境使用
        if (!request()){
            return '127.0.0.1';
        }
        $real_ip = request()->header('HTTP_X_REAL_IP',false);
        if (!$real_ip){
            $real_ip = request()->getRemoteIp();
        }
        if (!$real_ip){
            $real_ip = request()->getLocalIp();
        }
        if (!$real_ip){
            $real_ip = '127.0.0.1';
        }
        return $real_ip;
    }
}

if (!function_exists('requestFormPost')){
    function requestFormPost(string $url,mixed $data,string|null &$error,$result_json_format = true,array $addHeaders = []): bool|array|string|null {
        $headers = array('Content-Type: application/x-www-form-urlencoded');
        $headers = array_merge($headers,$addHeaders);
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, true); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, true); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data)); // Post提交的数据包
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, false); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // 获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            $error = curl_error($curl);//捕抓异常
            return false;
        }
        curl_close($curl); // 关闭CURL会话
        if (!$result_json_format){
            return $result;
        }
        $json = json_decode($result,true);
        if (!$json){
            $error = "json 格式化失败";//捕抓异常
            return false;
        }
        return $json;
    }
}
if (!function_exists('requestJsonPost')){
    function requestJsonPost(string $url,mixed $data,string|null &$error,$result_json_format = true,array $addHeaders = []): bool|array|string|null {
        $data_json = $data?:'';
        if (is_array($data)){
            $data_json = json_encode($data); // 将数据编码为JSON
        }
        $headers = array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json));
        $headers = array_merge($headers,$addHeaders);
        $curl = curl_init(); // 初始化cURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, true); // 自动设置Referer
        curl_setopt($curl, CURLOPT_POST, true); // 设置cURL选项，进行POST请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json); // 设置cURL选项，POST发送的数据
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); // 设置HTTP头部信息
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, false); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // 获取的信息以文件流的形式返回
        $result = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            $error = curl_error($curl);//捕抓异常
            return false;
        }
        curl_close($curl); // 关闭CURL会话
        if (!$result_json_format){
            return $result;
        }
        $json = json_decode($result,true);
        if (!$json){
            $error = "json 格式化失败";//捕抓异常
            return false;
        }
        return $json;
    }
}
if (!function_exists('requestGet')) {
    function requestGet(string $url, mixed $data, string|null &$error, $result_json_format = true, array $addHeaders = []): bool|array|string|null
    {
        $params = $data;
        if (is_array($data)) {
            $params = http_build_query($data);
        }
        $req_url = $url . '?' . $params;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_URL, $req_url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, true); // 自动设置Referer
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); //获取的信息以文件流的形式返回
        curl_setopt($curl, CURLOPT_HEADER, false);//设置不要返回头
        curl_setopt($curl, CURLOPT_TIMEOUT, 60); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, false); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_HTTPHEADER, $addHeaders); // 设置HTTP头部信息
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在

        $result = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            $error = curl_error($curl);//捕抓异常
            return false;
        }
        curl_close($curl); // 关闭CURL会话
        if (!$result_json_format) {
            return $result;
        }
        $json = json_decode($result, true);
        if (!$json) {
            $error = "json 格式化失败";//捕抓异常
            return false;
        }
        return $json;
    }
}


if (!function_exists('sortArrByColumnsList')) {
    /**
     * 多字段排序数组参数
     * @param array $array 排序的数组
     * @param array $columns [column=>sort_type,column=>sort_type]
     */
    function sortArrByColumnsList(array $array,array $columns): array
    {
        $args = [$array];
        foreach ($columns as $column=>$sortType){
            $args[] = $column;
            $args[] = $sortType;
        }
        $arr = array_shift($args);
        if (!is_array($arr)) {
            return [];
        }
        foreach ($args as $key => $field) {
            if (is_string($field)) {
                $temp = array();
                foreach ($arr as $index => $val) {
                    $temp[$index] = $val[$field];
                }
                $args[$key] = $temp;
            }
        }
        $args[] = &$arr;//引用值
        array_multisort(...$args);
        return array_pop($args);
    }
}
if (!function_exists('mapListUnique')) {
    /**
     * 数组去重
     * @param array $arr 去重的数组
     * @param $isAssociativeArray bool 是否为索引数组
     * @return array
     */
    function mapListUnique(array $arr,bool $isAssociativeArray = false): array
    {
        //格式化字符数组去重
        $uniqueStrList = array_unique(
            array_map(
                function($val){
                    return serialize($val);
                },
                $arr
            )
        );
        //重新格式化回来
        $dictList = array_map(
            function($val){
                return unserialize($val);
            },
            $uniqueStrList
        );
        if (!$isAssociativeArray){
            return $dictList;
        }
        //索引数组重新构建索引
        return lackNumberKeyMapToList($dictList);
    }
}
if (!function_exists('lackNumberKeyMapToList')) {
    /**
     * 将关联数组重新构建索引
     * @param array $arr
     * @return array
     */
    function lackNumberKeyMapToList(array $arr):array{
        $list = [];
        foreach ($arr as $item){
            $list[] = $item;
        }
        return $list;
    }
}

if (!function_exists('time_to_date')) {

    function time_to_date($time,$format = "Y-m-d H:i:s"): string {
        if (!$time || $time <= 0){
            return '';
        }
        $time = date($format,$time);
        return $time;
    }
}
if (!function_exists('date_to_time')) {

    function date_to_time($date): bool|int {
        return strtotime($date);
    }
}

if (!function_exists('find_missing_elements')) {

    // 比较两个整数数组，找出第一个数组中缺少的元素
    function find_missing_elements($array1, $array2): array {
        $missingElements = array_diff($array2, $array1);
        return array_values($missingElements);
    }
}

if (!function_exists('mapListByKeyGetList')){
    /**
     * 字典数组转list
     */
    function mapListByKeyGetList(array|object $originData,$key): array {
        $list = [];
        foreach($originData as $item){
            if (isset($item[$key])){
                $list[] = $item[$key];
            }
        }
        return $list;
    }
}
if (!function_exists('listToMapByItemKey')){
    /**
     * list数组按照指定key转map
     * map的value根据isMapList决定value是数组接收还是list[index]的值
     */
    function listToMapByItemKey(array|object $list,mixed $itemKey,bool $isMapList=true,mixed $defaultVal=[]):mixed{
        if (!is_array($list)){
            return $defaultVal;
        }
        $map = [];
        foreach($list as $item){
            if (isset($item[$itemKey])){
                $key = $item[$itemKey];
                if($isMapList){
                    $map[$key][] = $item;
                }else{
                    $map[$key] = $item;
                }
            }
        }
        return ($map&&count(array_keys($map))>0)?$map:$defaultVal;
    }
}


if (!function_exists('checkPasswordStrength')){
    function checkPasswordStrength(string $password, string|null &$error): bool
    {
        // 校验密码长度
        if (strlen($password) < 8) {
            $error = '密码长度不能少于8位';
            return false;
        }
        $specialChars = '@#$%^&*';
        // 检查是否包含大写字母
        if (!preg_match('/[A-Z]/', $password)) {
            $error = "密码必须包含至少一个大写字母。";
            return false;
        }
        // 检查是否包含小写字母
        if (!preg_match('/[a-z]/', $password)) {
            $error = "密码必须包含至少一个小写字母。";
            return false;
        }

        // 检查是否包含数字
        if (!preg_match('/[0-9]/', $password)) {
            $error = '密码必须包含至少一个数字。';
            return false;
        }
        // 特殊字符
        if (!preg_match('/[' . preg_quote($specialChars, '/') . ']/', $password)) {
            $error = '密码必须包含至少一个特殊字符。';
            return false;
        }

        // 校验是否包含常见密码
        $commonPasswords = ['123456', 'password', 'qwerty'];
        if (in_array($password, $commonPasswords)) {
            $error = '密码过于简单';
            return false;
        }

        // 校验是否包含连续字符或重复字符
        $lowercasePassword = strtolower($password);
        if (preg_match('/([a-z]){3,}/', $lowercasePassword) || preg_match('/(d){3,}/', $password)) {
            $error = '密码过于简单：重复字符>3或者连续字符>3';
            return false;
        }

        return true;
    }
}
