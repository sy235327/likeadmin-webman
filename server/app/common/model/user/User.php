<?php


namespace app\common\model\user;


use app\common\enum\user\UserEnum;
use app\common\model\BaseModel;
use app\common\service\FileService;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;
use think\model\concern\SoftDelete;
use think\model\relation\HasOne;

/**
 * 用户模型
 * Class User
 * @package app\common\model\user
 * @property int $id 主键 主键
 * @property int $sn 编号
 * @property string $avatar 头像
 * @property string $real_name 真实姓名
 * @property string $nickname 用户昵称
 * @property string $account 用户账号
 * @property string $password 用户密码
 * @property string $mobile 用户电话
 * @property int $sex 用户性别: [1=男, 2=女]
 * @property int $channel 注册渠道: [1-微信小程序 2-微信公众号 3-手机H5 4-电脑PC 5-苹果APP 6-安卓APP]
 * @property int $is_disable 是否禁用: [0=否, 1=是]
 * @property string $login_ip 最后登录IP
 * @property int $login_time 最后登录时间
 * @property int $is_new_user 是否是新注册用户: [1-是, 0-否]
 * @property float $user_money 用户余额
 * @property float $total_recharge_amount 累计充值
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 * @property int $delete_time 删除时间
 */
class User extends BaseModel
{
    use SoftDelete;
    protected $name = 'user';
    protected $deleteTime = 'delete_time';
    //设置字段信息
    protected $schema = [
        //主键 主键
        'id' => 'int',
        //编号
        'sn' => 'int',
        //头像
        'avatar' => 'string',
        //真实姓名
        'real_name' => 'string',
        //用户昵称
        'nickname' => 'string',
        //用户账号
        'account' => 'string',
        //用户密码
        'password' => 'string',
        //用户电话
        'mobile' => 'string',
        //用户性别: [1=男, 2=女]
        'sex' => 'int',
        //注册渠道: [1-微信小程序 2-微信公众号 3-手机H5 4-电脑PC 5-苹果APP 6-安卓APP]
        'channel' => 'int',
        //是否禁用: [0=否, 1=是]
        'is_disable' => 'int',
        //最后登录IP
        'login_ip' => 'string',
        //最后登录时间
        'login_time' => 'int',
        //是否是新注册用户: [1-是, 0-否]
        'is_new_user' => 'int',
        //用户余额
        'user_money' => 'float',
        //累计充值
        'total_recharge_amount' => 'float',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];


    /**
     * @notes 关联用户授权模型
     * @return HasOne
     * @author 乔峰
     * @date 2022/9/22 16:03
     */
    public function userAuth()
    {
        return $this->hasOne(UserAuth::class, 'user_id');
    }


    /**
     * @notes 搜索器-用户信息
     * @param $query
     * @param $value
     * @param $data
     * @author 乔峰
     * @date 2022/9/22 16:12
     */
    public function searchKeywordAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('sn|nickname|mobile', 'like', '%' . $value . '%');
        }
    }


    /**
     * @notes 搜索器-注册来源
     * @param $query
     * @param $value
     * @param $data
     * @author 乔峰
     * @date 2022/9/22 16:13
     */
    public function searchChannelAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('channel', '=', $value);
        }
    }


    /**
     * @notes 搜索器-注册时间
     * @param $query
     * @param $value
     * @param $data
     * @author 乔峰
     * @date 2022/9/22 16:13
     */
    public function searchCreateTimeStartAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('create_time', '>=', $value);
        }
    }


    /**
     * @notes 搜索器-注册时间
     * @param $query
     * @param $value
     * @param $data
     * @author 乔峰
     * @date 2022/9/22 16:13
     */
    public function searchCreateTimeEndAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('create_time', '<=', $value);
        }
    }


    /**
     * @notes 头像获取器 - 用于头像地址拼接域名
     * @param $value
     * @return string
     * @author Tab
     * @date 2021/7/17 14:28
     */
    public function getAvatarAttr($value)
    {
        return trim($value) ? FileService::getFileUrl($value) : '';
    }


    /**
     * @notes 获取器-性别描述
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 乔峰
     * @date 2022/9/7 15:15
     */
    public function getSexAttr($value, $data)
    {
        return UserEnum::getSexDesc($value);
    }


    /**
     * @notes 登录时间
     * @param $value
     * @return string
     * @author 乔峰
     * @date 2022/9/23 18:15
     */
    public function getLoginTimeAttr($value)
    {
        return $value ? date('Y-m-d H:i:s', $value) : '';
    }

    /**
     * @notes 生成用户编码
     * @param string $prefix
     * @param int $length
     * @return string
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     * @date 2022/9/16 10:33
     */
    public static function createUserSn($prefix = '', $length = 8)
    {
        $rand_str = '';
        for ($i = 0; $i < $length; $i++) {
            $rand_str .= mt_rand(0, 9);
        }
        $sn = $prefix . $rand_str;
        if (User::where(['sn' => $sn])->find()) {
            return self::createUserSn($prefix, $length);
        }
        return $sn;
    }
}