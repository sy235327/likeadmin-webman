<?php
require_once __DIR__ . '/BaseScript.php';

/**
 * test/import data
 * 自定义脚本处理
 */
function main(){
    $lock = new \app\common\service\LockService('test',30);
    echo 'lock1';
    if (!$lock->isLocked()){
        echo 'lock';
        $lock->lock();
        $adminLists = \app\common\model\auth\Admin::select()->toArray();
        echo json_encode($adminLists);
        $lock->release();
    }
}
main();