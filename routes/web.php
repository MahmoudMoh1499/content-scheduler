<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\PostScheduler;
use App\Livewire\PostList;
use App\Livewire\PostPreview;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Http\Controllers\AuthController;
use App\Livewire\PlatformManager;
use App\Livewire\Dashboard;

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

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', action: Register::class)->name('register');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/schedule', PostScheduler::class)->name('schedule');
    Route::get('/posts', PostList::class)->name('posts');
    Route::get('/posts/{post}/preview', PostPreview::class)->name('posts.preview');
    Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/settings/platforms', PlatformManager::class)
        ->name('settings.platforms');

});
