<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\BitlabController;
use App\Http\Controllers\ProfileController;
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
    return view('welcome');
});

Route::get('/dashboard/{page?}', [BitlabController::class, 'getUserActivity'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/load-more-activity', [BitlabController::class, 'loadMoreActivity'])->middleware(['auth', 'verified'])->name('load-more-activity');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/token', [ProfileController::class, 'updateToken'])->name('profile.updateToken');
    Route::patch('/profile/gitlab-name', [ProfileController::class, 'updateGitLabName'])->name('profile.updateGitLabName');
    Route::patch('/profile/details', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('projects', BitlabController::class);

require __DIR__.'/auth.php';
