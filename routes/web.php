<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/account', [ProfileController::class, 'index'])->name('account.index');
    Route::post('/wallet/add-balance', [ProfileController::class, 'addBalance'])->name('wallet.add_balance');
    Route::put('/photo', [ProfileController::class, 'updateProfile'])->name('user.photo');

    Route::get('blogs/{id}/show',[BlogController::class,'show'])->name('blogs.show');

    Route::resource('blogs', BlogController::class)->only(['create', 'store', 'edit', 'update', 'destroy'])->middleware('admin');
    Route::resource('services', ServiceController::class)->only(['create', 'store', 'edit', 'update', 'destroy'])->middleware('admin');
    Route::resource('categories', CategoryController::class)->middleware('admin');
    Route::post('comments/{id}/create', [CommentController::class,'store'])->name('comments.store');
    Route::Delete('comments/{id}', [CommentController::class,'destroy'])->name('comments.destroy');
    Route::post('/services/{service}/subscribe', [ServiceController::class, 'subscribe'])->name('services.subscribe');
    Route::post('/blogs/{id}/like', [BlogController::class, 'like'])->name('blogs.like');
    Route::post('/services/{id}/rate', [ServiceController::class, 'rate'])->name('services.rate');
});
Route::get('blogs/index',[BlogController::class,'index'])->name('blogs.index');
Route::get('services/index',[ServiceController::class,'index'])->name('services.index');
Route::get('services/{id}/show',[ServiceController::class,'show'])->name('services.show');

require __DIR__.'/auth.php';
