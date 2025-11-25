@extends("layouts.app")

@section("title", "Heatpump List")

@section('h1_title', 'Heatpump List')


@section('breadcrumbs')

<li class="inline-flex items-center">
    <a href="{{ route('heatpump.list') }}" class="hover:text-blue-600 transition-colors">
        Heatpumps
    </a>
</li>


@endsection

@section("action_button")

<a href="{{ route(name: "heatpump.create") }}" class="bg-amber-400/40 py-2 px-4 rounded-md smallcaps">
    Add heatpump
</a>

@endsection

@section("content")

<table class="" id="listTable">
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
            <td>
                <a class="hover:underline hover:text-blue-500 transition-all duration-100" href="{{ route('heatpump.show', $heatpump->id) }}"> {{ $heatpump->id }}</a>
            </td>
            <td>
                <a class="hover:underline hover:text-blue-500 transition-all duration-100" href="{{ route('heatpump.show', $heatpump->id) }}"> {{ $heatpump->name }}</a>
            </td>
            <td>{{ $heatpump->type }}</td>
            <td>{{ $heatpump->updated_at }} </td>

        </tr>
        @endforeach

    </tbody>

</table>


<script>
    $(document).ready(function() {
        $('#listTable').DataTable({
            stateSave: true,
        });
    });
</script>


@endsection