<?php

use App\Http\Controllers\HeatpumpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/heatpumps', [HeatpumpController::class,'index'])->name('heatpump.list');


