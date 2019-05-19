<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::namespace('Api')->prefix('v1')->group(function () {
    Route::post('/signup','UserController@signup')->name('users.signup');
    Route::post('/login','UserController@login')->name('users.login');
    //当前用户信息
    Route::middleware('api.refresh')->group(function () {
        //用户退出
        Route::get('/logout', 'UserController@logout')->name('users.logout');
        // 当前的用户信息列表
        Route::get('/user/info','UserController@info')->name('users.info');
        //指定用户信息
        Route::get('/user','UserController@show')->name('users.show');
        //用户列表
        Route::get('/userlist','UserController@list')->name('users.list');
    });

    // 图片上传又拍云
    Route::post('/image/uplod', 'ImageController@uplod')->name('image.uplod');
    Route::post('/image/delete', 'ImageController@delete')->name('image.delete');

    // 添加文章模块
    Route::get('/article/list', 'ArticleController@list')->name('article.list');
    Route::get('/article','ArticleController@detail')->name('article.detail');
    Route::middleware('api.refresh')->group(function () {
        Route::post('/article/add', 'ArticleController@add')->name('article.add');
        Route::post('/article/edit', 'ArticleController@edit')->name('article.edit');
        Route::post('/article/delete','ArticleController@delete')->name('article.delete');
        Route::get('/article/restored','ArticleController@restored')->name('article.restored');
        Route::get('/article/reallydelete','ArticleController@reallyDelete')->name('article.reallyDelete');
    });

    // 评论模块
    Route::post('/comment/add', 'CommentController@add')->name('comment.add');
    Route::get('/comment/list', 'CommentController@list')->name('comment.list');
    Route::get('/comment/read','CommentController@read')->name('comment.read');
    Route::middleware('api.refresh')->group(function () {
        Route::post('/comment/edit', 'CommentController@edit')->name('comment.edit');
        Route::post('/comment/delete','CommentController@delete')->name('comment.delete');
        // 获取个人的所有评论
        Route::get('/comment/person','CommentController@person')->name('comment.person');
    });

    // 留言模块
    Route::post('/message/add', 'MessageController@add')->name('message.add');
    Route::get('/message/list', 'MessageController@list')->name('message.list');
    Route::middleware('api.refresh')->group(function () {
        Route::post('/message/edit', 'MessageController@edit')->name('message.edit');
        Route::post('/message/delete','MessageController@delete')->name('message.delete');
        // 个人留言
        Route::get('/message/person','messageController@person')->name('message.person');
    });

    // 友情链接模块
    Route::get('/link/list', 'LinkController@list')->name('link.list');
    Route::middleware('api.refresh')->group(function () {
        Route::post('/link/add', 'LinkController@add')->name('link.add');
        Route::post('/link/edit', 'LinkController@edit')->name('link.edit');
        Route::post('/link/delete','LinkController@delete')->name('link.delete');
    });

    // 图片广告模块
    Route::get('/ad/list', 'AdController@list')->name('ad.list');
    Route::get('/ad', 'AdController@show')->name('ad.show');
    Route::middleware('api.refresh')->group(function () {
        Route::post('/ad/add', 'AdController@add')->name('ad.add');
        Route::post('/ad/edit', 'AdController@edit')->name('ad.edit');
        Route::post('/ad/delete','AdController@delete')->name('ad.delete');
    });

    // 网站信息模块
    Route::post('/webinfo/set', 'WebinfoController@set')->name('webinfo.set');
    Route::get('/webinfo/read', 'WebinfoController@read')->name('webinfo.read');

});

