<?php


namespace app\common\model;


use app\common\service\FileService;
use Closure;
use Generator;
use think\db\BaseQuery;
use think\db\Query;
use think\Model;
use think\model\Collection;
use think\Paginator;

/**
 * Class BaseModel 基础模型
 * @property string $name 表名;
 * @property string $deleteTime 删除时间;
 *
 * Class Model 框架基础模型
 * @package think
 * @mixin Query
 * @method void onAfterRead(Model $model) static after_read事件定义
 * @method mixed onBeforeInsert(Model $model) static before_insert事件定义
 * @method void onAfterInsert(Model $model) static after_insert事件定义
 * @method mixed onBeforeUpdate(Model $model) static before_update事件定义
 * @method void onAfterUpdate(Model $model) static after_update事件定义
 * @method mixed onBeforeWrite(Model $model) static before_write事件定义
 * @method void onAfterWrite(Model $model) static after_write事件定义
 * @method mixed onBeforeDelete(Model $model) static before_write事件定义
 * @method void onAfterDelete(Model $model) static after_delete事件定义
 * @method void onBeforeRestore(Model $model) static before_restore事件定义
 * @method void onAfterRestore(Model $model) static after_restore事件定义
 * @method Query where(mixed $field, string $op = null, mixed $condition = null) static 查询条件
 * @method Query whereTime(string $field, string $op, mixed $range = null) static 查询日期和时间
 * @method Query whereBetweenTime(string $field, mixed $startTime, mixed $endTime) static 查询日期或者时间范围
 * @method Query whereBetweenTimeField(string $startField, string $endField) static 查询当前时间在两个时间字段范围
 * @method Query whereYear(string $field, string $year = 'this year') static 查询某年
 * @method Query whereMonth(string $field, string $month = 'this month') static 查询某月
 * @method Query whereDay(string $field, string $day = 'today') static 查询某日
 * @method Query whereRaw(string $where, array $bind = []) static 表达式查询
 * @method Query whereExp(string $field, string $condition, array $bind = []) static 字段表达式查询
 * @method Query when(mixed $condition, mixed $query, mixed $otherwise = null) static 条件查询
 * @method Query join(mixed $join, mixed $condition = null, string $type = 'INNER') static JOIN查询
 * @method Query view(mixed $join, mixed $field = null, mixed $on = null, string $type = 'INNER') static 视图查询
 * @method Query with(mixed $with) static 关联预载入
 * @method int count(string $field) static Count统计查询
 * @method Query min(string $field) static Min统计查询
 * @method Query max(string $field) static Max统计查询
 * @method Query sum(string $field) static SUM统计查询
 * @method Query avg(string $field) static Avg统计查询
 * @method Query field(mixed $field, boolean $except = false) static 指定查询字段
 * @method Query fieldRaw(string $field, array $bind = []) static 指定查询字段
 * @method Query union(mixed $union, boolean $all = false) static UNION查询
 * @method Query limit(mixed $offset, integer $length = null) static 查询LIMIT
 * @method Query order(mixed $field, string $order = null) static 查询ORDER
 * @method Query orderRaw(string $field, array $bind = []) static 查询ORDER
 * @method Query cache(mixed $key = null, integer $expire = null) static 设置查询缓存
 * @method mixed value(string $field) static 获取某个字段的值
 * @method array column(string $field, string $key = '') static 获取某个列的值
 * @method Model find(mixed $data = null) static 查询单个记录 不存在返回Null
 * @method Model findOrEmpty(mixed $data = null) static 查询单个记录 不存在返回空模型
 * @method Collection select(mixed $data = null) static 查询多个记录
 * @method Model withAttr(array $name, Closure $closure) 动态定义获取器
 *
 * Class DbManager 数据库管理类
 * @package think
 * @mixin BaseQuery
 * @mixin Query
 * @method Query master() static 从主服务器读取数据
 * @method Query readMaster(bool $all = false) static 后续从主服务器读取数据
 * @method Query table(string $table) static 指定数据表（含前缀）
 * @method Query name(string $name) static 指定数据表（不含前缀）
 * @method Query withAttr(string $name, callable $callback = null) static 使用获取器获取数据
 * @method integer insert(array $data, boolean $replace = false, boolean $getLastInsID = false, string $sequence = null) static 插入一条记录
 * @method integer insertGetId(array $data, boolean $replace = false, string $sequence = null) static 插入一条记录并返回自增ID
 * @method integer insertAll(array $dataSet) static 插入多条记录
 * @method integer update(array $data) static 更新记录
 * @method integer delete(mixed $data = null) static 删除记录
 * @method boolean chunk(integer $count, callable $callback, string $column = null) static 分块获取数据
 * @method Generator cursor(mixed $data = null) static 使用游标查找记录
 * @method mixed query(string $sql, array $bind = [], boolean $master = false, bool $pdo = false) static SQL查询
 * @method integer execute(string $sql, array $bind = [], boolean $fetch = false, boolean $getLastInsID = false, string $sequence = null) static SQL执行
 * @method Paginator paginate(integer $listRows = 15, mixed $simple = null, array $config = []) static 分页查询
 * @method mixed transaction(callable $callback) static 执行数据库事务
 * @method void startTrans() static 启动事务
 * @method void commit() static 用于非自动提交状态下面的查询提交
 * @method void rollback() static 事务回滚
 * @method boolean batchQuery(array $sqlArray) static 批处理执行SQL语句
 * @method string getLastInsID(string $sequence = null) static 获取最近插入的ID
 */
class BaseModel extends Model
{
    /**
     * @notes 公共处理图片,补全路径
     * @param $value
     * @return string
     * @author 乔峰
     * @date 2021/9/10 11:02
     */
    public function getImageAttr($value): string
    {
        return trim($value) ? FileService::getFileUrl($value) : '';
    }

    /**
     * @notes 公共图片处理,去除图片域名
     * @param $value
     * @return mixed|string
     * @author 乔峰
     * @date 2021/9/10 11:04
     */
    public function setImageAttr($value): mixed
    {
        return trim($value) ? FileService::setFileUrl($value) : '';
    }
}