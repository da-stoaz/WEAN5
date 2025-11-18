@extends("layouts.app")

@section("title", "Create Heatpump")

@section("content")

<form action="{{ route('heatpump.store') }}" method="POST">
    @csrf
    <label for="name">Name:</label>
    <input class="border rounded-md" type="text" name="name">
    <label for="type">Type: </label>
    <input class="border rounded-md" type="text" name="type">
    <button class="bg-blue-400/40 py-2 px-4 rounded-md" type="submit">submit</button>
</form>

@endsection