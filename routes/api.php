<?php

use Illuminate\Http\Request;
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
use App\Http\Controllers\JobController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Middleware\JobMiddleware;
use App\Http\Middleware\RoleCheckMiddleware;
use App\Http\Controllers\PasswordResetController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::group(['middleware' => ['auth', 'rolecheck:role']], function () {
//     Route::controller(RoleController::class)->prefix('role')->group(function () {
//         Route::post('store', 'store')->name('role.store');
//         Route::get('show{id?}','index')->name('role.show');
//         Route::delete('delete/{id}', 'destroy')->name('role.delete');
//         Route::put('update_data/{id}','update_data')->name('role.update_data');
//         Route::get('role_permissions','rolepermission')->name('role.role_permissions');
//         Route::get('/search', 'search')->name('role.search');
//         Route::get('roles', 'index')->name('role.roles');
//     });
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::prefix('job')->group(function () {
        Route::post('create', [JobController::class, 'store'])->middleware('rolecheck:job,add_access');
        Route::get('view/{id?}', [JobController::class, 'index'])->middleware('rolecheck:job,view_access');
        Route::delete('delete/{id}', [JobController::class, 'destroy'])->middleware('rolecheck:job,delete_access');
        Route::put('update/{id}', [JobController::class, 'update'])->middleware('rolecheck:job,edit_access');
    });
});

    Route::controller(ModuleController::class)->prefix('modules')->group(function () {
        Route::post('store', 'store')->name('modules.store');
        Route::get('list','index')->name('modules.list');
        Route::get('show/{id?}','show')->name('modules.show');
        Route::delete('destroy/{id}', 'destroy')->name('modules.destroy');
        Route::put('update/{id}','update')->name('modules.update');
    });
    



// Route::middleware([RoleMiddleware::class])->group(function (){
  
    Route::controller(RoleController::class)->prefix('role')->group(function () {
        Route::post('store', 'store')->name('role.store');
        Route::delete('delete/{id}', 'destroy')->name('role.delete');
        Route::put('update/{id}','update')->name('role.update');
        Route::get('roles', 'index')->name('role.roles');
    });
// });

 
Route::controller(PermissionController::class)->prefix('permission')->group(function () {
    Route::post('store', 'store')->name('permission.store');
    Route::delete('destroy/{id}', 'destroy')->name('permission.destroy');
    Route::put('update/{id}','update')->name('permission.update');
    Route::get('list','index')->name('permission.list');
    Route::get('show','show')->name('permission.show');
});



Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::middleware('auth:sanctum')->post('logout','logout');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

});
Route::post('/send-reset-password-email', [PasswordResetController::class, 'send_reset_password_email']);
Route::post('/reset-password/{token}', [PasswordResetController::class, 'reset']);
Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('logout',[AuthController::class,'logout']);
    Route::get('/loggeduser', [AuthController::class,'logged_user']);
    Route::post('/changepassword', [AuthController::class, 'change_password']);
});

// Job routes

    // Get all jobs
    Route::get('/jobs', 'App\Http\Controllers\JobController@index');

    // Get a single job
    Route::get('show/{id}', 'App\Http\Controllers\JobController@show');

    // Create a new job
    Route::post('/store', 'App\Http\Controllers\JobController@store');

    // Update an existing job
    Route::put('/update/{id}', 'App\Http\Controllers\JobController@update');

    // Delete a job
    Route::delete('/delete/{id}', 'App\Http\Controllers\JobController@destroy');



    // Route::group(['Middleware' => [,'rolecheck']], function(){
    
    //     Route::controller(JobController::class)->prefix('job')->group(function(){
    //         Route::post("create",'store')->middleware('rolecheck:job,add_access');
    //         Route::get("view/{id?}",'index')->middleware('rolecheck:job,view_access');
    //         Route::delete("delete/{id}",'destroy')->middleware('rolecheck:job,edit_access');
    //         Route::put("update/{id}",'update')->middleware('rolecheck:job,delete_access');
    //     });
    // });
    