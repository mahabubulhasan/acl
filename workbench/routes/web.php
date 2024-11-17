<?php

use Illuminate\Support\Facades\Route;
use Workbench\App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome workbench');
});

Route::resource('home', HomeController::class)->middleware('auth.acl');
