<?php


namespace app\common\model\user;


use app\common\model\BaseModel;

/**
 * 用户授权表
 * Class UserAuth
 * @package app\common\model\user
 * @property int $id 主键
 * @property int $user_id 用户id
 * @property string $openid 微信openid
 * @property string $unionid 微信unionid
 * @property int $terminal 客户端类型：1-微信小程序；2-微信公众号；3-手机H5；4-电脑PC；5-苹果APP；6-安卓APP
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间
 */
class UserAuth extends BaseModel
{

    protected $name = 'user_auth';

    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //用户id
        'user_id' => 'int',
        //微信openid
        'openid' => 'string',
        //微信unionid
        'unionid' => 'string',
        //客户端类型：1-微信小程序；2-微信公众号；3-手机H5；4-电脑PC；5-苹果APP；6-安卓APP
        'terminal' => 'int',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
    ];

}