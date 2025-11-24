@extends("layouts.app")

@section("title", content: "Heatpump " . $heatpump->name)

@section('h1_title', "Heatpump " . $heatpump->name)


@section('breadcrumbs')

{{-- A. Link back to the Heatpump List --}}
<li class="inline-flex items-center">
    <a href="{{ route('heatpump.list') }}" class="hover:text-blue-600 transition-colors">
        Heatpumps
    </a>
</li>

{{-- Separator --}}
<li><span class="mx-1 text-gray-400">/</span></li>

{{-- B. The Final, Active Item --}}
<li aria-current="page">
    <span class="font-medium text-gray-800">{{ $heatpump->name }}</span>
</li>
@endsection

@section('action_button')

<div class="flex flex-row gap-3">
    <a href="{{ route('heatpump.edit', $heatpump) }}"
        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 transition-colors shadow-sm">

        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
        </svg>

        Edit Details
    </a>
    <a href="{{ route('heatpump.delete', $heatpump) }}"
        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 bg-red-400 border border-gray-300 rounded-lg hover:bg-red-500 focus:ring-4 focus:ring-gray-100 transition-colors shadow-sm">

        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24">
            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 5h22m-8.75-4h-4.5a1.5 1.5 0 0 0-1.5 1.5V5h7.5V2.5a1.5 1.5 0 0 0-1.5-1.5m-4.5 16.75v-7.5m4.5 7.5v-7.5m4.61 11.37A1.49 1.49 0 0 1 17.37 23H6.63a1.49 1.49 0 0 1-1.49-1.38L3.75 5h16.5z" />
        </svg>

        Delete
    </a>
</div>

@endsection

@section("content")

<section>
    <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>

    <dl class="grid grid-cols-[140px_1fr] gap-y-4 text-sm">

        <dt class="font-medium text-gray-500">System ID</dt>
        <dd class="text-gray-900 font-semibold">#{{ $heatpump->id }}</dd>

        <dt class="font-medium text-gray-500">Customer</dt>
        <dd class="text-gray-900">{{ $heatpump->name }}</dd>

        <dt class="font-medium text-gray-500">Type</dt>
        <dd class="text-gray-900">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                {{ $heatpump->type }}
            </span>
        </dd>

        <dt class="font-medium text-gray-500">Last Update</dt>
        <dd class="text-gray-900">
            {{ $heatpump->updated_at->format('d M Y, H:i') }}
        </dd>

    </dl>
</section>

<section class="mt-6">
    <h2 class="text-2xl font-bold border-b pb-2">Logs</h2>
    <table id="performanceData">
        <thead>
            <tr>
                <th>ID</th>
                <th>Outside (°C)</th>
                <th>Inside (°C)</th>
                <th>Supply (°C)</th>
                <th>Return (°C)</th>
                <th>Recorded at</th>
            </tr>
        </thead>
        <tbody>
            @foreach($heatpump->performanceData as $log)
            <tr>
                <td>{{ $log->id }}</td>
                <td>{{ $log->outside_temp }}</td>
                <td>{{ $log->inside_temp }}</td>
                <td>{{ $log->supply_temp }}</td>
                <td>{{ $log->return_temp }}</td>
                <td>{{ $log->recorded_at }}</td>
            </tr>

            @endforeach

            </thead>
    </table>

</section>


<script>
    $(document).ready(function() {
        $('#performanceData').DataTable({
            stateSave: true,
        });
    });
</script>



@endsection