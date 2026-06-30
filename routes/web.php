<?php

use App\Livewire\Actions\Logout;
use App\Livewire\Activity\Index as ActivityIndex;
use App\Livewire\Dashboard;
use App\Livewire\Projects\Index as ProjectsIndex;
use App\Livewire\Projects\Show as ProjectsShow;
use App\Livewire\Tasks\Show as TasksShow;
use App\Livewire\Users\Index as UsersIndex;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/projects', ProjectsIndex::class)->name('projects.index');
    Route::get('/projects/{project}', ProjectsShow::class)->name('projects.show');
    Route::get('/tasks/{task}', TasksShow::class)->name('tasks.show');
    Route::get('/activity', ActivityIndex::class)->name('activity.index');
    Route::get('/users', UsersIndex::class)->name('users.index')->middleware('can:users.manage');
});

Route::post('/logout', function (Logout $logout) {
    $logout();
    return redirect('/');
})->name('logout')->middleware('auth');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
