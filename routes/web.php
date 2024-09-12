<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/filtered-users', [UserController::class, 'getUsers']);

Route::post('/save-user', [UserController::class, 'saveUser']);

Route::delete('api/users/delete/{id}', [UserController::class, 'deleteUser'])->middleware('api');
Route::get('api/users/all', [UserController::class, 'allUsers'])->middleware('api');
Route::post('api/users/add',[UserController::class, 'saveUserApi'])->middleware('api');

