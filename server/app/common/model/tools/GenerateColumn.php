<?php


namespace app\common\model\tools;


use app\common\model\BaseModel;
use think\model\relation\BelongsTo;


/**
 * 代码生成器-数据表字段信息模型
 * Class GenerateColumn
 * @package app\common\model\tools
 * @property int $id 主键 id
 * @property int $table_id 表id
 * @property string $column_name 字段名称
 * @property string $column_comment 字段描述
 * @property string $column_type 字段类型
 * @property int $is_required 是否必填 0-非必填 1-必填
 * @property int $is_pk 是否为主键 0-不是 1-是
 * @property int $is_insert 是否为插入字段 0-不是 1-是
 * @property int $is_update 是否为更新字段 0-不是 1-是
 * @property int $is_lists 是否为列表字段 0-不是 1-是
 * @property int $is_query 是否为查询字段 0-不是 1-是
 * @property string $query_type 查询类型
 * @property string $view_type 显示类型
 * @property string $dict_type 字典类型
 * @property int $create_time 创建时间
 * @property int $update_time 修改时间
 */
class GenerateColumn extends BaseModel
{

    protected $name = 'generate_column';

    //设置字段信息
    protected $schema = [
        //主键 id
        'id' => 'int',
        //表id
        'table_id' => 'int',
        //字段名称
        'column_name' => 'string',
        //字段描述
        'column_comment' => 'string',
        //字段类型
        'column_type' => 'string',
        //是否必填 0-非必填 1-必填
        'is_required' => 'int',
        //是否为主键 0-不是 1-是
        'is_pk' => 'int',
        //是否为插入字段 0-不是 1-是
        'is_insert' => 'int',
        //是否为更新字段 0-不是 1-是
        'is_update' => 'int',
        //是否为列表字段 0-不是 1-是
        'is_lists' => 'int',
        //是否为查询字段 0-不是 1-是
        'is_query' => 'int',
        //查询类型
        'query_type' => 'string',
        //显示类型
        'view_type' => 'string',
        //字典类型
        'dict_type' => 'string',
        //创建时间
        'create_time' => 'int',
        //修改时间
        'update_time' => 'int',
    ];
    /**
     * @notes 关联table表
     * @return BelongsTo
     * @author bingo
     * @date 2022/6/15 18:59
     */
    public function generateTable()
    {
        return $this->belongsTo(GenerateTable::class, 'id', 'table_id');
    }
}