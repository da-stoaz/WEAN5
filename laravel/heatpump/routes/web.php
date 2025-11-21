<?php

use App\Http\Controllers\HeatpumpController;
use App\Models\Heatpump;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    // Get Variable Data from db for Dashboard

    $totalHeatpumps = Heatpump::count();

    $operationalCount = Heatpump::has("performanceData")->count();

    $inactive = $totalHeatpumps - $operationalCount;

    // Pass the data to the view using an array
    return view('welcome', [
        'total_systems' => $totalHeatpumps,
        'operational' => $operationalCount,
        "inactive" => $inactive
    ]);
});


Route::get('/heatpumps', [HeatpumpController::class, 'index'])->name('heatpump.list');

Route::get("/heatpumps/create", [HeatpumpController::class, "create"])->name("heatpump.create");
Route::post("/heatpumps", [HeatpumpController::class, "store"])->name("heatpump.store");


Route::get('/heatpumps/{heatpump}', [HeatpumpController::class, 'show'])->name('heatpump.show');;

Route::get("/heatpumps/{heatpump}/edit", [HeatpumpController::class, "edit"])->name("heatpump.edit");
