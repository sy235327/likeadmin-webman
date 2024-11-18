<?php


namespace app\adminapi\validate\user;


use app\common\model\user\User;
use app\common\validate\BaseValidate;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class UserValidate extends BaseValidate
{
    protected $rule = [
        'id' => 'require|checkUser',
        'field' => 'require|checkField',
        'value' => 'require',
    ];

    protected $message = [
        'id.require' => '请选择用户',
        'field.require' => '请选择操作',
        'value.require' => '请输入内容',
    ];


    /**
     * @notes 详情场景
     * @return UserValidate
     * @author 乔峰
     * @date 2022/9/22 16:35
     */
    public function sceneDetail(): UserValidate
    {
        return $this->only(['id']);
    }


    /**
     * @notes 用户信息校验
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     * @date 2022/9/22 17:03
     */
    public function checkUser($value, $rule, $data): bool|string
    {
        $userIds = is_array($value) ? $value : [$value];

        foreach ($userIds as $item) {
            if (!User::find($item)) {
                return '用户不存在！';
            }
        }
        return true;
    }


    /**
     * @notes 校验是否可更新信息
     * @param $value
     * @param $rule
     * @param $data
     * @return bool|string
     * @author 乔峰
     * @date 2022/9/22 16:37
     */
    public function checkField($value, $rule, $data): bool|string
    {
        $allowField = ['account', 'sex', 'mobile', 'real_name'];

        if (!in_array($value, $allowField)) {
            return '用户信息不允许更新';
        }

        switch ($value) {
            case 'account':
                //验证手机号码是否存在
                $account = User::where([
                    ['id', '<>', $data['id']],
                    ['account', '=', $data['value']]
                ])->findOrEmpty();

                if (!$account->isEmpty()) {
                    return '账号已被使用';
                }
                break;

            case 'mobile':
                if (false == $this->validate($data['value'], 'mobile', $data)) {
                    return '手机号码格式错误';
                }

                //验证手机号码是否存在
                $mobile = User::where([
                    ['id', '<>', $data['id']],
                    ['mobile', '=', $data['value']]
                ])->findOrEmpty();

                if (!$mobile->isEmpty()) {
                    return '手机号码已存在';
                }
                break;
        }
        return true;
    }
}