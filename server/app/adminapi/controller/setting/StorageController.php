<?php


namespace app\adminapi\controller\setting;


use app\adminapi\controller\BaseAdminController;
use app\adminapi\logic\setting\StorageLogic;
use app\adminapi\validate\setting\StorageValidate;
use support\Response;

class StorageController extends BaseAdminController
{
    private StorageValidate $validateObj;

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new StorageValidate();
    }
    /**
     * @notes 获取存储引擎列表
     * @author 乔峰
     * @date 2022/4/20 16:13
     */
    public function lists(): Response
    {
        return $this->success('获取成功', StorageLogic::lists());
    }


    /**
     * @notes 存储配置信息
     * @author 乔峰
     * @date 2022/4/20 16:19
     */
    public function detail(): Response
    {
        $param = $this->validateObj->get()->goCheck('detail');
        return $this->success('获取成功', StorageLogic::detail($param));
    }


    /**
     * @notes 设置存储参数
     * @author 乔峰
     * @date 2022/4/20 16:19
     */
    public function setup(): Response
    {
        $params = $this->validateObj->post()->goCheck('setup');
        $result = StorageLogic::setup($params);
        if (true === $result) {
            return $this->success('配置成功', [], 1, 1);
        }
        return $this->success($result, [], 1, 1);
    }


    /**
     * @notes 切换存储引擎
     * @author 乔峰
     * @date 2022/4/20 16:19
     */
    public function change(): Response
    {
        $params = $this->validateObj->post()->goCheck('change');
        StorageLogic::change($params);
        return $this->success('切换成功', [], 1, 1);
    }
}