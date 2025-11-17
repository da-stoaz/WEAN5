<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Pail\ValueObjects\Origin\Console;

class InvoiceController extends Controller
{
    /**
     * Zeigt alle Rechnungen an.
     */
    public function index()
    {
        $data = DB::table('invoice')->get();
        return view('invoice.list', compact(var_name: 'data'));
    }

    /**
     * Zeigt das Formular zum Erstellen einer neuen Rechnung.
     */
    public function create()
    {
        // Zeigt deine Datei resources/views/invoice/create.blade.php
        return view('invoice.create');
    }

    /**
     * Speichert eine neue Rechnung in der Datenbank.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'invoice_number' => 'required|string|max:50|unique:invoice,invoice_number',
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'user' => 'required|string|max:100',
        ]);

        Invoice::create($validated);

        return redirect()->route('invoices.list')->with('success', 'Rechnung erfolgreich erstellt.');
    }

    /**
     * Zeigt eine einzelne Rechnung an (optional).
     */
    public function show(Invoice $invoice)
    {
        // Wenn du später eine Detailansicht willst, kannst du hier eine View wie 'show-invoice' verwenden
        return view('invoice.list', compact('invoice'));
    }

    /**
     * Bearbeiten (optional).
     */
    public function edit(Invoice $invoice)
    {
        // Wenn du später eine Edit-View hast, hier anpassen
        return view('create-invoices', compact('invoice'));
    }

    /**
     * Aktualisiert eine bestehende Rechnung.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string|max:50|unique:invoice,invoice_number,' . $invoice->id,
            'price' => 'required|numeric|min:0',
            'date' => 'required|date',
            'user' => 'required|string|max:100',
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.index')->with('success', 'Rechnung erfolgreich aktualisiert.');
    }

    /**
     * Löscht eine Rechnung.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('invoices.index')->with('success', 'Rechnung gelöscht.');
    }
}
