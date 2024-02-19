<?php


namespace app\common\cache;


use support\Cache;

class BaseCache extends Cache
{
    /**
     * 缓存标签
     * @var string
     */
    protected $tagName;
    protected $cache;

    public function __construct(){
        $this->tagName = get_class($this);
    }
    /**
     * 自增缓存（针对数值缓存）
     * @access public
     * @param string $name 缓存变量名
     * @param int    $step 步长
     * @return false|int
     */
    public function inc(string $name, int $step = 1,$ttl = 0)
    {
        if ($raw = $this->get($name)) {
            $value  = $raw + $step;
            $expire = $ttl;
        } else {
            $value  = $step;
            $expire = 0;
        }

        return $this->set($name, $value, $expire) ? $value : false;
    }
    /**
     * @notes 重写父类set，自动打上标签
     * @param string $key
     * @param mixed $value
     * @param null $ttl
     * @return bool
     * @author 乔峰
     * @date 2021/12/27 14:16
     */
    public function set($key, $value, $ttl = null): bool
    {
        return Cache::store()->tag($this->tagName)->set($key, $value, $ttl);
    }


    /**
     * @notes 清除缓存类所有缓存
     * @return bool
     * @author 乔峰
     * @date 2021/12/27 14:16
     */
    public function deleteTag(): bool
    {
        return Cache::tag($this->tagName)->clear();
    }
}