<?php


use Illuminate\Support\Facades\Route;

Route::resource('lessons', 'LessonController', ['only' => ['show']]);


