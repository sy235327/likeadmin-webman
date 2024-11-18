<?php

namespace app\common\service\storage;

use think\Exception;

/**
 * 存储模块驱动
 * Class driver
 * @package app\common\library\storage
 */
class Driver
{
    private mixed $config;    // upload 配置
    private mixed $engine;    // 当前存储引擎类

    /**
     * 构造方法
     * Driver constructor.
     * @param $config
     * @param string|null $storage 指定存储方式，如不指定则为系统默认
     * @throws Exception
     */
    public function __construct($config, string $storage = null)
    {
        $this->config = $config;
        $this->engine = $this->getEngineClass($storage);
    }

    /**
     * 构建文件上传凭证
     * @param $name
     * @param $src
     * @param $size
     * @return array
     */
    public function getUploadToken($name,$src,$size): array
    {
        return $this->engine->getUploadToken($name,$src,$size);
    }
    /**
     * 设置上传的文件信息
     * @param string $name
     * @return mixed
     */
    public function setUploadFile(string $name = 'iFile'): mixed
    {
        return $this->engine->setUploadFile($name);
    }

    /**
     * 设置上传的文件信息
     * @param string $filePath
     * @return mixed
     */
    public function setUploadFileByReal(string $filePath): mixed
    {
        return $this->engine->setUploadFileByReal($filePath);
    }

    /**
     * 执行文件上传
     * @param string $save_dir 保存路径
     * @return mixed
     */
    public function upload(string $save_dir): mixed
    {
        return $this->engine->upload($save_dir);
    }

    /**
     * Notes: 抓取网络资源
     * @param $url
     * @param $key
     * @author 张无忌(2021/3/2 14:16)
     * @return mixed
     */
    public function fetch($url, $key): mixed
    {
        return $this->engine->fetch($url, $key);
    }

    /**
     * 执行文件删除
     * @param $fileName
     * @return mixed
     */
    public function delete($fileName): mixed
    {
        return $this->engine->delete($fileName);
    }

    /**
     * 获取错误信息
     * @return mixed
     */
    public function getError(): mixed
    {
        return $this->engine->getError();
    }

    /**
     * 获取文件路径
     * @return mixed
     */
    public function getFileName(): mixed
    {
        return $this->engine->getFileName();
    }

    /**
     * 返回文件信息
     * @return mixed
     */
    public function getFileInfo(): mixed
    {
        return $this->engine->getFileInfo();
    }

    /**
     * 获取当前的存储引擎
     * @param string|null $storage 指定存储方式，如不指定则为系统默认
     * @return mixed
     * @throws Exception
     */
    private function getEngineClass(string|null $storage = null): mixed
    {
        $engineName = is_null($storage) ? $this->config['default'] : $storage;
        $classSpace = __NAMESPACE__ . '\\engine\\' . ucfirst($engineName);
        if (!class_exists($classSpace)) {
            throw new Exception('未找到存储引擎类: ' . $engineName);
        }
        if($engineName == 'local') {
            return new $classSpace();
        }

        return new $classSpace($this->config['engine'][$engineName]);
    }

}
