<?php

namespace app\common\service\storage\engine;

use ArrayObject;
use OSS\OssClient;
use OSS\Core\OssException;

/**
 * 阿里云存储引擎 (OSS)
 * Class Qiniu
 * @package app\common\library\storage\engine
 */
class Aliyun extends Server
{
    private mixed $config;

    /**
     * 构造方法
     * Aliyun constructor.
     * @param $config
     */
    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
    }

    /**
     * 执行上传
     * @param string $save_dir 保存路径
     * @return bool
     */
    public function upload(string $save_dir): bool
    {
        try {
            $ossClient = new OssClient(
                $this->config['access_key'],
                $this->config['secret_key'],
                $this->config['domain']
            );
            $ossClient->uploadFile(
                $this->config['bucket'],
                $this->fileName,
                $this->getRealPath()
            );
        } catch (OssException $e) {
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }

    /**
     * Notes: 抓取远程资源
     * @param $url
     * @param null $key
     * @return bool
     * @author 张无忌(2021/3/2 14:36)
     */
    public function fetch($url, $key = null): bool
    {
        try {
            $ossClient = new OssClient(
                $this->config['access_key'],
                $this->config['secret_key'],
                $this->config['domain'],
                true
            );

            $content = file_get_contents($url);
            $ossClient->putObject(
                $this->config['bucket'],
                $key,
                $content
            );
        } catch (OssException $e) {
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }

    /**
     * 删除文件
     * @param $fileName
     * @return bool
     */
    public function delete($fileName): bool
    {
        try {
            $ossClient = new OssClient(
                $this->config['access_key'],
                $this->config['access_key'],
                $this->config['domain'],
                true
            );
            $ossClient->deleteObject($this->config['bucket'], $fileName);
        } catch (OssException $e) {
            $this->error = $e->getMessage();
            return false;
        }
        return true;
    }

    /**
     * 返回文件路径
     * @return mixed
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getUploadToken($name,$src,$size): array|false
    {
        try {
            $ossClient = new OssClient(
                $this->config['access_key'],
                $this->config['access_key'],
                $this->config['domain'],
                true
            );    // 设置上传凭证的有效时间，单位是秒，默认是3600秒
            $timeout = 3600;
            // 获取上传凭证
            $response = $ossClient->signUrl($this->config['bucket'], "objectKey", $timeout);
            // 输出上传凭证
            if (!$response){
                $this->error = '获取上传凭证失败';
                return false;
            }
        } catch (OssException $e) {
            $this->error = $e->getMessage();
            return false;
        }
        // TODO: Implement getUploadToken() method.
        $params = new ArrayObject();
        $headers = new ArrayObject();
        $headers['Content-Type'] = 'multipart/form-data';
        $req_url = '';
        return [
            'upload_token'=>'',
            'save_dir'=>$src,
            'upload_file_name'=>$name,
            'upload_file_size'=>$size,
            'params'=>$params,
            'headers'=>$headers,
            'req_url'=>$req_url,
        ];
    }
}
