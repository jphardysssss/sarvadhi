@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="container">
    <h1>Invoices</h1>
    @if (Auth::user()->role->name === 'doctor')
        <a href="{{ route('invoices.create') }}" class="btn btn-primary mb-3">Create Invoice</a>
    @endif
    <table id="invoicesTable" class="table table-striped">
        <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Customer Name</th>
                <th>Invoice Date</th>
                <th>Due Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->customer_name }}</td>
                    <td>{{ date('d-m-Y',strtotime($invoice->invoice_date)) }}</td>
                    <td>{{ date('d-m-Y',strtotime($invoice->due_date)) }}</td>
                    @if (Auth::user()->role->name === 'doctor')
                        <td>
                            <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    @else
                    <td>
                            <a href="{{ route('admin.invoices.show', $invoice) }}" class="btn btn-info btn-sm">View</a>
                    </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#invoicesTable').DataTable();
});
</script>
@endsection
