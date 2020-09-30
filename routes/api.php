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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources(['tag' => 'API\AdminController']);
Route::post('create_users', 'API\AdminController@createUsers');
Route::post('edit_user', 'API\AdminController@editUsers');
Route::post('admin_login', 'API\AdminController@adminLogin');
Route::get('get_users', 'API\AdminController@getUsers');
Route::apiResources(['category' => 'API\CategoryController']);
Route::post('edit_tag', 'API\AdminController@editTag');
Route::put('edit_category', 'API\CategoryController@editCategory');
Route::post('delete_tag', 'API\AdminController@deleteTag');
Route::post('delete_category', 'API\CategoryController@deleteCategory');
Route::post('upload_file', 'API\CategoryController@upload');
Route::post('delete_image', 'API\CategoryController@deleteImage');