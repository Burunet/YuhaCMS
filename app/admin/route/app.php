<?php
use think\facade\Route;

//管理员登录
Route::post('Login', 'LonginController/Login');
Route::get('info', 'LonginController/getInfo');
Route::get('tojson', 'LonginController/tojson');

//路由分组-需要token验证
Route::group(function (){
    Route::post('LoginOut', 'LonginController/LoginOut');

    Route::get('adminlist', 'AdminController/getList');

})->middleware([\app\middleware\CheckToken::class]);


