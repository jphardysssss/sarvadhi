@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
<div class="container">
    <h1>Invoice Details</h1>
    <table class="table table-striped">
        <tr>
            <th>Customer Name:</th>
            <td>{{ $invoice->customer_name }}</td>
        </tr>
        <tr>
            <th>Invoice Number:</th>
            <td>{{ $invoice->invoice_number }}</td>
        </tr>
        <tr>
            <th>Invoice Date:</th>
            <td>{{ date('d-m-Y',strtotime($invoice->invoice_date)) }}</td>
        </tr>
        <tr>
            <th>Due Date:</th>
            <td>{{ date('d-m-Y',strtotime($invoice->due_date)) }}</td>
        </tr>
    </table>

    <h3>Items</h3>
    <table id="itemsTable" class="table table-striped">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->quantity * $item->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#itemsTable').DataTable();
});
</script>
@endsection
