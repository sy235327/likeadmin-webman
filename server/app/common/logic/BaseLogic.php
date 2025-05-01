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


namespace app\common\logic;


use app\common\enum\ContextEnum;
use support\Context;
use think\facade\Db;

/**
 * 逻辑基类
 * Class BaseLogic
 * @package app\common\logic
 */
class BaseLogic
{
    /**
     * @notes 获取错误信息
     * @return string
     * @author 乔峰
     * @date 2021/7/21 18:23
     */
    public static function getError() : string
    {
        $error =  Context::get(ContextEnum::RETURN_CODE_KEY,null);
        if (null === $error) {
            return '系统错误';
        }
        return $error;
    }


    /**
     * @notes 设置错误信息
     * @param $error
     * @author 乔峰
     * @date 2021/7/21 18:20
     */
    public static function setError($error) : void
    {
        Context::set(ContextEnum::RETURN_CODE_KEY,$error);
    }


    /**
     * @notes 是否存在错误
     * @return bool
     * @author 乔峰
     * @date 2021/7/21 18:32
     */
    public static function hasError() : bool
    {
        $error =  Context::get(ContextEnum::RETURN_CODE_KEY,null);
        if (null === $error) {
            return false;
        }
        return true;
    }


    /**
     * @notes 设置状态码
     * @param $code
     * @author 乔峰
     * @date 2021/7/28 17:05
     */
    public static function setReturnCode($code) : void
    {
        Context::set(ContextEnum::RETURN_CODE_KEY,0);
    }


    /**
     * @notes 特殊场景返回指定状态码,默认为0
     * @return int
     * @author 乔峰
     * @date 2021/7/28 15:14
     */
    public static function getReturnCode() : int
    {
        return Context::get(ContextEnum::RETURN_CODE_KEY,0);
    }

    /**
     * @notes 获取内容
     * @return mixed
     * @author cjhao
     * @date 2021/9/11 17:29
     */
    public static function getReturnData(): mixed
    {
        return Context::get(ContextEnum::RETURN_DATA_KEY,null);
    }
    public static function setReturnData($data) : void
    {
        Context::set(ContextEnum::RETURN_DATA_KEY,$data);
    }
    public static function base_startTrans(): void
    {
        $transNumber = Context::get(ContextEnum::TRANS_NUMBER_KEY,0);
        if ($transNumber == 0){
            Db::startTrans();
        }
        $transNumber++;
        Context::set(ContextEnum::TRANS_NUMBER_KEY,$transNumber);
    }
    public static function base_rollback($msg,$data = null,$code = -1): false
    {
        $transNumber = 0;
        Context::set(ContextEnum::TRANS_NUMBER_KEY,$transNumber);
        Db::rollback();
        self::setError($msg);
        self::setReturnData($data);
        self::setReturnCode($code);
        return false;
    }
    public static function base_commit($data = null,$code = 0): true
    {
        $transNumber = Context::get(ContextEnum::TRANS_NUMBER_KEY,0);
        $transNumber--;
        Context::set(ContextEnum::TRANS_NUMBER_KEY,$transNumber);
        if ($transNumber == 0){
            Db::commit();
        }
        self::setReturnData($data);
        self::setReturnCode($code);
        return true;
    }

}