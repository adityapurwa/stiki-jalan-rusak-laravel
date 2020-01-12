<?php

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

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index');
Route::post('/login', 'IndexController@login');
Route::post('/logout', 'IndexController@logout');
Route::post('/register', 'IndexController@register');

Route::get('list-reports', 'ApiController@listReports');

Route::middleware('auth')->group(function(Router $route){
    $route->post('create-report', 'ApiController@createReport');
    $route->post('vote-report', 'ApiController@voteReport');
});

