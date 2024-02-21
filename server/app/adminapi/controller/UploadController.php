<?php


namespace app\adminapi\controller;


use app\common\service\UploadService;
use Exception;
use Tinywan\Storage\Storage;

class UploadController extends BaseAdminController
{
    /**
     * @notes 上传图片
     * @author 乔峰
     * @date 2021/12/29 16:27
     */
    public function image()
    {
        try {
            $cid = $this->request->post('cid', 0);
            $result = UploadService::image($cid);
            return $this->success('上传成功', $result);
        } catch (Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    /**
     * @notes 上传视频
     * @author 乔峰
     * @date 2021/12/29 16:27
     */
    public function video()
    {
        try {
            $cid = $this->request->post('cid', 0);
            $result = UploadService::video($cid);
            return $this->success('上传成功', $result);
        } catch (Exception $e) {
            return $this->fail($e->getMessage());
        }
    }
}