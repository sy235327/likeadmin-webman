<?php

namespace app\common\service;

use think\facade\Db;

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
     * 事务开启层级
     * @var int
     */
    private int $transNumber = 0;

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

    public function setReturnData(mixed $data) : void
    {
        $this->returnData = $data;
    }


    public function base_startTrans(): void
    {
        if ($this->transNumber == 0){
            Db::startTrans();
        }
        $this->transNumber++;
    }
    public function base_rollback($msg,$data = null,$code = -1): false
    {
        $this->transNumber = 0;
        Db::rollback();
        $this->setError($msg);
        $this->setReturnData($data);
        $this->setReturnCode($code);
        return false;
    }
    public function base_commit($data = null,$code = 0): true
    {
        $this->transNumber--;
        if ($this->transNumber == 0){
            Db::commit();
        }
        $this->setReturnData($data);
        $this->setReturnCode($code);
        return true;
    }
}