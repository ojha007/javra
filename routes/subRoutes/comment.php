<?php

use Illuminate\Support\Facades\Route;

Route::resource('comments', 'CommentController', ['only' => ['store']]);
