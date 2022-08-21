<?php

use Illuminate\Support\Facades\Route;
use Uzzal\Acl\Http\ResourceController;
use Uzzal\Acl\Http\RoleController;

Route::group(['middleware' => ['web','auth.acl']], function () {
    Route::get('role', [RoleController::class, 'index']);
    Route::get('role/create', [RoleController::class, 'create']);
    Route::post('role/store', [RoleController::class, 'store']);
    Route::get('role/edit/{id}', [RoleController::class, 'edit']);
    Route::post('role/update/{id}', [RoleController::class, 'update']);
    Route::get('role/destroy/{id}', [RoleController::class, 'destroy']);

    Route::get('resource', [ResourceController::class, 'index']);
    Route::get('resource/create', [ResourceController::class, 'create']);
    Route::post('resource/store', [ResourceController::class, 'store']);
    Route::get('resource/edit/{id}', [ResourceController::class, 'edit']);
    Route::post('resource/update/{id}', [ResourceController::class, 'update']);
    Route::get('resource/destroy/{id}', [ResourceController::class, 'destroy']);
});
