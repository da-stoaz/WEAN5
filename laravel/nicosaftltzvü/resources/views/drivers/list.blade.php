@extends("layouts.app")

@if (session('success'))
    <div class="bg-green-100 text-green-800 p-2 rounded">
        {{ session('success') }}
    </div>
@endif


@section("content")

<div class="flex flex-row justify-between">
    <div>
        <h2 class="text-2xl ">
            My drivers
        </h2>
    </div>
    <div><a href="{{route("drivers.create")}}">Add driver</a> </div>
</div>

<ul>
    @foreach($drivers as $driver)
        <li class="font-light">
            <div>
                Driver {{$driver->name}};
                SSN: {{$driver->ssn}};
                {{$driver->birthdate->format("d/m/Y")}}
            </div>
        </li>
    @endforeach
</ul>

@stop


