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


Route::post('admin/login',[LoginController::class, 'adminLogin'])->name('adminLogin');

Route::group( ['prefix' => 'admin','middleware' => ['auth:admin-api','scopes:admin'] ],function(){

    // authenticated staff routes here

    Route::get('dashboard',[LoginController::class, 'adminDashboard']);

});
