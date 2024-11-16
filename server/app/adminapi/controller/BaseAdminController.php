<?php


namespace app\adminapi\controller;


use app\common\controller\BaseLikeAdminController;
use app\common\lists\BaseDataLists;

class BaseAdminController extends BaseLikeAdminController
{
    public array $notNeedLogin = [];

    protected $adminId = 0;
    protected $adminInfo = [];

    public function initialize()
    {
        parent::initialize();
    }
    public function setAdmin($adminId,$adminInfo): void
    {
        $this->adminId = $adminId;
        $this->adminInfo = $adminInfo;
    }
    public function getAdmin(): array
    {
        return [
            $this->adminId,
            $this->adminInfo
        ];
    }
}