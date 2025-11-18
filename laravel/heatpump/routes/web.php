<?php

use App\Http\Controllers\HeatpumpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/heatpumps', [HeatpumpController::class, 'index'])->name('heatpump.list');

Route::get("/heatpumps/create", [HeatpumpController::class, "create"])->name("heatpump.create");
Route::post("/heatpumps", [HeatpumpController::class, "store"])->name("heatpump.store");