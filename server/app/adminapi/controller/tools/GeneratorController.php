<?php


namespace app\adminapi\controller\tools;


use app\adminapi\controller\BaseAdminController;
use app\adminapi\lists\tools\DataTableLists;
use app\adminapi\lists\tools\GenerateTableLists;
use app\adminapi\logic\tools\GeneratorLogic;
use app\adminapi\validate\tools\EditTableValidate;
use app\adminapi\validate\tools\GenerateTableValidate;
use support\Response;

/**
 * 代码生成器控制器
 * Class GeneratorController
 * @package app\adminapi\controller\article
 */
class GeneratorController extends BaseAdminController
{

    public array $notNeedLogin = ['download'];

    private GenerateTableValidate $validateObj;

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new GenerateTableValidate();
    }
    /**
     * @notes 获取数据库中所有数据表信息
     * @return
     * @author bingo
     * @date 2022/6/14 10:57
     */
    public function dataTable(): Response
    {
        return $this->dataLists(new DataTableLists());
    }


    /**
     * @notes 获取已选择的数据表
     * @return
     * @author bingo
     * @date 2022/6/14 10:57
     */
    public function generateTable(): Response
    {
        return $this->dataLists(new GenerateTableLists());
    }


    /**
     * @notes 选择数据表
     * @return
     * @author bingo
     * @date 2022/6/15 10:09
     */
    public function selectTable(): Response
    {
        $params = $this->validateObj->post()->goCheck('select');
        $result = GeneratorLogic::selectTable($params, $this->adminId);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(GeneratorLogic::getError());
    }


    /**
     * @notes 生成代码
     * @return
     * @author bingo
     * @date 2022/6/23 19:08
     */
    public function generate(): Response
    {
        $params = $this->validateObj->post()->goCheck('id');
        $result = GeneratorLogic::generate($params);
        if (false === $result) {
            return $this->fail(GeneratorLogic::getError());
        }
        return $this->success('操作成功', $result, 1, 1);
    }


    /**
     * @notes 下载文件
     * @author bingo
     * @date 2022/6/24 9:51
     */
    public function download(): Response|\Webman\Http\Response
    {
        $params = $this->validateObj->goCheck('download');
        $result = GeneratorLogic::download($params['file']);
        if (false === $result) {
            return $this->fail(GeneratorLogic::getError() ?: '下载失败');
        }
        return download($result, 'likeadmin-curd.zip');
    }


    /**
     * @notes 预览代码
     * @return
     * @author bingo
     * @date 2022/6/23 19:07
     */
    public function preview(): Response
    {
        $params = $this->validateObj->post()->goCheck('id');
        $result = GeneratorLogic::preview($params);
        if (false === $result) {
            return $this->fail(GeneratorLogic::getError());
        }
        return $this->data($result);
    }


    /**
     * @notes 同步字段
     * @return
     * @author bingo
     * @date 2022/6/17 15:22
     */
    public function syncColumn(): Response
    {
        $params = $this->validateObj->post()->goCheck('id');
        $result = GeneratorLogic::syncColumn($params);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(GeneratorLogic::getError());
    }


    /**
     * @notes 编辑表信息
     * @return
     * @author bingo
     * @date 2022/6/20 10:44
     */
    public function edit(): Response
    {
        $params = (new EditTableValidate())->post()->goCheck();
        $result = GeneratorLogic::editTable($params);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(GeneratorLogic::getError());
    }


    /**
     * @notes 获取已选择的数据表详情
     * @return
     * @author bingo
     * @date 2022/6/15 19:00
     */
    public function detail(): Response
    {
        $params = $this->validateObj->goCheck('id');
        $result = GeneratorLogic::getTableDetail($params);
        return $this->success('', $result);
    }


    /**
     * @notes 删除已选择的数据表信息
     * @return
     * @author bingo
     * @date 2022/6/15 19:00
     */
    public function delete(): Response
    {
        $params = $this->validateObj->post()->goCheck('id');
        $result = GeneratorLogic::deleteTable($params);
        if (true === $result) {
            return $this->success('操作成功', [], 1, 1);
        }
        return $this->fail(GeneratorLogic::getError());
    }


    /**
     * @notes 获取模型
     * @return
     * @author bingo
     * @date 2022/12/14 11:07
     */
    public function getModels(): Response
    {
        $result = GeneratorLogic::getAllModels();
        return $this->success('', $result, 1, 1);
    }

}

