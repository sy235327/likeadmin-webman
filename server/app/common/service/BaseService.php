<?php

namespace app\common\service;

/**
 * 服务基类
 */
class BaseService
{
    /**
     * 错误信息
     * @var string
     */
    protected string $error;

    /**
     * 返回状态码
     * @var int
     */
    protected int $returnCode = 0;

    /**
     * 数据返回
     * @var
     */
    protected mixed $returnData;

    /**
     * @notes 获取错误信息
     * @return string
     * @author 乔峰
     * @date 2021/7/21 18:23
     */
    public function getError() : string
    {
        if (false === $this->hasError()) {
            return '服务错误';
        }
        return $this->error;
    }


    /**
     * @notes 设置错误信息
     * @param $error
     * @author 乔峰
     * @date 2021/7/21 18:20
     */
    public function setError($error) : void
    {
        !empty($error) && $this->error = $error;
    }


    /**
     * @notes 是否存在错误
     * @return bool
     * @author 乔峰
     * @date 2021/7/21 18:32
     */
    public function hasError() : bool
    {
        return !empty($this->error);
    }


    /**
     * @notes 设置状态码
     * @param $code
     * @author 乔峰
     * @date 2021/7/28 17:05
     */
    public function setReturnCode($code) : void
    {
        $this->returnCode = $code;
    }


    /**
     * @notes 特殊场景返回指定状态码,默认为0
     * @return int
     * @author 乔峰
     * @date 2021/7/28 15:14
     */
    public function getReturnCode() : int
    {
        return $this->returnCode;
    }

    /**
     * @notes 获取内容
     * @return mixed
     * @author cjhao
     * @date 2021/9/11 17:29
     */
    public function getReturnData(): mixed
    {
        return $this->returnData;
    }

}