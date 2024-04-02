<?php


namespace app\adminapi\controller\user;


use app\adminapi\controller\BaseAdminController;
use app\adminapi\lists\user\UserLists;
use app\adminapi\logic\user\UserLogic;
use app\adminapi\validate\user\AdjustUserMoney;
use app\adminapi\validate\user\UserValidate;

class UserController extends BaseAdminController
{
    /**
     * @notes 用户列表
     * @author 乔峰
     * @date 2022//22 16:16
     */
    public function lists()
    {
        return $this->dataLists(new UserLists());
    }


    /**
     * @notes 获取用户详情
     * @author 乔峰
     * @date 2022/9/22 16:34
     */
    public function detail()
    {
        $params = (new UserValidate())->goCheck('detail');
        $detail = UserLogic::detail($params['id']);
        return $this->success('', $detail);
    }


    /**
     * @notes 编辑用户信息
     * @author 乔峰
     * @date 2022/9/22 16:34
     */
    public function edit()
    {
        $params = (new UserValidate())->post()->goCheck('setInfo');
        UserLogic::setUserInfo($params);
        return $this->success('操作成功', [], 1, 1);
    }

    /**
     * @notes 调整用户余额
     * @return \support\Response
     * @author bingo
     * @date 2023/2/23 14:33
     */
    public function adjustMoney()
    {
        $params = (new AdjustUserMoney())->post()->goCheck();
        $res = UserLogic::adjustUserMoney($params);
        if (true === $res) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail($res);
    }
}