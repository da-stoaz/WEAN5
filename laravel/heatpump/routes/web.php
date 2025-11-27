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

//Heatpumps list
Route::get('/heatpumps', [HeatpumpController::class, 'index'])->name('heatpump.list');

//Create heatpump Page
Route::get("/heatpumps/create", [HeatpumpController::class, "create"])->name("heatpump.create");
//Post heatpump
Route::post("/heatpumps", [HeatpumpController::class, "store"])->name("heatpump.store");

//Heatpump Details page
Route::get('/heatpumps/{heatpump}', [HeatpumpController::class, 'show'])->name('heatpump.show');;

Route::get("/heatpumps/{heatpump}/edit", [HeatpumpController::class, "edit"])->name("heatpump.edit");
Route::put("/heatpumps/{heatpump}", [HeatpumpController::class,"update"])->name("heatpump.update");

//heatpump delete page
Route::get("/heatpumps/{heatpump}/delete", [HeatpumpController::class,"delete"])->name("heatpump.delete");
//heatpump destroy function (actually delete it)
Route::delete("/heatpumps/{heatpump}", [HeatpumpController::class,"destroy"])->name("heatpump.destroy");




Route::match(['get', 'post'], '/api/heatpumps', [HeatpumpController::class, 'getHeatpumpData'])
    ->withoutMiddleware('web')
    ->middleware('api')
    ->name('heatpump.data');


//Performance Data aka. Logs
Route::get("/performance", [PerformanceDataController::class, "index"])->name("performance.list");
Route::get('/heatpumps/{heatpump}/logs/create', [PerformanceDataController::class, 'createForHeatpump'])->name('performance.create');
Route::post('/heatpumps/{heatpump}/logs', [PerformanceDataController::class, 'storeForHeatpump'])->name('performance.store');


Route::match(['get', 'post'], '/api/performance-data', [PerformanceDataController::class, 'data'])
    ->withoutMiddleware('web')
    ->middleware('api')
    ->name('performance.data');

Route::delete('/performance-data/{performanceData}', [PerformanceDataController::class, 'destroy'])
    ->name('performance.data.delete');
