@extends('layouts.app')


@section('content')

<form action="{{ route('invoice.store') }}" method="post">
    @csrf

    <label class="h2">Namenseingabe</label>
    <br><br>

    <label for="name">Name</label>
    <input name="name" maxlength="30">
    
    weitere Label und Inputfelder

    <input type="submit" value="Rechnung erstellen">
</form>

@endsection


