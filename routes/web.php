<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [BlogController::class, 'index'])->name('index');

Route::get('/sort', [BlogController::class, 'sort'])->name('sort.get');
Route::post('/sort', [BlogController::class, 'sort'])->name('sort.post');
Route::post('/save', [BlogController::class, 'save'])->name('blog.post');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/show', [AdminController::class, 'adminShow'])->name('admin.show');
    Route::get('/card/{id}', [AdminController::class, 'cardForAdmin'])->name('card');
    Route::put('/edit/{id}', [AdminController::class, 'editForAdmin'])->name('edit.comment');
    Route::put('/comment/{id}', [AdminController::class, 'approvedComment'])->name('approved.comment');
});
