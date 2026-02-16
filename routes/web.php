<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/clearcache', function () {
    Artisan::call('optimize:clear');
});

Route::get('/migrate', function () {
    Artisan::call('migrate');
});

Route::get('/storagelink', function () {
    Artisan::call('storage:link');
});

Route::get('/',[HomeController::class,'index'])->name('index');
