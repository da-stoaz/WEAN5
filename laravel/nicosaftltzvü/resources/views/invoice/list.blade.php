@extends('layouts.app')

@section('content')
    <h1>Rechnungsliste</h1>
    
    <div style="margin-bottom: 20px;">
        <a href="{{ route('invoice.create') }}" class="btn btn-primary">Neue Rechnung erfassen</a>
    </div>

    @if(session('success'))
        <div style="color: green; margin-bottom: 10px;">{{ session('success') }}</div>
    @endif

    <table border="1" cellpadding="10" style="border-collapse: collapse; width: 100%;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Netto Preis</th>
                <th>Aktionen</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->name }}</td>
                    <td>{{ $invoice->priceNet }}</td>
                    <td>
                        <a href="{{ route('invoice.edit', $invoice->id) }}">Bearbeiten</a>
                        | 
                        <a href="{{ route('invoice.show', $invoice->id) }}" style="color: red;">Löschen</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection