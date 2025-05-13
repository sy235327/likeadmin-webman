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

use app\common\controller\BaseLikeAdminController;
use app\common\enum\ContextEnum;
use support\Context;

class BaseApiController extends BaseLikeAdminController
{
    public function setUser(int $userId,array $userInfo): void
    {
        Context::set(ContextEnum::USER_ID_KEY, $userId);
        Context::set(ContextEnum::USER_INFO_KEY, $userInfo);
    }
    public function getUser(): array
    {
        return [
            Context::get(ContextEnum::USER_ID_KEY,0),
            Context::get(ContextEnum::USER_INFO_KEY,[]),
        ];
    }
    public function setUserId($userId): void
    {
        Context::set(ContextEnum::USER_ID_KEY, $userId);
    }
    public function setUserInfo($userInfo): void
    {
        Context::set(ContextEnum::USER_INFO_KEY, $userInfo);
    }
    public function getUserId(): int
    {
        return Context::get(ContextEnum::USER_ID_KEY,0);
    }
    public function getUserInfo(): array
    {
        return Context::get(ContextEnum::USER_INFO_KEY,[]);
    }
    /**
     * @throws \Exception
     */
    public function __get($name) {
        if ($name == ContextEnum::USER_ID_KEY){
            return $this->getUserId();
        }
        if ($name == ContextEnum::USER_INFO_KEY){
            return $this->getUserInfo();
        }
        return parent::__get($name);
    }

    /**
     * @throws \Exception
     */
    public function __set($name, $value) {
        if ($name == ContextEnum::USER_ID_KEY){
            $this->setUserId($value);
        }
        if ($name == ContextEnum::USER_INFO_KEY){
            $this->setUserInfo($value);
        }
        parent::__set($name,$value);
    }

    public function __isset($name) {
        $res = null;
        if ($name == ContextEnum::USER_ID_KEY){
            $res = $this->getUserId();
        }
        if ($name == ContextEnum::USER_INFO_KEY){
            $res = $this->getUserInfo();
        }
        return isset($res);
    }

    public function __unset($name) {
        $res = null;
        if ($name == ContextEnum::USER_ID_KEY){
            $res = $this->getUserId();
        }
        if ($name == ContextEnum::USER_INFO_KEY){
            $res = $this->getUserInfo();
        }
        unset($res);
    }
}