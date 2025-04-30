<?php


namespace app\adminapi\controller;


use app\adminapi\lists\file\FileCateLists;
use app\adminapi\lists\file\FileLists;
use app\adminapi\logic\FileLogic;
use app\adminapi\validate\FileValidate;
use support\Response;

class FileController extends BaseAdminController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->validateObj = new FileValidate();
    }
    /**
     * @notes 文件列表
     * @author 乔峰
     * @date 2021/12/29 14:30
     */
    public function lists(): Response
    {
        return $this->dataLists(new FileLists());
    }


    /**
     * @notes 文件移动成功
     * @author 乔峰
     * @date 2021/12/29 14:30
     */
    public function move(): Response
    {
        $params = $this->validateObj->post()->goCheck('move');
        FileLogic::move($params);
        return $this->success('移动成功', [], 1, 1);
    }


    /**
     * @notes 重命名文件
     * @author 乔峰
     * @date 2021/12/29 14:31
     */
    public function rename(): Response
    {
        $params = $this->validateObj->post()->goCheck('rename');
        FileLogic::rename($params);
        return $this->success('重命名成功', [], 1, 1);
    }


    /**
     * @notes 删除文件
     * @author 乔峰
     * @date 2021/12/29 14:31
     */
    public function delete(): Response
    {
        $params = $this->validateObj->post()->goCheck('delete');
        FileLogic::delete($params);
        return $this->success('删除成功', [], 1, 1);
    }


    /**
     * @notes 分类列表
     * @author 乔峰
     * @date 2021/12/29 14:31
     */
    public function listCate(): Response
    {
        return $this->dataLists(new FileCateLists());
    }


    /**
     * @notes 添加文件分类
     * @author 乔峰
     * @date 2021/12/29 14:31
     */
    public function addCate(): Response
    {
        $params = $this->validateObj->post()->goCheck('addCate');
        FileLogic::addCate($params);
        return $this->success('添加成功', [], 1, 1);
    }


    /**
     * @notes 编辑文件分类
     * @author 乔峰
     * @date 2021/12/29 14:31
     */
    public function editCate(): Response
    {
        $params = $this->validateObj->post()->goCheck('editCate');
        FileLogic::editCate($params);
        return $this->success('编辑成功', [], 1, 1);
    }


    /**
     * @notes 删除文件分类
     * @author 乔峰
     * @date 2021/12/29 14:32
     */
    public function delCate(): Response
    {
        $params = $this->validateObj->post()->goCheck('id');
        FileLogic::delCate($params);
        return $this->success('删除成功', [], 1, 1);
    }
}