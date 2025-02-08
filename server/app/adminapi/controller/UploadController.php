<?php


namespace app\adminapi\controller;


use app\common\enum\FileEnum;
use app\common\model\file\File;
use app\common\service\FileService;
use app\common\service\UploadService;
use Exception;
use support\Response;
use Tinywan\Storage\Storage;

class UploadController extends BaseAdminController
{
    /**
     * 使用凭证上传文件后回调获取对象
     * @return Response
     */
    public function setUploadFile(): Response{
        $cid = input('cid',0);
        $typeStr = input('type','');
        $type = FileEnum::IMAGE_TYPE;
        if ($typeStr){
            $type = FileEnum::TYPE_MAP[$typeStr];
        }
        $source_id = $this->adminId;
        $source = FileEnum::SOURCE_ADMIN;
        $name = input('name','');
        $uri = input('uri','');
        $fileObj = File::create([
            'cid' => $cid,
            'source_id' => $source_id,
            'source' => $source,
            'type' => $type,
            'name' => $name,
            'uri' => FileService::setFileUrl($uri),
        ]);
        return $this->success('上传成功', $fileObj->toArray());
    }
    /**
     * 获取上传凭证
     * @return Response
     */
    public function getUploadToken(): Response
    {
        $name = $this->request->post('name', '');
        $size = $this->request->post('size', '');
        $contentType = $this->request->post('contentType', 'image/png');
        $uploadObj = (new UploadService());
        $result = $uploadObj->getUploadToken($name,$size,$contentType);
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