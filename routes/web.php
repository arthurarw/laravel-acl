<?php

use App\Http\Controllers\ThreadController;
use App\Http\Controllers\ReplyController;
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

Route::resource('/threads', ThreadController::class);

Route::post('/replies', [ReplyController::class, 'store'])->name('replies.store');

Auth::routes();
