@extends("layouts.app")

@section("title", "Heatpump List")

@section("content")
    <h1>Heatpumps</h1>

    @foreach ($heatpumps as $heatpump)
        <p>{{ $heatpump->id }}</p>
        
    @endforeach


@endsection
