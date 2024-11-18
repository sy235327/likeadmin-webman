<?php


namespace app\common\model\tools;

use app\common\enum\GeneratorEnum;
use app\common\model\BaseModel;
use think\model\relation\HasMany;


/**
 * 代码生成器-数据表信息模型
 * Class GenerateTable
 * @package app\common\model\tools
 * @property int $id 主键 id
 * @property string $table_name 表名称
 * @property string $table_comment 表描述
 * @property int $template_type 模板类型 0-单表(curd) 1-树表(curd)
 * @property string $author 作者
 * @property string $remark 备注
 * @property int $generate_type 生成方式  0-压缩包下载 1-生成到模块
 * @property string $module_name 模块名
 * @property string $class_dir 类目录名
 * @property string $class_comment 类描述
 * @property int $admin_id 管理员id
 * @property string $menu 菜单配置
 * @property string $delete 删除配置
 * @property string $tree 树表配置
 * @property string $relations 关联配置
 * @property int $create_time 创建时间
 * @property int $update_time 修改时间
 */
class GenerateTable extends BaseModel
{

    protected $name = 'generate_table';

    //设置字段信息
    protected $schema = [
        //主键 id
        'id' => 'int',
        //表名称
        'table_name' => 'string',
        //表描述
        'table_comment' => 'string',
        //模板类型 0-单表(curd) 1-树表(curd)
        'template_type' => 'int',
        //作者
        'author' => 'string',
        //备注
        'remark' => 'string',
        //生成方式  0-压缩包下载 1-生成到模块
        'generate_type' => 'int',
        //模块名
        'module_name' => 'string',
        //类目录名
        'class_dir' => 'string',
        //类描述
        'class_comment' => 'string',
        //管理员id
        'admin_id' => 'int',
        //菜单配置
        'menu' => 'string',
        //删除配置
        'delete' => 'string',
        //树表配置
        'tree' => 'string',
        //关联配置
        'relations' => 'string',
        //创建时间
        'create_time' => 'int',
        //修改时间
        'update_time' => 'int',
    ];
    protected $json = ['menu', 'tree', 'relations', 'delete'];

    protected $jsonAssoc = true;

    /**
     * @notes 关联数据表字段
     * @return HasMany
     * @author bingo
     * @date 2022/6/15 10:46
     */
    public function tableColumn()
    {
        return $this->hasMany(GenerateColumn::class, 'table_id', 'id');
    }

    /**
     * @notes 模板类型描述
     * @param $value
     * @param $data
     * @return string|string[]
     * @author bingo
     * @date 2022/6/14 11:25
     */
    public function getTemplateTypeDescAttr($value, $data)
    {
        return GeneratorEnum::getTemplateTypeDesc($data['template_type']);
    }



}