<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $drivers = Driver::all();
        return view('drivers.list', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("drivers.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        echo $request;

        $validated = $request->validate(["name" => "required|min:3",
            "ssn" => "required", "birthdate" => "required|date"]);

        Driver::create($validated);

        return redirect()->route('drivers.list')->with('success', 'Driver created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Driver $driver)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Driver $driver)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate(["name" => "required|min:3",
            "ssn" => "required", "birthdate" => "required|date"]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Driver $driver)
    {
        Driver::destroy($driver);
        return redirect()->route('drivers.list')->with('success', 'Driver deleted successfully');
    }
}
