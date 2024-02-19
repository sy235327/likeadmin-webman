<?php


namespace app\admin\controller;


use app\common\controller\BaseLikeAdminController;
use app\common\lists\BaseDataLists;

class BaseAdminController extends BaseLikeAdminController
{
    public array $notNeedLogin = [];

    protected $adminId = 0;
    protected $adminInfo = [];

    public function initialize()
    {
        if (isset($this->request->adminInfo) && $this->request->adminInfo) {
            $this->adminInfo = $this->request->adminInfo;
            $this->adminId = $this->request->adminInfo['admin_id'];
        }
    }
}