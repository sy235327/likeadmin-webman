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


use think\facade\Db;

/**
 * 逻辑基类
 * Class BaseLogic
 * @package app\common\logic
 */
class BaseLogic
{
    /**
     * 错误信息
     * @var string|null
     */
    protected static string|null $error;

    /**
     * 返回状态码
     * @var int
     */
    protected static int $returnCode = 0;


    /**
     * @var mixed 返回数据
     */
    protected static mixed $returnData;

    /**
     * 事务层级
     * @var int
     */
    private static int $transNumber = 0;


    /**
     * @notes 获取错误信息
     * @return string
     * @author 乔峰
     * @date 2021/7/21 18:23
     */
    public static function getError() : string
    {
        if (false === self::hasError()) {
            return '系统错误';
        }
        return self::$error;
    }


    /**
     * @notes 设置错误信息
     * @param $error
     * @author 乔峰
     * @date 2021/7/21 18:20
     */
    public static function setError($error) : void
    {
        !empty($error) && self::$error = $error;
    }


    /**
     * @notes 是否存在错误
     * @return bool
     * @author 乔峰
     * @date 2021/7/21 18:32
     */
    public static function hasError() : bool
    {
        return !empty(self::$error);
    }


    /**
     * @notes 设置状态码
     * @param $code
     * @author 乔峰
     * @date 2021/7/28 17:05
     */
    public static function setReturnCode($code) : void
    {
        self::$returnCode = $code;
    }


    /**
     * @notes 特殊场景返回指定状态码,默认为0
     * @return int
     * @author 乔峰
     * @date 2021/7/28 15:14
     */
    public static function getReturnCode() : int
    {
        return self::$returnCode;
    }

    /**
     * @notes 获取内容
     * @return mixed
     * @author cjhao
     * @date 2021/9/11 17:29
     */
    public static function getReturnData(): mixed
    {
        return self::$returnData;
    }
    public static function setReturnData($data) : void
    {
        self::$returnData = $data;
    }
    public static function base_startTrans(): void
    {
        if (self::$transNumber == 0){
            Db::startTrans();
        }
        self::$transNumber++;
    }
    public static function base_rollback($msg,$data = null,$code = -1): false
    {
        self::$transNumber = 0;
        Db::rollback();
        self::setError($msg);
        self::setReturnData($data);
        self::setReturnCode($code);
        return false;
    }
    public static function base_commit($data = null,$code = 0): true
    {
        self::$transNumber--;
        if (self::$transNumber == 0){
            Db::commit();
        }
        self::setReturnData($data);
        self::setReturnCode($code);
        return true;
    }

}