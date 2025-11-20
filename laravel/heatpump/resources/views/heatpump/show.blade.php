@extends("layouts.app")

@section("title", "Heatpump " . $heatpump->name)

@section("content")
<div class="flex flex-row items-center justify-start gap-3">
    <a href="{{ url()->previous() }}"
        class="text-lg px-2 py-1 border border-black/20 shadow bg-gray-300 rounded-lg">
        &lt; Back
    </a>
    <h1 class="text-3xl">{{ $heatpump->id }} Heatpump</h1>

</div>

<section>
    <div>ID: {{ $heatpump->id }}</div>
    <div>{{ $heatpump->name }}</div>
    <div>{{ $heatpump->type }}</div>
    <div>{{ $heatpump->updated_at }}</div>
</section>

<section>
    <h2 class="text-2xl">Logs</h2>
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