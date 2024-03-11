<?php
include "./install/model.php";
include "./install/YxEnv.php";

$modelInstall = new installModel();


define('install', true);
define('INSTALL_ROOT', __DIR__);
define('TESTING_TABLE', 'config');
// Env设置
$yxEnv = new YxEnv();
$envFilePath = $modelInstall->getAppRoot() . '/.env';
if ($modelInstall->appIsInstalled()) {
    die('可能已经安装过本系统了，请删除配置目录下面的install.lock文件再尝试');
}
echo "---安装脚本---\r\n";
echo "请输入数据库地址 127.0.0.1：";
$host = readline("");
echo "请输入数据库端口 3306: ";
$port = readline("");
echo "请输入数据库名 likeadmin: ";
$db = readline("");

echo "请输入数据表前缀 la_: ";
$table_prefix = readline("");

echo "请输入数据库账号 root: ";
$username = readline("");

echo "请输入数据库密码 xxx: ";
$password = readline("");

echo "是否清理数据库,是：on,否：off: ";
$clear_db = readline("");
echo "是否导入测试数据,是：on,否：off: ";
$import_test_data = readline("");

echo "请输入redis地址 127.0.0.1: ";
$redis_host = readline("");
echo "请输入redis端口 6379: ";
$redis_port = readline("");
echo "请输入redis库 0: ";
$redis_db = readline("");
echo "请输入redis密码 没有留空: ";
$redis_password = readline("");
echo "请输入redis前缀 cache_: ";
$redis_prefix = readline("");
echo "请输入管理员账号 admin: ";
$admin_user = readline("");
echo "请输入管理员密码 xxx: ";
$admin_password = readline("");

$host = trim($host);
$port = trim($port);
$username = trim($username);
$password = trim($password);
$db = trim($db);
$admin_user = trim($admin_user);
$admin_password = trim($admin_password);
$table_prefix = trim($table_prefix);
$import_test_data = trim($import_test_data);
$clear_db = trim($clear_db);
$redis_host = trim($redis_host);
$redis_port = trim($redis_port);
$redis_db = trim($redis_db);
$redis_password = trim($redis_password);
$redis_prefix = trim($redis_prefix);

$data = [
    'host' => $host ?? '127.0.0.1',
    'port' => $port ?? '3306',
    'user' => $username ?? 'root',
    'password' => $password ?? '',
    'name' => $db ?? 'likeadmin',
    'admin_user' => $admin_user ?? '',
    'admin_password' => $admin_password ?? '',
    'admin_confirm_password' => $admin_password ?? '',
    'prefix' => $table_prefix ?? 'la_',
    'import_test_data' => $import_test_data ?? 'off',
    'clear_db' => $clear_db ?? 'off',
    'redis_host' => $redis_host ?? '127.0.0.1',
    'redis_port' => $redis_port ?? '6379',
    'redis_db' => $redis_db ?? 0,
    'redis_password' => $redis_password ?? '',
    'redis_prefix' => $redis_prefix ?? 'cache_',
];


// 加载Example文件
$yxEnv->load($modelInstall->getAppRoot() . '/.example.env');

//尝试生成.env
$yxEnv->makeEnv($modelInstall->getAppRoot() . '/.env');
$canNext = true;
if (empty($data['prefix'])) {
    $canNext = false;
    $message = '数据表前缀不能为空';
    exit();
} elseif ($data['admin_user'] == '') {
    $canNext = false;
    $message = '请填写管理员用户名';
    exit();
} elseif (empty(trim($data['admin_password']))) {
    $canNext = false;
    $message = '管理员密码不能为空';
    exit();
} else {
    // 检查 数据库信息
    $result = $modelInstall->checkConfig($data['name'], $data);
    if ($result->result == 'fail') {
        $canNext = false;
        $message = $result->error;
    }

    // 导入测试数据
    if ($canNext && $data['import_test_data'] == 'on') {
        if (!$modelInstall->importDemoData()) {
            $canNext = false;
            $message = '导入测试数据错误';
            exit();
        }
    }

    // 写配置文件
    if ($canNext) {
        $yxEnv->putEnv($envFilePath, $data);
        $modelInstall->mkLockFile();
    }
}
echo json_encode($data);
echo "\r\n安装成功，请重新运行\r\n";
exit();