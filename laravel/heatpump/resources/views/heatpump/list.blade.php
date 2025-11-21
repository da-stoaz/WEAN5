@extends("layouts.app")

@section("title", "Heatpump List")

@section("action_button")

<a href="{{ route(name: "heatpump.create") }}" class="bg-amber-400/40 py-2 px-4 rounded-md smallcaps">
    Add heatpump</a>

@endsection

@section("content")

<table class="" id="listTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Updated At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($heatpumps as $heatpump)
        <tr>
            <td>{{ $heatpump->id }}</td>
            <td>{{ $heatpump->name }}</td>
            <td>{{ $heatpump->type }}</td>
            <td>{{ $heatpump->updated_at }} </td>
            <td>
                <a href="{{ route('heatpump.show', $heatpump->id) }}"
                    class="bg-blue-400/40 py-2 px-4 rounded-md smallcaps">
                    show
                </a>

            </td>
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