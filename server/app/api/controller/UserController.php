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


use app\api\logic\UserLogic;
use app\api\validate\PasswordValidate;
use app\api\validate\SetUserInfoValidate;
use app\api\validate\UserValidate;
use support\Response;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

/**
 * 用户控制器
 * Class UserController
 * @package app\api\controller
 */
class UserController extends BaseApiController
{
    public array $notNeedLogin = ['resetPassword'];


    /**
     * @notes 获取个人中心
     * @return Response
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 段誉
     * @date 2022/9/16 18:19
     */
    public function center(): Response
    {
        $data = UserLogic::center($this->getUserInfo());
        return $this->success('', $data);
    }


    /**
     * @notes 获取个人信息
     * @return Response
     * @author 段誉
     * @date 2022/9/20 19:46
     */
    public function info(): Response
    {
        $result = UserLogic::info($this->getUserId());
        return $this->data($result);
    }


    /**
     * @notes 重置密码
     * @return Response
     * @author 段誉
     * @date 2022/9/16 18:06
     */
    public function resetPassword(): Response
    {
        $params = (new PasswordValidate())->post()->goCheck('resetPassword');
        $result = UserLogic::resetPassword($params);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(UserLogic::getError());
    }


    /**
     * @notes 修改密码
     * @return Response
     * @author 段誉
     * @date 2022/9/20 19:16
     */
    public function changePassword(): Response
    {
        $params = (new PasswordValidate())->post()->goCheck('changePassword');
        $result = UserLogic::changePassword($params, $this->getUserId());
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(UserLogic::getError());
    }


    /**
     * @notes 获取小程序手机号
     * @return Response
     * @author 段誉
     * @date 2022/9/21 16:46
     */
    public function getMobileByMnp(): Response
    {
        $params = (new UserValidate())->post()->goCheck('getMobileByMnp');
        $params['user_id'] = $this->getUserId();
        $result = UserLogic::getMobileByMnp($params);
        if ($result === false) {
            return $this->fail(UserLogic::getError());
        }
        return $this->success('绑定成功', [], 1, 1);
    }


    /**
     * @notes 编辑用户信息
     * @return Response
     * @author 段誉
     * @date 2022/9/21 17:01
     */
    public function setInfo(): Response
    {
        $params = (new SetUserInfoValidate())->post()->goCheck(null, ['id' => $this->getUserId()]);
        $result = UserLogic::setInfo($this->getUserId(), $params);
        if (false === $result) {
            return $this->fail(UserLogic::getError());
        }
        return $this->success('操作成功', [], 1, 1);
    }


    /**
     * @notes 绑定/变更 手机号
     * @return Response
     * @author 段誉
     * @date 2022/9/21 17:29
     */
    public function bindMobile(): Response
    {
        $params = (new UserValidate())->post()->goCheck('bindMobile');
        $params['user_id'] = $this->getUserId();
        $result = UserLogic::bindMobile($params);
        if($result) {
            return $this->success('绑定成功', [], 1, 1);
        }
        return $this->fail(UserLogic::getError());
    }

}