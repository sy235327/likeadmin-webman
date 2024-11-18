<?php


namespace app\common\model;

/**
 * 配置表模型
 * Class Config
 * @package app\common\model
 * @property int $id 主键
 * @property string $type 类型
 * @property string $name 名称
 * @property string $value 值
 * @property int $create_time 创建时间
 * @property int $update_time 更新时间

 */
class Config extends BaseModel
{
    protected $name = 'config';

    //设置字段信息
    protected $schema = [
        //主键
        'id' => 'int',
        //类型
        'type' => 'string',
        //名称
        'name' => 'string',
        //值
        'value' => 'string',
        //创建时间
        'create_time' => 'int',
        //更新时间
        'update_time' => 'int',
    ];

}