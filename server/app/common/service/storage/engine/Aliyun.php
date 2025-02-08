<?php

namespace app\common\service\storage\engine;

use app\common\service\FileService;
use ArrayObject;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
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
        //size 单位byte
        $params = new ArrayObject();
        $headers = new ArrayObject();
        $accessKey = $this->config['access_key'];
        $secretKey = $this->config['secret_key'];
        $is_oss_req = 0;
        $req_url = '';
        $method = $this->config['method']??"PUT";
        $region = $this->config['region']??"";
        $endpoint = $this->config['endpoint']??"";
        if ($region&&$endpoint){
            $s3Client = new S3Client([
                "region" => $region, // 地区 region id
                "endpoint" => $endpoint,  // 地区上传的 endpoint
                "credentials" => new Credentials($accessKey, $secretKey),
            ]);
            $request = $s3Client->createPresignedRequest(
                $s3Client->getCommand("PutObject", ["Bucket" => $this->config['bucket'], "Key" => $src.$name]),
                "+1 hours");
            $req_url = $request->getUri();
            if ($req_url){
                $is_oss_req = 1;
            }
        }
        if (($this->config['is_oss_req']??0) == 0){
            $is_oss_req = 0;
        }
        return [
            'is_oss_req'=>$is_oss_req,
            'req_file_url'=>FileService::getFileUrl($src.$name),
            'save_file_url'=>$src.$name,
            'save_dir'=>$src,
            'upload_file_name'=>$name,
            'upload_file_size'=>$size,
            'params'=>$params,
            'headers'=>$headers,
            'req_url'=>$req_url,
            'region'=>$region,
            'endpoint'=>$endpoint,
            'method'=>$method,
        ];
    }
}
