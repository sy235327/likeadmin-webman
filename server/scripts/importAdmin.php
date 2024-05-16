<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../support/bootstrap.php';

/**
 * test/import data
 * 自定义脚本处理
 */
function main(){
    $adminLists = \app\common\model\auth\Admin::select()->toArray();
    echo json_encode($adminLists);
}
main();