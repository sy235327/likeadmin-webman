<?php
/**
 * This file is part of webman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author    walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link      http://www.workerman.net/
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

use app\api\middleware\InitMiddleware;
use app\api\middleware\LoginMiddleware;

return [
    'admin'=>[
        // 跨域中间件
        app\common\http\middleware\AdminAllowMiddleware::class,
        // 初始化
        app\admin\middleware\InitMiddleware::class,
        // 登录验证
        app\admin\middleware\LoginMiddleware::class,
        // 权限认证
        app\admin\middleware\AuthMiddleware::class,
    ],
    'api'=>[
        InitMiddleware::class, // 初始化
        LoginMiddleware::class, // 登录验证
    ]
];