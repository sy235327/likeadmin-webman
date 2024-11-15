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

use support\Request;
use Webman\Route;

//404也跨域
Route::fallback(function(Request $request){
    $response = $request->method() == 'OPTIONS' ? response('') :  response(json_encode(['code' => 404, 'msg' => '404 not found']),404) ;
    // 给响应添加跨域相关的http头
    $response->withHeaders([
        'Access-Control-Allow-Credentials' => 'true',
        'Access-Control-Allow-Origin' => $request->header('origin', '*'),
        'Access-Control-Allow-Methods' => $request->header('access-control-request-method', '*'),
        'Access-Control-Allow-Headers' => $request->header('access-control-request-headers', '*'),
    ]);
    return $response;
});