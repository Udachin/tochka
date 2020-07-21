<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

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

Route::get('/mysql', function () {
    dd(DB::connection()->select("Select 1 + 1"));
});

Route::get('/redis', function () {
    Redis::set('name', 'Kirill Udachin');
    $values = Redis::get('name');
    dd($values);
});
