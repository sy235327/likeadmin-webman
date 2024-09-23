<?php


namespace app\common\lists;

use app\common\enum\ExportEnum;
use app\common\service\JsonService;
use app\common\validate\ListsValidate;
use app\Request;
use Webman\Config;

abstract class BaseDataLists implements ListsInterface
{
    use ListsSearchTrait;
    use ListsSortTrait;
    use ListsExcelTrait;

    public $request; //请求对象

    public $pageNo; //页码
    public $pageSize; //每页数量
    public $limitOffset;  //limit查询offset值
    public $limitLength;  //limit查询数量
    public $pageSizeMax;
    public $pageType = 0; //默认类型：0-一般分页；1-不分页，获取最大所有数据


    protected $orderBy;
    protected $field;

    protected $startTime;
    protected $endTime;

    protected $start;
    protected $end;

    protected $params;
    protected $sortOrder = [];

    public $export;
    public $is_export_max=2000;
    public $is_export_batch=false;

    public function __construct()
    {
        //参数验证
        (new ListsValidate())->get()->goCheck();

        //请求参数设置
        $this->request = request();
        $this->params = $this->request->all();

        //分页初始化
        $this->initPage();

        //搜索初始化
        $this->initSearch();

        //排序初始化
        $this->initSort();

        //导出初始化
        $this->initExport();
    }

    /**
     * @notes 分页参数初始化
     * @author 令狐冲
     * @date 2021/7/30 23:55
     */
    private function initPage()
    {
        $this->pageSizeMax = Config::get('project.lists.page_size_max');
        $this->pageSize = Config::get('project.lists.page_size');
        $this->pageType = $this->request->get('page_type', 1);

        if ($this->pageType == 1) {
            //分页
            $this->pageNo = $this->request->get('page_no', 1) ?: 1;
            $this->pageSize = $this->request->get('page_size', $this->pageSize) ?: $this->pageSize;
        } else {
            //不分页
            $this->pageNo = 1;//强制到第一页
            $this->pageSize = $this->pageSizeMax;// 直接取最大记录数
        }

        //limit查询参数设置
        $this->limitOffset = ($this->pageNo - 1) * $this->pageSize;
        $this->limitLength = $this->pageSize;
    }

    /**
     * @notes 初始化搜索
     * @return array
     * @author 令狐冲
     * @date 2021/7/31 00:00
     */
    private function initSearch()
    {
        if (!($this instanceof ListsSearchInterface)) {
            return [];
        }
        $startTime = $this->request->get('start_time');
        $this->startTime = strtotime($startTime);
        $endTime = $this->request->get('end_time');
        $this->endTime = strtotime($endTime);

        $this->start = $this->request->get('start');
        $this->end = $this->request->get('end');

        return $this->searchWhere = $this->createWhere($this->setSearch());
    }

    /**
     * @notes 初始化排序
     * @return array|string[]
     * @author 令狐冲
     * @date 2021/7/31 00:03
     */
    private function initSort()
    {
        if (!($this instanceof ListsSortInterface)) {
            return [];
        }

        $this->field = $this->request->get('field', '');
        $this->orderBy = $this->request->get('order_by', '');

        return $this->sortOrder = $this->createOrder($this->setSortFields(), $this->setDefaultOrder());
    }

    /**
     * @notes 导出初始化
     * @return false|\support\Response
     * @author 令狐冲
     * @date 2021/7/31 01:15
     */
    private function initExport()
    {
        $this->export = $this->request->get('export', '');

        //不做导出操作
        if ($this->export != ExportEnum::INFO && $this->export != ExportEnum::EXPORT) {
            return false;
        }

        //导出操作，但是没有实现导出接口
        if (!($this instanceof ListsExcelInterface)) {
            return JsonService::throw('该列表不支持导出');
        }

        $this->fileName = $this->request->get('file_name', '') ?: $this->setFileName();

        //不导出文件，不初始化一下参数
        if ($this->export != ExportEnum::EXPORT) {
            return false;
        }

        //导出文件名设置
        $this->fileName .= '-' . date('Y-m-d-His') . '.xlsx';

        //导出文件准备
        if ($this->export == ExportEnum::EXPORT) {
            //指定导出范围（例：第2页到，第5页的数据）
            if ($this->pageType == 1) {
                $this->pageStart = $this->request->get('page_start', $this->pageStart);
                $this->pageEnd = $this->request->get('page_end', $this->pageEnd);
                //改变查询数量参数（例：第2页到，第5页的数据，查询->page(2,(5-2+1)*25)
                $this->limitOffset = ($this->pageStart - 1) * $this->pageSize;
                $this->limitLength = ($this->pageEnd - $this->pageStart + 1) * $this->pageSize;
            }

            $count = $this->count();
            //判断改list导出数据是否超标超标需要分批导出
            $this->is_export_batch = false;
            if ($count>$this->is_export_max){
                $this->is_export_batch = true;
                $this->pageType == 1;
                $this->pageStart = $this->request->get('page_start', $this->pageStart);
                $this->pageEnd = $this->request->get('page_end', $this->is_export_max);
                //改变查询数量参数（例：第2页到，第5页的数据，查询->page(2,(5-2+1)*25)
                $this->limitOffset = ($this->pageStart - 1) * $this->pageSize;
                $this->limitLength = ($this->pageEnd - $this->pageStart + 1) * $this->pageSize;
            }
            //判断导出范围是否有数据
            if ($count == 0 || ceil($count / $this->pageSize) < $this->pageStart) {
                $msg = $this->pageType ? '第' . $this->pageStart . '页到第' . $this->pageEnd . '页没有数据，无法导出' : '没有数据,无法导出';
                return JsonService::throw($msg);
            }
        }
    }
}