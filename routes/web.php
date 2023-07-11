<?php

use App\Http\Controllers\GitlabController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SyncController;
use Illuminate\Support\Facades\Redirect;
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
})->name('welcome');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('dashboard/sync/status', [SyncController::class, 'status'])
    ->middleware(['auth', 'verified'])
    ->name('sync');

Route::get('/dashboard/activity/{page?}', [GitlabController::class, 'getUserActivity'])
    ->middleware(['auth', 'verified'])
    ->name('activity');

Route::get('/dashboard/projects/{page?}', [GitlabController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('projects');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/token', [ProfileController::class, 'updateToken'])->name('profile.updateToken');
    Route::patch('/profile/gitlab-name', [ProfileController::class, 'updateGitLabName'])->name('profile.updateGitLabName');
    Route::patch('/profile/details', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
