<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('/image', function (Request $request) {
    return Storage::disk('upyun')->put('/', $request->file('image'));
});

Route::get('/image/delete', function () {
    Storage::disk('upyun')->delete('lvn9RsRnjS5O6Obm6BEkWOPEdTLCTnGWcCMJn2Ob.jpeg');
});