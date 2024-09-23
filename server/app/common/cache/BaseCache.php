<?php


namespace app\common\cache;


use think\facade\Cache;

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
    public function get($key, $default = null)
    {
        // TODO: Implement get() method.
        return Cache::get($key,$default);
    }
    public function delete($key)
    {
        // TODO: Implement get() method.
        return Cache::delete($key);
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