<?php


namespace app\common\lists;


trait ListsSearchTrait
{
    protected $params;
    protected $searchWhere = [];

    /**
     * @notes 搜索条件生成
     * @param $search
     * @return array
     * @author 令狐冲
     * @date 2021/7/7 19:36
     */
    private function createWhere($search)
    {
        if (empty($search)) {
            return [];
        }
        $where = [];
        foreach ($search as $whereType => $whereFields) {
            switch ($whereType) {
                case '=':
                case '<>':
                case '>':
                case '>=':
                case '<':
                case '<=':
                case 'in':
                    foreach ($whereFields as $whereField) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || $this->params[$paramsName] == '') {
                            continue;
                        }
                        $where[] = [$whereField, $whereType, $this->params[$paramsName]];
                    }
                    break;
                case '%like%':
                    foreach ($whereFields as $whereField) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || empty($this->params[$paramsName])) {
                            continue;
                        }
                        $where[] = [$whereField, 'like', '%' . $this->params[$paramsName] . '%'];
                    }
                    break;
                case '%like':
                    foreach ($whereFields as $whereField) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || empty($this->params[$paramsName])) {
                            continue;
                        }
                        $where[] = [$whereField, 'like', '%' . $this->params[$paramsName]];
                    }
                    break;
                case 'like%':
                    foreach ($whereFields as $whereField) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || empty($this->params[$paramsName])) {
                            continue;
                        }
                        $where[] = [$whereField, 'like', $this->params[$paramsName]];
                    }
                    break;
                case 'between_time':
                    if (!is_numeric($this->startTime) || !is_numeric($this->endTime)) {
                        break;
                    }
                    $where[] = [$whereFields, 'between', [$this->startTime, $this->endTime]];
                    break;
                case 'between':
                    if (empty($this->start) || empty($this->end)) {
                        break;
                    }
                    $where[] = [$whereFields, 'between', [$this->start, $this->end]];
                    break;
                case 'find_in_set': // find_in_set查询
                    foreach ($whereFields as $whereField) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || $this->params[$paramsName] == '') {
                            continue;
                        }
                        $where[] = [$whereField, 'find in set', $this->params[$paramsName]];
                    }
                    break;
                case 'find_in_set_to_like': // find_in_set查询
                    foreach ($whereFields as $whereField) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || $this->params[$paramsName] == '') {
                            continue;
                        }
                        $ids = $this->params[$paramsName];
                        if (!is_array($ids)){
                            $ids = explode(',',$ids);
                        }
                        $likeStr = '';
                        foreach ($ids as $id){
                            if ($id){
                                $likeStr .= ','.$id.',%';
                            }
                        }
                        if ($likeStr){
                            $likeStr = '%'.$likeStr;
                            $where[] = function ($query) use ($whereField, $likeStr) {
                                $query->whereRaw("concat(',',".$whereField.",',') like '".$likeStr."'");
                            };
                        }
                    }
                    break;
                case 'other':
                    foreach ($whereFields as $whereField=>$func) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName]) || empty($this->params[$paramsName])) {
                            continue;
                        }
                        $where = $func($where,$whereField,$this->params,$paramsName);
                    }
                    break;
                //支持value=0的筛查
                case 'other_zero':
                    foreach ($whereFields as $whereField=>$func) {
                        $paramsName = substr_symbol_behind($whereField);
                        if (!isset($this->params[$paramsName])||
                            $this->params[$paramsName] === ''||
                            $this->params[$paramsName] === null) {
                            continue;
                        }
                        $where = $func($where,$whereField,$this->params,$paramsName);
                    }
                    break;
            }
        }
        return $where;
    }
}