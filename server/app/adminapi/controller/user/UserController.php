<?php


namespace app\adminapi\controller\user;


use app\adminapi\controller\BaseAdminController;
use app\adminapi\lists\user\UserLists;
use app\adminapi\logic\user\UserLogic;
use app\adminapi\validate\user\AdjustUserMoney;
use app\adminapi\validate\user\UserValidate;
use support\Response;

class UserController extends BaseAdminController
{
    private UserValidate $validateObj;

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new UserValidate();
    }
    /**
     * @notes 用户列表
     * @author 乔峰
     * @date 2022//22 16:16
     */
    public function lists(): Response
    {
        return $this->dataLists(new UserLists());
    }


    /**
     * @notes 获取用户详情
     * @author 乔峰
     * @date 2022/9/22 16:34
     */
    public function detail(): Response
    {
        $params = $this->validateObj->goCheck('detail');
        $detail = UserLogic::detail($params['id']);
        return $this->success('', $detail);
    }


    /**
     * @notes 编辑用户信息
     * @author 乔峰
     * @date 2022/9/22 16:34
     */
    public function edit(): Response
    {
        $params = $this->validateObj->post()->goCheck('setInfo');
        UserLogic::setUserInfo($params);
        return $this->success('操作成功', [], 1, 1);
    }

    /**
     * @notes 调整用户余额
     * @return Response
     * @author bingo
     * @date 2023/2/23 14:33
     */
    public function adjustMoney(): Response
    {
        $params = (new AdjustUserMoney())->post()->goCheck();
        $res = UserLogic::adjustUserMoney($params);
        if (true === $res) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail($res);
    }
}