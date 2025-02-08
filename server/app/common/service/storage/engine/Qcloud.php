<?php

namespace app\common\service\storage\engine;

use app\common\service\FileService;
use ArrayObject;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use Exception;
use Qcloud\Cos\Client;

/**
 * 腾讯云存储引擎 (COS)
 * Class Qiniu
 * @package app\common\library\storage\engine
 */
class Qcloud extends Server
{
    private mixed $config;
    private mixed $cosClient;

    /**
     * 构造方法
     * Qcloud constructor.
     * @param $config
     */
    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
        // 创建COS控制类
        $this->createCosClient();
    }

    /**
     * 创建COS控制类
     */
    private function createCosClient(): void
    {
        $this->cosClient = new Client([
            'region' => $this->config['region'],
            'credentials' => [
                'secretId' => $this->config['access_key'],
                'secretKey' => $this->config['secret_key'],
            ],
        ]);
    }

    /**
     * 执行上传
     * @param $save_dir string
     * @return bool
     */
    public function upload(string $save_dir): bool
    {
        // 上传文件
        // putObject(上传接口，最大支持上传5G文件)
        try {
            $result = $this->cosClient->putObject([
                'Bucket' => $this->config['bucket'],
                'Key' => $save_dir . '/' . $this->fileName,
                'Body' => fopen($this->getRealPath(), 'rb')
            ]);
            return true;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * notes: 抓取远程资源(最大支持上传5G文件)
     * @param $url
     * @param null $key
     * @return bool
     *@author 张无忌(2021/3/2 14:36)
     */
    public function fetch($url, $key=null): bool
    {
        try {
            $this->cosClient->putObject([
                'Bucket' => $this->config['bucket'],
                'Key'    => $key,
                'Body'   => fopen($url, 'rb')
            ]);
            return true;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * 删除文件
     * @param $fileName
     * @return bool
     */
    public function delete($fileName): bool
    {
        try {
            $this->cosClient->deleteObject(array(
                'Bucket' => $this->config['bucket'],
                'Key' => $fileName
            ));
            return true;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * 返回文件路径
     * @return mixed
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function getUploadToken($name,$src,$size): array
    {
        // TODO: Implement getUploadToken() method.
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
