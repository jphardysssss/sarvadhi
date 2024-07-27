<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    // For doctors - full CRUD
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role->name == 'admin') {
            $invoices = Invoice::get();
            return view('invoices.index', compact('invoices'));
        }

        $invoices = Invoice::where('user_id', $user->id)->get();
        return view('invoices.index', compact('invoices'));
    }

    // Show details for both roles
    public function show(Invoice $invoice)
    {
        // You can add further authorization checks if needed
        return view('invoices.show', compact('invoice'));
    }

    // Other methods (create, store, edit, update, destroy) for doctors
    public function create()
    {
        // Only doctors can create
        // $this->authorize('create', Invoice::class);
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        // $this->authorize('create', Invoice::class);
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'invoice_number' => 'required|string|unique:invoices',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'customer_name' => $request->customer_name,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'user_id' => Auth::id(),
        ]);

        foreach ($request->items as $item) {
            $invoice->items()->create($item);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function edit(Invoice $invoice)
    {
        // $this->authorize('update', $invoice);
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        // $this->authorize('update', $invoice);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'invoice_number' => 'required|string|unique:invoices,invoice_number,' . $invoice->id,
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'items' => 'required|array',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $invoice->update([
            'customer_name' => $request->customer_name,
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
        ]);

        $invoice->items()->delete();
        foreach ($request->items as $item) {
            $invoice->items()->create($item);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        // $this->authorize('delete', $invoice);
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
    }
}
