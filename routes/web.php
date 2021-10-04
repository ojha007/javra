<?php

use Illuminate\Support\Facades\Route;

Route::get('/users/{user}/achievements', 'AchievementsController@index');

Auth::routes(['register' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

