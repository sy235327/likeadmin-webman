<?php


namespace app\common\model;


use app\common\service\FileService;
use think\Model;

class BaseModel extends Model
{
    /**
     * @notes 公共处理图片,补全路径
     * @param $value
     * @return string
     * @author 乔峰
     * @date 2021/9/10 11:02
     */
    public function getImageAttr($value)
    {
        return trim($value) ? FileService::getFileUrl($value) : '';
    }

    /**
     * @notes 公共图片处理,去除图片域名
     * @param $value
     * @return mixed|string
     * @author 乔峰
     * @date 2021/9/10 11:04
     */
    public function setImageAttr($value)
    {
        return trim($value) ? FileService::setFileUrl($value) : '';
    }
}