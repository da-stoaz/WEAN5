<?php

use App\Http\Controllers\HeatpumpController;
use App\Http\Controllers\PerformanceDataController;
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
Route::get('/heatpumps/datatables', [HeatpumpController::class, 'datatablesDemo'])->name('heatpump.datatables');

Route::get("/heatpumps/create", [HeatpumpController::class, "create"])->name("heatpump.create");
Route::post("/heatpumps", [HeatpumpController::class, "store"])->name("heatpump.store");


Route::get('/heatpumps/{heatpump}', [HeatpumpController::class, 'show'])->name('heatpump.show');;

Route::get("/heatpumps/{heatpump}/edit", [HeatpumpController::class, "edit"])->name("heatpump.edit");

Route::get("/heatpumps/{heatpump}/delete", [HeatpumpController::class,"delete"])->name("heatpump.delete");
Route::delete("/heatpumps/{heatpump}", [HeatpumpController::class,"destroy"])->name("heatpump.destroy");

Route::get("/performance", [PerformanceDataController::class, "index"])->name("performance.list");


Route::match(['get', 'post'], '/api/heatpumps', [HeatpumpController::class, 'getHeatpumpData'])
    ->withoutMiddleware('web')
    ->middleware('api')
    ->name('heatpump.data');
Route::match(['get', 'post'], '/api/performance-data', [PerformanceDataController::class, 'data'])
    ->withoutMiddleware('web')
    ->middleware('api')
    ->name('performance.data');
