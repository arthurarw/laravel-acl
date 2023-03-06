<?php

use App\Http\Controllers\Manager\ResourceController;
use App\Http\Controllers\Manager\RoleController;
use App\Http\Controllers\Manager\UserController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('threads.index');
});

Route::get('/home', function () {
    return redirect()->route('threads.index');
});

Route::resource('/threads', ThreadController::class)->middleware('access.control.list');

Route::post('/replies', [ReplyController::class, 'store'])->name('replies.store');

Auth::routes();


Route::prefix('manager')->group(function () {
    Route::get('/', function () {
        return redirect()->route('users.index');
    });

    Route::resource('roles', RoleController::class);
    Route::get('roles/{role}/resources', [RoleController::class, 'syncResources'])
        ->name('roles.resources');
    Route::put('roles/{role}/resources', [RoleController::class, 'updateSyncResources'])
        ->name('roles.resources.update');

    Route::resource('users', UserController::class);
    Route::resource('resources', ResourceController::class);
});
