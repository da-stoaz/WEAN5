@extends("layouts.app")

@section("title", "Heatpump List")

@section("content")
    <h1 class="text-2xl">Heatpumps</h1>

    @foreach ($heatpumps as $heatpump)
        <div class="flex flex-row gap-5 ">
            <p>{{ $heatpump->id }}</p>
            <p>
                {{ $heatpump->name }}
            </p>
            <p>{{ $heatpump->type }}</p>
            <p>{{ $heatpump->timestamp }}</p>
        </div>


    @endforeach


@endsection