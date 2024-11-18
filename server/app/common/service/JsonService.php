<?php


namespace app\common\service;


use app\common\enum\ExportEnum;
use app\common\exception\HttpException;
use app\common\lists\BaseDataLists;
use app\common\lists\ListsExcelInterface;
use app\common\lists\ListsExtendInterface;
use support\Response;

class JsonService
{
    /**
     * @notes 接口操作成功，返回信息
     * @param string $msg 信息
     * @param array $data 数据
     * @param int $code 状态码
     * @param int $show 是否显示
     * @param int $httpStatus http状态码
     * @param int $options 可选 JSON_UNESCAPED_UNICODE json 格式化
     * @author 乔峰
     * @date 2021/12/24 18:28
     */
    public static function success(string $msg = 'success', array $data = [], int $code = 1, int $show = 1, int $httpStatus = 200,...$options): Response
    {
        return self::result($code, $show, $msg, $data, $httpStatus,...$options);
    }


    /**
     * @notes 接口操作失败，返回信息
     * @param string $msg 信息
     * @param array $data 数据
     * @param int $code 状态码
     * @param int $show 是否显示
     * @param int $httpStatus http状态码
     * @param int $options 可选 JSON_UNESCAPED_UNICODE json 格式化
     * @author 乔峰
     * @date 2021/12/24 18:28
     */
    public static function fail(string $msg = 'fail', array $data = [], int $code = 0, int $show = 1, int $httpStatus = 200,...$options): Response
    {
        return self::result($code, $show, $msg, $data, $httpStatus,...$options);
    }

    /**
     * @notes 接口返回数据
     * @param array $data 数据
     * @author 乔峰
     * @date 2021/12/24 18:29
     */
    public static function data(array $data): Response
    {
        return self::success('', $data, 1, 0);
    }

    /**
     * @notes 接口返回信息
     * @param int $code 状态码
     * @param int $show 是否显示
     * @param string $msg 信息
     * @param array $data 数据
     * @param int $httpStatus http状态码
     * @param int $options 可选 JSON_UNESCAPED_UNICODE json 格式化
     * @author 乔峰
     * @date 2021/12/24 18:29
     */
    private static function result(int $code, int $show, string $msg = 'OK', array $data = [], int $httpStatus = 200,...$options): Response
    {
        $result = compact('code', 'show', 'msg', 'data');
        return response(json_encode($result,...$options),$httpStatus,['Content-Type' => 'application/json; charset=utf-8']);
    }

    /**
     * @notes 抛出异常json
     * @param string $msg 信息
     * @param array $data 数据
     * @param int $code 状态码
     * @param int $show 是否显示
     * @author 乔峰
     * @date 2021/12/24 18:29
     */
    public static function throw(string $msg = 'fail', array $data = [], int $code = 0, int $show = 1)
    {
        $data = compact('code', 'show', 'msg', 'data');
        throw new HttpException(json_encode($data));
    }

    /**
     * @notes 数据列表
     * @param BaseDataLists $lists 数据列表
     * @author 令狐冲
     * @date 2021/7/28 11:15
     */
    public static function dataLists(BaseDataLists $lists): Response
    {
        //获取导出信息
        if ($lists->export == ExportEnum::INFO && $lists instanceof ListsExcelInterface) {
            return self::data($lists->excelInfo());
        }

        //获取导出文件的下载链接
        if ($lists->export == ExportEnum::EXPORT && $lists instanceof ListsExcelInterface) {
            //todo 改前端导出 新加判定是否需要调用分批导出
            $exportDownloadUrl = $lists->createExcel($lists->setExcelFields(), $lists->lists());
            return self::success('', ['url' => $exportDownloadUrl], 2);
        }

        $data = [
            'lists' => $lists->lists(),
            'count' => $lists->count(),
            'page_no' => $lists->pageNo,
            'page_size' => $lists->pageSize,
        ];
        $data['extend'] = [];
        if ($lists instanceof ListsExtendInterface) {
            $data['extend'] = $lists->extend();
        }
        return self::success('', $data, 1, 0);
    }
}