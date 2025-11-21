@extends("layouts.app")

@section("title", "Heatpump " . $heatpump->name)


@section('breadcrumbs')
    <li class="inline-flex items-center">
        {{-- Link back to the Level 2 list --}}
        <a href="{{ route('heatpump.list') }}" class="hover:text-blue-600 transition-colors">
            Heatpumps
        </a>
    </li>
@endsection

@section("content")


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