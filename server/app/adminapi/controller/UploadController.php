<?php


namespace app\adminapi\controller;


use app\common\service\UploadService;
use Exception;
use support\Response;
use Tinywan\Storage\Storage;

class UploadController extends BaseAdminController
{
    /**
     * 获取上传凭证
     * @return Response
     */
    public function getUploadToken(): Response
    {

        $name = $this->request->post('name', '');
        $size = $this->request->post('size', '');
        $uploadObj = (new UploadService());
        $result = $uploadObj->getUploadToken($name,$size);
        if ($result===false){
            return $this->fail($uploadObj->getError());
        }
        return $this->data($result);
    }
    /**
     * @notes 上传图片
     * @author 乔峰
     * @date 2021/12/29 16:27
     * @return Response
     */
    public function image(): Response
    {
        $cid = $this->request->post('cid', 0);
        $uploadObj = (new UploadService());
        $result = $uploadObj->image($cid);
        if ($result===false){
            return $this->fail($uploadObj->getError());
        }
        return $this->success('上传成功', $result);
    }

    /**
     * @notes 上传视频
     * @author 乔峰
     * @date 2021/12/29 16:27
     * @return Response
     */
    public function video(): Response
    {
        $cid = $this->request->post('cid', 0);
        $uploadObj = (new UploadService());
        $result = $uploadObj->video($cid);
        if ($result===false){
            return $this->fail($uploadObj->getError());
        }
        return $this->success('上传成功', $result);
    }


    /**
     * @notes 上传文件
     * @return Response
     * @author dw
     * @date 2023/06/26
     */
    public function file(): Response
    {
        $cid = $this->request->post('cid', 0);
        $uploadObj = (new UploadService());
        $result = $uploadObj->file($cid);
        if ($result===false){
            return $this->fail($uploadObj->getError());
        }
        return $this->success('上传成功', $result);
    }
}