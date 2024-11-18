<?php


namespace app\common\model;


/**
 * 系统日志表模型
 * Class OperationLog
 * @package app\common\model
 * @property int $id 主键
 * @property int $admin_id 管理员ID
 * @property string $admin_name 管理员名称
 * @property string $account 管理员账号
 * @property string $action 操作名称
 * @property string $type 请求方式
 * @property string $url 访问链接
 * @property string $params 请求数据
 * @property string $result 请求结果
 * @property string $ip ip地址
 * @property int $create_time 创建时间

 */
class OperationLog extends BaseModel
{
    protected $name = 'operation_log';

    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //管理员ID
        'admin_id' => 'int',
        //管理员名称
        'admin_name' => 'string',
        //管理员账号
        'account' => 'string',
        //操作名称
        'action' => 'string',
        //请求方式
        'type' => 'string',
        //访问链接
        'url' => 'string',
        //请求数据
        'params' => 'string',
        //请求结果
        'result' => 'string',
        //ip地址
        'ip' => 'string',
        //创建时间
        'create_time' => 'int',
    ];

}