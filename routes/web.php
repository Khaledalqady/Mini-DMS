<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\authDocs\LoginController;
use App\Http\Controllers\authDocs\RegisteredUserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::middleware(['auth'])->group(function(){
    Route::get('/documents', [ DocumentController::class,'index'])->name('documents.index');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{id}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{id}', [DocumentController::class, 'destroy'])->name('documents.destroy');

});

// Route::middleware('guest')->group(function () {
//     Route::get('/docs/register', [RegisteredUserController::class, 'create'])->name('docs.register');
//     Route::post('/docs/register', [RegisteredUserController::class, 'store']);
//     Route::get('/docs/login', [LoginController::class, 'create'])->name('docs.login');
//     Route::post('/docs/login', [LoginController::class, 'store']);
// });

Route::delete('/logout', [DocumentController::class, 'logout'])->middleware('auth');

require __DIR__.'/auth.php';
