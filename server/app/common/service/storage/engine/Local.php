<?php

namespace app\common\service\storage\engine;

use app\common\service\FileService;
use ArrayObject;
use Aws\Credentials\Credentials;
use Aws\S3\S3Client;

/**
 * 本地文件驱动
 * Class Local
 * @package app\common\library\storage\drivers
 */
class Local extends Server
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 上传
     * @param $save_dir string
     * @return bool
     */
    public function upload(string $save_dir): bool
    {
        // 验证文件并上传
        $info = $this->file->move($save_dir.'/'.$this->fileName);
        if (empty($info)) {
            $this->error = $this->file->getError();
            return false;
        }
        return true;
    }

    public function fetch($url, $key=null): bool
    {
        return true;
    }

    /**
     * 删除文件
     * @param $fileName
     * @return bool
     */
    public function delete($fileName): bool
    {
        $check = strpos($fileName, '/');
        if ($check !== false && $check == 0) {
            // 文件所在目录
            $fileName = substr_replace($fileName,"",0,1);
        }
        $filePath = public_path() . "{$fileName}";
        return !file_exists($filePath) ?: unlink($filePath);
    }

    /**
     * 返回文件路径
     * @return string
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
        $accessKey = '';
        $secretKey = '';
        $is_oss_req = false;
        $req_url = '';
        $region = "";
        $endpoint = "";
        return [
            'is_oss_req'=>0,
            'req_file_url'=>FileService::getFileUrl($src.'/'.$name),
            'save_file_url'=>$src.'/'.$name,
            'save_dir'=>$src,
            'upload_file_name'=>$name,
            'upload_file_size'=>$size,
            'params'=>$params,
            'headers'=>$headers,
            'req_url'=>$req_url,
            'region'=>'',
            'endpoint'=>'',
            'method'=>'post',
        ];
    }
}
