<?php


namespace app\common\model\auth;


use app\common\enum\YesNoEnum;
use app\common\model\BaseModel;
use app\common\service\FileService;
use think\model\concern\SoftDelete;
/**
 * 管理员表模型
 * Class Admin
 * @package app\common\model\auth
 * @property int $id 主键
 * @property int $root 是否超级管理员 0-否 1-是
 * @property string $name 名称
 * @property string $avatar 用户头像
 * @property string $account 账号
 * @property string $password 密码
 * @property int $login_time 最后登录时间
 * @property string $login_ip 最后登录ip
 * @property int $multipoint_login 是否支持多处登录：1-是；0-否；
 * @property int $disable 是否禁用：0-否；1-是；
 * @property int $create_time 创建时间
 * @property int $update_time 修改时间
 * @property int $delete_time 删除时间

 */
class Admin extends BaseModel
{
    use SoftDelete;

    protected $name = 'admin';
    protected $deleteTime = 'delete_time';

    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //是否超级管理员 0-否 1-是
        'root' => 'int',
        //名称
        'name' => 'string',
        //用户头像
        'avatar' => 'string',
        //账号
        'account' => 'string',
        //密码
        'password' => 'string',
        //最后登录时间
        'login_time' => 'int',
        //最后登录ip
        'login_ip' => 'string',
        //是否支持多处登录：1-是；0-否；
        'multipoint_login' => 'int',
        //是否禁用：0-否；1-是；
        'disable' => 'int',
        //创建时间
        'create_time' => 'int',
        //修改时间
        'update_time' => 'int',
        //删除时间
        'delete_time' => 'int',
    ];
    protected $append = [
        'role_id',
        'dept_id',
        'jobs_id',
    ];


    /**
     * @notes 关联角色id
     * @param $value
     * @param $data
     * @return array
     * @author 乔峰
     * @date 2022/11/25 15:00
     */
    public function getRoleIdAttr($value, $data)
    {
        return AdminRole::where('admin_id', $data['id'])->column('role_id');
    }


    /**
     * @notes 关联部门id
     * @param $value
     * @param $data
     * @return array
     * @author 乔峰
     * @date 2022/11/25 15:00
     */
    public function getDeptIdAttr($value, $data)
    {
        return AdminDept::where('admin_id', $data['id'])->column('dept_id');
    }


    /**
     * @notes 关联岗位id
     * @param $value
     * @param $data
     * @return array
     * @author 乔峰
     * @date 2022/11/25 15:01\
     */
    public function getJobsIdAttr($value, $data)
    {
        return AdminJobs::where('admin_id', $data['id'])->column('jobs_id');
    }



    /**
     * @notes 获取禁用状态
     * @param $value
     * @param $data
     * @return string|string[]
     * @author 令狐冲
     * @date 2021/7/7 01:25
     */
    public function getDisableDescAttr($value, $data)
    {
        return YesNoEnum::getDisableDesc($data['disable']);
    }

    /**
     * @notes 最后登录时间获取器 - 格式化：年-月-日 时:分:秒
     * @param $value
     * @return string
     * @author Tab
     * @date 2021/7/13 11:35
     */
    public function getLoginTimeAttr($value)
    {
        return empty($value) ? '' : date('Y-m-d H:i:s', $value);
    }

    /**
     * @notes 头像获取器 - 头像路径添加域名
     * @param $value
     * @return string
     * @author Tab
     * @date 2021/7/13 11:35
     */
    public function getAvatarAttr($value)
    {
        return empty($value) ? FileService::getFileUrl(config('project.default_image.admin_avatar')) : FileService::getFileUrl(trim($value, '/'));
    }

}