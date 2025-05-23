<?php


namespace app\adminapi\controller;


use app\common\cache\ExportCache;
use app\common\service\JsonService;
use support\think\Cache;
use Webman\Http\Response;

class DownloadController extends BaseAdminController
{
    public array $notNeedLogin = ['export'];

    /**
     * @notes 导出文件
     * @author 乔峰
     * @date 2022/11/24 16:10
     */
    public function export(): \support\Response|Response
    {
        //获取文件缓存的key
        $fileKey = request()->get('file');

        //通过文件缓存的key获取文件储存的路径
        $exportCache = new ExportCache();
        $fileInfo = $exportCache->getFile($fileKey);

        if (empty($fileInfo)) {
            return JsonService::fail('下载文件不存在');
        }

        //下载前删除缓存
        Cache::delete($fileKey);

        return response()->download($fileInfo['src'] . $fileInfo['name'],$fileInfo['name']);
    }
}