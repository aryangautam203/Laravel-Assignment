<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RssFeedController;

// Route::get('/', function () {
//     return view('welcome');
// });


// routes/web.php
Route::get('/', [RssFeedController::class, 'index']);
