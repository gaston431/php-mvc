<?php

use App\Controllers\HomeController;
use App\Controllers\PostController;
use App\Route;

/* Route::get('/', function () {
    echo 'Hola';
}); */

Route::get('/', [HomeController::class,'index']);

Route::get('/posts', [PostController::class, 'index']);

Route::get('/posts/create', [PostController::class, 'create']);

Route::post('/posts', [PostController::class, 'store']);

Route::get('/posts/:id', [PostController::class, 'show']);

Route::get('/posts/:id/edit', [PostController::class, 'edit']);

//Route::post('/posts/:id', [PostController::class, 'update']);

Route::put('/posts', [PostController::class, 'update']);

//Route::post('/posts/:id/delete', [PostController::class, 'destroy']);

Route::delete('/posts', [PostController::class, 'destroy']);

Route::get('/contact', function () {
    echo 'Hola desde contact';
});

/* Route::get('/contacts/test', function () {
    echo "Hola desde test";
});

Route::get('/contacts/:id', function ($id) {
    echo "Hola desde contact $id";
}); */

Route::dispatch();