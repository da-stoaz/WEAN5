<?php

namespace App\Http\Controllers;

use App\Models\Heatpump;
use App\Models\PerformanceData;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class PerformanceDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$data = PerformanceData::orderBy("created_at","desc");
        $heatpumps = Heatpump::orderBy('name')->get(['id', 'name']);
        return view("performance.list", compact( "heatpumps"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PerformanceData $performanceData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PerformanceData $performanceData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PerformanceData $performanceData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PerformanceData $performanceData)
    {
        $performanceData->delete();

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function data(Request $request)
    {
        try {
            $filters = $request->input('filters', []);

            $query = PerformanceData::query()
                ->with('heatpump')
                ->when(isset($filters['heatpump_id']) && $filters['heatpump_id'] !== '', function ($q) use ($filters) {
                    $q->where('heatpump_id', $filters['heatpump_id']);
                })
                ->when(!empty($filters['heatpump']), function ($q) use ($filters) {
                    $name = $filters['heatpump'];
                    $q->whereHas('heatpump', function ($hp) use ($name) {
                        $hp->where('name', 'like', '%' . $name . '%');
                    });
                })
                ->when(isset($filters['outside_min']) && $filters['outside_min'] !== '', function ($q) use ($filters) {
                    $q->where('outside_temp', '>=', $filters['outside_min']);
                })
                ->when(isset($filters['outside_max']) && $filters['outside_max'] !== '', function ($q) use ($filters) {
                    $q->where('outside_temp', '<=', $filters['outside_max']);
                })
                ->when(isset($filters['inside_min']) && $filters['inside_min'] !== '', function ($q) use ($filters) {
                    $q->where('inside_temp', '>=', $filters['inside_min']);
                })
                ->when(isset($filters['inside_max']) && $filters['inside_max'] !== '', function ($q) use ($filters) {
                    $q->where('inside_temp', '<=', $filters['inside_max']);
                })
                ->when(isset($filters['supply_min']) && $filters['supply_min'] !== '', function ($q) use ($filters) {
                    $q->where('supply_temp', '>=', $filters['supply_min']);
                })
                ->when(isset($filters['supply_max']) && $filters['supply_max'] !== '', function ($q) use ($filters) {
                    $q->where('supply_temp', '<=', $filters['supply_max']);
                })
                ->when(isset($filters['return_min']) && $filters['return_min'] !== '', function ($q) use ($filters) {
                    $q->where('return_temp', '>=', $filters['return_min']);
                })
                ->when(isset($filters['return_max']) && $filters['return_max'] !== '', function ($q) use ($filters) {
                    $q->where('return_temp', '<=', $filters['return_max']);
                })
                ->when(!empty($filters['recorded_from']), function ($q) use ($filters) {
                    $date = $this->parseEuropeanDate($filters['recorded_from']);
                    if ($date) {
                        $q->whereDate('recorded_at', '>=', $date);
                    }
                })
                ->when(!empty($filters['recorded_to']), function ($q) use ($filters) {
                    $date = $this->parseEuropeanDate($filters['recorded_to']);
                    if ($date) {
                        $q->whereDate('recorded_at', '<=', $date);
                    }
                });

            return DataTables::eloquent($query)
                ->addColumn('heatpump_name', function (PerformanceData $row) {
                    return optional($row->heatpump)->name;
                })
                ->toJson();
        } catch (\Throwable $e) {
            return response()->json([
                'draw' => (int) $request->input('draw'),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'Could not load performance data: '.$e->getMessage(),
            ]);
        }
    }

    public function createForHeatpump(Heatpump $heatpump)
    {
        return view('performance.create', compact('heatpump'));
    }

    public function storeForHeatpump(Request $request, Heatpump $heatpump)
    {
        $data = $request->validate([
            'outside_temp' => ['required', 'numeric'],
            'inside_temp' => ['required', 'numeric'],
            'supply_temp' => ['required', 'numeric'],
            'return_temp' => ['required', 'numeric'],
            'recorded_at' => ['nullable', 'string'],
        ]);

        $data['heatpump_id'] = $heatpump->id;
        if (!empty($data['recorded_at'])) {
            $parsed = $this->parseEuropeanDateTime($data['recorded_at']);
            $data['recorded_at'] = $parsed ?? now();
        } else {
            $data['recorded_at'] = now();
        }

        PerformanceData::create($data);

        return redirect()->route('heatpump.show', $heatpump)
            ->with('success', 'Performance log added successfully.');
    }

    protected function parseEuropeanDate(string $value): ?Carbon
    {
        try {
            return Carbon::createFromFormat('d.m.Y', $value);
        } catch (\Throwable $e) {
            return null;
        }
    }

    protected function parseEuropeanDateTime(string $value): ?Carbon
    {
        $formats = ['d.m.Y H:i', 'd.m.Y'];
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $value);
            } catch (\Throwable $e) {
                continue;
            }
        }

        try {
            return Carbon::parse($value);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
