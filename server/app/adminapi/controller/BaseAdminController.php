<?php


namespace app\adminapi\controller;


use app\common\controller\BaseLikeAdminController;
use app\common\enum\ContextEnum;
use app\common\lists\BaseDataLists;
use support\Context;

class BaseAdminController extends BaseLikeAdminController
{
    public array $notNeedLogin = [];

    public function setAdmin(int $adminId,array $adminInfo): void
    {
        Context::set(ContextEnum::ADMIN_ID_KEY, $adminId);
        Context::set(ContextEnum::ADMIN_INFO_KEY, $adminInfo);
    }
    public function getAdmin(): array
    {
        return [
            Context::get(ContextEnum::ADMIN_ID_KEY,0),
            Context::get(ContextEnum::ADMIN_INFO_KEY,[]),
        ];
    }
    public function setAdminId($adminId): void
    {
        Context::set(ContextEnum::ADMIN_ID_KEY, $adminId);
    }
    public function setAdminInfo($adminInfo): void
    {
        Context::set(ContextEnum::ADMIN_INFO_KEY, $adminInfo);
    }
    public function getAdminId(): int
    {
        return Context::get(ContextEnum::ADMIN_ID_KEY,0);
    }
    public function getAdminInfo(): array
    {
        return Context::get(ContextEnum::ADMIN_INFO_KEY,[]);
    }

    /**
     * @throws \Exception
     */
    public function __get($name) {
        if ($name == ContextEnum::ADMIN_ID_KEY){
            return $this->getAdminId();
        }
        if ($name == ContextEnum::ADMIN_INFO_KEY){
            return $this->getAdminInfo();
        }
        return parent::__get($name);
    }

    /**
     * @throws \Exception
     */
    public function __set($name, $value) {
        if ($name == ContextEnum::ADMIN_ID_KEY){
            $this->setAdminId($value);
        }
        if ($name == ContextEnum::ADMIN_INFO_KEY){
            $this->setAdminInfo($value);
        }
        parent::__set($name,$value);
    }

    public function __isset($name) {
        $res = null;
        if ($name == ContextEnum::ADMIN_ID_KEY){
            $res = $this->getAdminId();
        }
        if ($name == ContextEnum::ADMIN_INFO_KEY){
            $res = $this->getAdminInfo();
        }
        return isset($res);
    }

    public function __unset($name) {
        $res = null;
        if ($name == ContextEnum::ADMIN_ID_KEY){
            $res = $this->getAdminId();
        }
        if ($name == ContextEnum::ADMIN_INFO_KEY){
            $res = $this->getAdminInfo();
        }
        unset($res);
    }
}