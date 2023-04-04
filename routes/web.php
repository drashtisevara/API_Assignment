<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PermisionmodelController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\HomeController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware'=> ['auth:sanctum','role:admin']],function(){
    Route::get('/home', function(){
        dd('successfull');
});
});

// Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
//     Route::post('/store', [ModuleController::class, 'store']);
 
// });

// Route::middleware(['auth:sanctum', 'role:user'])->group(function () {
//     Route::post('/store', [ModuleController::class, 'store']);
//     Route::put('/update/{id}', [PostController::class, 'update']);

// });