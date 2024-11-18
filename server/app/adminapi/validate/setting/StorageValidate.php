<?php


namespace app\adminapi\validate\setting;


use app\common\validate\BaseValidate;

class StorageValidate extends BaseValidate
{
    protected $rule = [
        'engine' => 'require',
        'status' => 'require',
    ];



    /**
     * @notes 设置存储引擎参数场景
     * @return StorageValidate
     * @author 乔峰
     * @date 2022/4/20 16:18
     */
    public function sceneSetup(): StorageValidate
    {
        return $this->only(['engine', 'status']);
    }


    /**
     * @notes 获取配置参数信息场景
     * @return StorageValidate
     * @author 乔峰
     * @date 2022/4/20 16:18
     */
    public function sceneDetail(): StorageValidate
    {
        return $this->only(['engine']);
    }


    /**
     * @notes 切换存储引擎场景
     * @return StorageValidate
     * @author 乔峰
     * @date 2022/4/20 16:18
     */
    public function sceneChange(): StorageValidate
    {
        return $this->only(['engine']);
    }
}