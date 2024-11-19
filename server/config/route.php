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
    $json = "";
    if ($request->method() !== 'OPTIONS'){
        $json = json_encode(['code' => 404, 'msg' => '404 not found']);
    }
    return response($json,404);
})->middleware([
    \app\common\http\middleware\AllowMiddleware::class
]);