<?php


namespace app\common\service;


use app\common\enum\FileEnum;
use app\common\model\file\File;
use app\common\service\storage\Driver as StorageDriver;
use ArrayObject;
use Exception;
class UploadService extends BaseService
{
    /**
     * 获取上传token,前端直接携带token上传文件
     * @return array|false
     */
    public function getUploadToken($name,$size): array|false
    {
        $config = [
            'default' => ConfigService::get('storage', 'default', 'local'),
            'engine'  => ConfigService::get('storage') ?? ['local'=>[]],
        ];
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $saveDir = false;
        if (in_array($extension, config('project.file_image'))) {
            $saveDir = 'uploads/images/';
        }
        if (in_array($extension, config('project.file_video'))) {
            $saveDir = 'uploads/video/';
        }
        if (in_array($extension, config('project.file_other'))) {
            $saveDir = 'uploads/other/';
        }
        if (!$saveDir){
            $this->setError("该文件类型暂不支持");
            return false;
        }
        $saveDir = $saveDir .  date('Ymd').'/';
        $file_name = date('YmdHis') . substr(md5($name), 0, 5)
            . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT).$extension;
        try {
            // 2、执行文件上传
            $StorageDriver = new StorageDriver($config);
            $upload_token_array = $StorageDriver->getUploadToken($file_name, $saveDir, $size);
            if (!$upload_token_array) {
                $this->setError("当前上传引擎不支持认证方式上传");
                return false;
            }
            $upload_token_array['id'] = 0;
            return $upload_token_array;
        }catch (Exception $e){
            $this->setError($e->getMessage());
            return false;
        }
    }
    /**
     * @notes 上传其他
     * @param $cid
     * @param int $user_id
     * @param string $saveDir
     * @return array|false
     * @author 乔峰
     * @date 2021/12/29 16:30
     */
    public function other($cid, int $sourceId = 0, int $source = FileEnum::SOURCE_ADMIN, string $saveDir = 'uploads/other'): bool|array
    {
        try {
            $config = [
                'default' => ConfigService::get('storage', 'default', 'local'),
                'engine'  => ConfigService::get('storage') ?? ['local'=>[]],
            ];

            // 2、执行文件上传
            $StorageDriver = new StorageDriver($config);
            $StorageDriver->setUploadFile('file');
            $fileName = $StorageDriver->getFileName();
            $fileInfo = $StorageDriver->getFileInfo();

            // 校验上传文件后缀
            if (!in_array(strtolower($fileInfo['ext']), config('project.file_other'))) {
                $this->setError("上传图片不允许上传". $fileInfo['ext'] . "文件");
                return false;
            }

            // 上传文件
            return $this->upload($saveDir,$config,$StorageDriver,$fileInfo,$cid,$source,$sourceId,$fileName,FileEnum::FILE_TYPE);
        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }
    }
    /**
     * @notes 上传图片
     * @param $cid
     * @param int $user_id
     * @param string $saveDir
     * @return array|false
     * @author 乔峰
     * @date 2021/12/29 16:30
     */
    public function image($cid, int $sourceId = 0, int $source = FileEnum::SOURCE_ADMIN, string $saveDir = 'uploads/images'): bool|array
    {
        try {
            $config = [
                'default' => ConfigService::get('storage', 'default', 'local'),
                'engine'  => ConfigService::get('storage') ?? ['local'=>[]],
            ];

            // 2、执行文件上传
            $StorageDriver = new StorageDriver($config);
            $StorageDriver->setUploadFile('file');
            $fileName = $StorageDriver->getFileName();
            $fileInfo = $StorageDriver->getFileInfo();

            // 校验上传文件后缀
            if (!in_array(strtolower($fileInfo['ext']), config('project.file_image'))) {
                $this->setError("上传图片不允许上传". $fileInfo['ext'] . "文件");
                return false;
            }

            // 上传文件
            return $this->upload($saveDir,$config,$StorageDriver,$fileInfo,$cid,$source,$sourceId,$fileName,FileEnum::IMAGE_TYPE);
        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }
    }


    /**
     * @notes 视频上传
     * @param $cid
     * @param int $user_id
     * @param string $saveDir
     * @return array|false
     * @author 乔峰
     * @date 2021/12/29 16:32
     */
    public function video($cid, int $sourceId = 0, int $source = FileEnum::SOURCE_ADMIN, string $saveDir = 'uploads/video'): bool|array
    {
        try {
            $config = [
                'default' => ConfigService::get('storage', 'default', 'local'),
                'engine'  => ConfigService::get('storage') ?? ['local'=>[]],
            ];

            // 2、执行文件上传
            $StorageDriver = new StorageDriver($config);
            $StorageDriver->setUploadFile('file');
            $fileName = $StorageDriver->getFileName();
            $fileInfo = $StorageDriver->getFileInfo();

            // 校验上传文件后缀
            if (!in_array(strtolower($fileInfo['ext']), config('project.file_video'))) {
                $this->setError("上传视频不允许上传". $fileInfo['ext'] . "文件");
                return false;
            }

            // 上传文件
            return $this->upload($saveDir,$config,$StorageDriver,$fileInfo,$cid,$source,$sourceId,$fileName,FileEnum::VIDEO_TYPE);
        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }
    }
    /**
     * @notes 视频上传
     * @param $cid
     * @param int $user_id
     * @param string $saveDir
     * @return array|false
     * @author 乔峰
     * @date 2021/12/29 16:32
     */
    public function file($cid, int $sourceId = 0, int $source = FileEnum::SOURCE_ADMIN, string $saveDir = 'uploads/file'): bool|array
    {
        try {
            $config = [
                'default' => ConfigService::get('storage', 'default', 'local'),
                'engine'  => ConfigService::get('storage') ?? ['local'=>[]],
            ];

            // 2、执行文件上传
            $StorageDriver = new StorageDriver($config);
            $StorageDriver->setUploadFile('file');
            $fileName = $StorageDriver->getFileName();
            $fileInfo = $StorageDriver->getFileInfo();

            // 校验上传文件后缀
            if (!in_array(strtolower($fileInfo['ext']), config('project.file_file'))) {
                $this->setError("上传文件不允许上传". $fileInfo['ext'] . "文件");
                return false;
            }

            // 上传文件
            return $this->upload($saveDir,$config,$StorageDriver,$fileInfo,$cid,$source,$sourceId,$fileName,FileEnum::FILE_TYPE);
        } catch (Exception $e) {
            $this->setError($e->getMessage());
            return false;
        }
    }
    private function upload($saveDir,$config,$StorageDriver,$fileInfo,$cid,$source,$sourceId,$fileName,$file_type): bool|array
    {
        // 上传文件
        $saveDir = $saveDir . '/' .  date('Ymd');
        if ($config['default']=='local'){
            if (!$StorageDriver->upload(public_path()."/".$saveDir)) {
                $this->setError($StorageDriver->getError());
                return false;
            }
        }else{
            if (!$StorageDriver->upload($saveDir)) {
                $this->setError($StorageDriver->getError());
                return false;
            }
        }

        // 3、处理文件名称
        if (strlen($fileInfo['name']) > 128) {
            $name = substr($fileInfo['name'], 0, 123);
            $nameEnd = substr($fileInfo['name'], strlen($fileInfo['name'])-5, strlen($fileInfo['name']));
            $fileInfo['name'] = $name . $nameEnd;
        }

        // 4、写入数据库中
        $file = File::create([
            'cid'         => $cid,
            'type'        => $file_type,
            'name'        => $fileInfo['name'],
            'uri'         => $saveDir . '/' . str_replace("\\","/", $fileName),
            'source'      => $source,
            'source_id'   => $sourceId,
            'create_time' => time(),
        ]);

        // 5、返回结果
        return [
            'id'   => $file['id'],
            'cid'  => $file['cid'],
            'type' => $file['type'],
            'name' => $file['name'],
            'uri'  => FileService::getFileUrl($file['uri']),
            'url'  => $file['uri']
        ];
    }
}