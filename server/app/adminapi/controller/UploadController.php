<?php


namespace app\adminapi\controller;


use app\common\service\UploadService;
use Exception;
use Tinywan\Storage\Storage;

class UploadController extends BaseAdminController
{
    /**
     * 获取上传凭证
     * @return \support\Response
     */
    public function getUploadToken(): \support\Response
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
     * @return \support\Response
     */
    public function image(): \support\Response
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
     * @return \support\Response
     */
    public function video(): \support\Response
    {
        $cid = $this->request->post('cid', 0);
        $uploadObj = (new UploadService());
        $result = $uploadObj->video($cid);
        if ($result===false){
            return $this->fail($uploadObj->getError());
        }
        return $this->success('上传成功', $result);
    }
}