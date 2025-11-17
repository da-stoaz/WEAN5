<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get("test", function () {
    return ("Hello World");
});

//List
Route::get("invoice", [InvoiceController::class, 'index'])->name("invoice.list");

//Create Routes
Route::get('/invoice/create', [InvoiceController::class, 'create'])->name('invoice.create');
Route::post('/invoice', [InvoiceController::class, 'store'])->name('invoice.store');


//Update Routes
Route::get("/invoice/edit", [InvoiceController::class, "edit"])->name('invoice.create');
Route::put('/invoice/{id}', [InvoiceController::class, 'update'])->name('invoice.update');

//Delete Routes
Route::get('/invoice/{id}/delete', [InvoiceController::class, 'show'])->name('invoice.show'); 
Route::delete('/invoice/{id}', [InvoiceController::class, 'destroy'])->name('invoice.destroy');