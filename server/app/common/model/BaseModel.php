<?php


namespace app\common\model;


use app\common\service\FileService;
use Closure;
use Generator;
use think\Collection as BaseCollection;
use think\db\BaseQuery;
use think\db\Query;
use think\Model;
use think\model\Collection;
use think\Paginator;

/**
 * Class BaseModel 基础模型
 * @mixin BaseQuery
 * @mixin Query
 * @property string $name 表名;
 * @property string $deleteTime 删除时间;
 * @template TKey of array-key
 * @template TModel of static
 * @extends Collection<TKey, TModel>
 * Class Model 框架基础模型
 * @package think
 * @method static void  onAfterRead(Model $model)     after_read事件定义
 * @method static mixed onBeforeInsert(Model $model)  before_insert事件定义
 * @method static void  onAfterInsert(Model $model)   after_insert事件定义
 * @method static mixed onBeforeUpdate(Model $model)  before_update事件定义
 * @method static void  onAfterUpdate(Model $model)   after_update事件定义
 * @method static mixed onBeforeWrite(Model $model)   before_write事件定义
 * @method static void  onAfterWrite(Model $model)    after_write事件定义
 * @method static mixed onBeforeDelete(Model $model)  before_write事件定义
 * @method static void  onAfterDelete(Model $model)   after_delete事件定义
 * @method static void  onBeforeRestore(Model $model) before_restore事件定义
 * @method static void  onAfterRestore(Model $model)  after_restore事件定义
 * @method static Query alias(array | string $alias)  指定数据表别名
 * @method static Query where(mixed $field, string $op = null, mixed $condition = null)  查询条件
 * @method static Query whereTime(string $field, string $op, mixed $range = null) 查询日期和时间
 * @method static Query whereBetweenTime(string $field, mixed $startTime, mixed $endTime) 查询日期或者时间范围
 * @method static Query whereBetweenTimeField(string $startField, string $endField) 查询当前时间在两个时间字段范围
 * @method static Query whereYear(string $field, string $year = 'this year') 查询某年
 * @method static Query whereMonth(string $field, string $month = 'this month') 查询某月
 * @method static Query whereDay(string $field, string $day = 'today') 查询某日
 * @method static Query whereRaw(string $where, array $bind = []) 表达式查询
 * @method static Query whereExp(string $field, string $condition, array $bind = []) 字段表达式查询
 * @method static Query when(mixed $condition, mixed $query, mixed $otherwise = null) 条件查询
 * @method static Query join(mixed $join, mixed $condition = null, string $type = 'INNER') JOIN查询
 * @method static Query view(mixed $join, mixed $field = null, mixed $on = null, string $type = 'INNER') 视图查询
 * @method static Query with(mixed $with) 关联预载入
 * @method static int count(string $field = "1") Count统计查询
 * @method static mixed min(string $field) Min统计查询
 * @method static mixed max(string $field) Max统计查询
 * @method static float sum(string $field) SUM统计查询
 * @method static float avg(string $field) Avg统计查询
 * @method static Query field(mixed $field, boolean $except = false) 指定查询字段
 * @method static Query fieldRaw(string $field, array $bind = []) 指定查询字段
 * @method static Query union(mixed $union, boolean $all = false) UNION查询
 * @method static Query limit(mixed $offset, integer $length = null) 查询LIMIT
 * @method static Query order(mixed $field, string $order = null) 查询ORDER
 * @method static Query orderRaw(string $field, array $bind = []) 查询ORDER
 * @method static Query cache(mixed $key = null, integer $expire = null) 设置查询缓存
 * @method static mixed value(string $field) 获取某个字段的值
 * @method static array column(string $field, string $key = '') 获取某个列的值
 * @method static static find(mixed $data = null) 查询单个记录 不存在返回Null
 * @method static static findOrEmpty(mixed $data = null) 查询单个记录 不存在返回空模型
 * @method static Collection select(mixed $data = null) 查询多个记录
 * @method static Model withAttr(array $name, Closure $closure) 动态定义获取器
 *
 * @method static Query master() 从主服务器读取数据
 * @method static Query readMaster(bool $all = false) 后续从主服务器读取数据
 * @method static Query table(string $table) 指定数据表（含前缀）
 * @method static Query name(string $name) 指定数据表（不含前缀）
 * @method static int insert(array $data, boolean $replace = false, boolean $getLastInsID = false, string $sequence = null) 插入一条记录
 * @method static int insertGetId(array $data, boolean $replace = false, string $sequence = null) 插入一条记录并返回自增ID
 * @method static int insertAll(array $dataSet) 插入多条记录
 * @method static int update(array $data) 更新记录
 * @method static int delete(mixed $data = null) 删除记录
 * @method static boolean chunk(int $count, callable $callback, string $column = null) 分块获取数据
 * @method static Generator cursor(mixed $data = null) 使用游标查找记录
 * @method static mixed query(string $sql, array $bind = [], boolean $master = false, bool $pdo = false) SQL查询
 * @method static int execute(string $sql, array $bind = [], boolean $fetch = false, boolean $getLastInsID = false, string $sequence = null) SQL执行
 * @method static Paginator paginate(int $listRows = 15, mixed $simple = null, array $config = []) 分页查询
 * @method static mixed transaction(callable $callback) 执行数据库事务
 * @method static void startTrans() 启动事务
 * @method static void commit() 用于非自动提交状态下面的查询提交
 * @method static void rollback() 事务回滚
 * @method static boolean batchQuery(array $sqlArray) 批处理执行SQL语句
 * @method static string getLastInsID(string $sequence = null) 获取最近插入的ID
 *
 * @method static string buildSql() 获取生成subQuery格式的SQL语句
 * @method static string fetchSql() 获取生成SQL语句
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