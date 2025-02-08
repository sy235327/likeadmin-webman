<?php

namespace app\common\service\storage\engine;

use app\common\service\FileService;
use ArrayObject;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;
use Exception;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

/**
 * 七牛云存储引擎
 * Class Qiniu
 * @package app\common\library\storage\engine
 */
class Qiniu extends Server
{
    private mixed $config;

    /**
     * 构造方法
     * Qiniu constructor.
     * @param $config
     */
    public function __construct($config)
    {
        parent::__construct();
        $this->config = $config;
    }

    /**
     * @notes 执行上传
     * @param string $save_dir
     * @return bool
     * @author 张无忌
     * @date 2021/7/27 16:02
     */
    public function upload(string $save_dir): bool
    {
        // 要上传图片的本地路径
        $realPath = $this->getRealPath();

        // 构建鉴权对象
        $auth = new Auth($this->config['access_key'], $this->config['secret_key']);

        // 要上传的空间
        $token = $auth->uploadToken($this->config['bucket']);

        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();

        try {
            // 调用 UploadManager 的 putFile 方法进行文件的上传
            $key = $save_dir . '/' . $this->fileName;
            list(, $error) = $uploadMgr->putFile($token, $key, $realPath);

            if ($error !== null) {
                $this->error = $error->message();
                return false;
            }
            return true;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * @notes 抓取远程资源
     * @param $url
     * @param null $key
     * @return bool
     * @author 张无忌
     * @date 2021/7/27 16:02
     */
    public function fetch($url, $key=null): bool
    {
        try {
            if (substr($url, 0, 1) !== '/' || strstr($url, 'http://') || strstr($url, 'https://')) {
                $auth = new Auth($this->config['access_key'], $this->config['secret_key']);
                $bucketManager = new BucketManager($auth);
                list(, $err) = $bucketManager->fetch($url, $this->config['bucket'], $key);
            } else {
                $auth = new Auth($this->config['access_key'], $this->config['secret_key']);
                $token = $auth->uploadToken($this->config['bucket']);
                $uploadMgr = new UploadManager();
                list(, $err) = $uploadMgr->putFile($token, $key, $url);
            }

            if ($err !== null) {
                $this->error = $err->message();
                return false;
            }

            return true;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * @notes 删除文件
     * @param $fileName
     * @return bool
     * @author 张无忌
     * @date 2021/7/27 16:02
     */
    public function delete($fileName): bool
    {
        // 构建鉴权对象
        $auth = new Auth($this->config['access_key'], $this->config['secret_key']);
        // 初始化 UploadManager 对象并进行文件的上传
        $bucketMgr = new BucketManager($auth);

        try {
            list($res, $error) = $bucketMgr->delete($this->config['bucket'], $fileName);
            if ($error !== null) {
                $this->error = $error->message();
                return false;
            }
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


    public function getUploadToken($name,$src,$size,$contentType='image/png'): array
    {
        //size 单位byte
        $params = new ArrayObject();
        $headers = new ArrayObject();
        $accessKey = $this->config['access_key'];
        $secretKey = $this->config['secret_key'];
        $is_oss_req = 0;
        $req_url = '';
        $method = $this->config['method']??"PUT";
        $region = $this->config['region']??"cn-south-1";
        $endpoint = $this->config['endpoint']??"http://s3.cn-south-1.qiniucs.com";
        if ($region&&$endpoint){
            $s3Client = new S3Client([
                "region" => $region, // 地区 region id
                "endpoint" => $endpoint,  // 地区上传的 endpoint
                "credentials" => new Credentials($accessKey, $secretKey),
            ]);
            $request = $s3Client->createPresignedRequest(
                $s3Client->getCommand("PutObject", ["Bucket" => $this->config['bucket'], "Key" => $src.$name, "ContentType"=>$contentType]),
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
