<?php
// +----------------------------------------------------------------------
// | likeadmin快速开发前后端分离管理后台（PHP版）
// +----------------------------------------------------------------------
// | 欢迎阅读学习系统程序代码，建议反馈是我们前进的动力
// | 开源版本可自由商用，可去除界面版权logo
// | gitee下载：https://gitee.com/likeshop_gitee/likeadmin
// | github下载：https://github.com/likeshop-github/likeadmin
// | 访问官网：https://www.likeadmin.cn
// | likeadmin团队 版权所有 拥有最终解释权
// +----------------------------------------------------------------------
// | author: likeadminTeam
// +----------------------------------------------------------------------

namespace app\api\controller;

use app\common\enum\FileEnum;
use app\common\service\UploadService;
use Exception;
use support\Response;
use think\response\Json;


/** 上传文件
 * Class UploadController
 * @package app\api\controller
 */
class UploadController extends BaseApiController
{

    /**
     * @notes 上传图片
     * @author 段誉
     * @date 2022/9/20 18:11
     * @return Response
     */
    public function image(): Response
    {
        $uploadObj = (new UploadService());
        $result = $uploadObj->image(0,$this->userId,FileEnum::SOURCE_USER);
        if ($result===false){
            return $this->fail($uploadObj->getError());
        }
        return $this->success('上传成功', $result);
    }

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
}