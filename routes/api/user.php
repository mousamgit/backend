<?php


use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;

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


Route::post('user/login',[LoginController::class, 'userLogin'])->name('userLogin');

Route::group( ['prefix' => 'user','middleware' => ['auth:user-api','scopes:user'] ],function(){
    // authenticated staff routes here
    Route::get('dashboard',[LoginController::class, 'userDashboard']);
});


Route::group( ['prefix' => 'v1','middleware' => ['auth:user-api','scopes:user'] ],function(){
    // authenticated admin users routes here
    Route::get('profile',[\App\Http\Controllers\Api\V1\Profile\ProfileController::class, 'fetchUserProfile']);
    //user crud routes
    Route::apiResource('users', \App\Http\Controllers\Api\V1\User\UserController::class);
    Route::post('users/delete', [\App\Http\Controllers\Api\V1\User\UserController::class, 'destroy']);


    //role crud routes
    Route::get('roles/all', [\App\Http\Controllers\Api\V1\User\RoleController::class, 'all']);
    Route::apiResource('roles', \App\Http\Controllers\Api\V1\User\RoleController::class);
    Route::post('roles/delete', [\App\Http\Controllers\Api\V1\User\RoleController::class, 'destroy']);

    //permissions crud routes
    Route::get('permissions/all', [\App\Http\Controllers\Api\V1\User\PermissionController::class, 'all']);
    Route::apiResource('permissions', \App\Http\Controllers\Api\V1\User\PermissionController::class);
    Route::post('permissions/delete', [\App\Http\Controllers\Api\V1\User\PermissionController::class, 'destroy']);
});
