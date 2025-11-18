@extends("layouts.app")

@section("title", "Heatpump List")

@section("content")
<h1 class="text-2xl">Heatpumps</h1>

<table class="" id="myTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($heatpumps as $heatpump)
        <tr>
            <td>{{ $heatpump->id }}</td>
            <td>{{ $heatpump->name }}</td>
            <td>{{ $heatpump->type }}</td>
            <td>{{ $heatpump->updated_at }}</td>
        </tr>

        @endforeach

    </tbody>

</table>


<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>


@endsection