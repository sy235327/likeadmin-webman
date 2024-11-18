<?php


namespace app\adminapi\lists\file;


use app\adminapi\lists\BaseAdminDataLists;
use app\common\enum\FileEnum;
use app\common\lists\ListsSearchInterface;
use app\common\model\file\File;
use app\common\service\FileService;
use think\db\exception\DataNotFoundException;
use think\db\exception\DbException;
use think\db\exception\ModelNotFoundException;

class FileLists extends BaseAdminDataLists implements ListsSearchInterface
{
    /**
     * @notes 文件搜索条件
     * @return string[][]
     * @author 乔峰
     * @date 2021/12/29 14:27
     */
    public function setSearch(): array
    {
        return [
            '=' => ['type', 'cid'],
            '%like%' => ['name']
        ];
    }


    /**
     * @notes 获取文件列表
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @author 乔峰
     * @date 2021/12/29 14:27
     */
    public function lists(): array
    {
        $lists = (new File())->field(['id,cid,type,name,uri,create_time'])
            ->order('id', 'desc')
            ->where($this->searchWhere)
            ->where('source', FileEnum::SOURCE_ADMIN)
            ->limit($this->limitOffset, $this->limitLength)
            ->select()
            ->toArray();

        foreach ($lists as &$item) {
            $item['url'] = $item['uri'];
            $item['uri'] = FileService::getFileUrl($item['uri']);
        }

        return $lists;
    }


    /**
     * @notes 获取文件数量
     * @return int
     * @author 乔峰
     * @date 2021/12/29 14:29
     */
    public function count(): int
    {
        return (new File())->where($this->searchWhere)
            ->where('source', FileEnum::SOURCE_ADMIN)
            ->count();
    }
}