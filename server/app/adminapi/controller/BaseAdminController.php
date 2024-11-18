<?php


namespace app\adminapi\controller;


use app\common\controller\BaseLikeAdminController;
use app\common\lists\BaseDataLists;

class BaseAdminController extends BaseLikeAdminController
{
    public array $notNeedLogin = [];

    protected int $adminId = 0;
    protected array $adminInfo = [];

    public function setAdmin(int $adminId,array $adminInfo): void
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