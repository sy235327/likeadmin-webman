<?php
/**
 * 路由拦截器
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

return [
    ''=>[
        // 跨域中间件
        app\common\http\middleware\AllowMiddleware::class,
    ],
    'adminapi'=>[
        // 初始化
        app\adminapi\middleware\InitMiddleware::class,
        // 登录验证
        app\adminapi\middleware\LoginMiddleware::class,
        // 权限认证
        app\adminapi\middleware\AuthMiddleware::class,
        app\common\http\middleware\EndMiddleware::class,
    ],
    'api'=>[
        // 初始化
        app\api\middleware\InitMiddleware::class,
        // 登录验证
        app\api\middleware\LoginMiddleware::class,
        app\common\http\middleware\EndMiddleware::class,
    ]
];