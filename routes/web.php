<?php

use App\Http\Controllers\GitlabController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WebhookController;
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

Route::get('/dashboard/{page?}', [GitlabController::class, 'getUserActivity'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/token', [ProfileController::class, 'updateToken'])->name('profile.updateToken');
    Route::patch('/profile/gitlab-name', [ProfileController::class, 'updateGitLabName'])->name('profile.updateGitLabName');
    Route::patch('/profile/details', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/projects/copy', [GitlabController::class, 'fetchGitClone'])->middleware(['auth', 'verified']);
Route::resource('projects', GitlabController::class);

Route::post('/webhook', WebhookController::class);

require __DIR__.'/auth.php';
