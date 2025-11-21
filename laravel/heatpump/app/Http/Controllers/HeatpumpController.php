<?php

namespace App\Http\Controllers;

use App\Enums\HeatpumpType;
use App\Models\Heatpump;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules\Enum;

class HeatpumpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $heatpumps = Heatpump::all();
        return view("heatpump.list", compact(var_name: "heatpumps"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("heatpump.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    

        $data = $request->validate([
            "name" => "required|string|max:128",
            "type" => ["required", new Enum(HeatpumpType::class)]
        ]);
        Heatpump::create($data);

        return redirect()->route('heatpump.list')
            ->with('success', 'Heatpump created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Heatpump $heatpump)
    {
        $heatpumps = Heatpump::all();

        return view('heatpump.show', compact('heatpump'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Heatpump $heatpump)
    {
        return view('heatpump.edit', compact('heatpump'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Heatpump $heatpump)
    {
        //
    }

    public function delete(Heatpump $heatpump){
        return view("heatpump.delete", compact("heatpump"));
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Heatpump $heatpump)
    {
        //
    }
}
