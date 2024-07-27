@extends('layouts.app')

@section('title', 'Create Invoice')

@section('content')
<div class="container">
    <h1>Create Invoice</h1>
    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="customer_name">Customer Name</label>
            <input type="text" id="customer_name" name="customer_name" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="invoice_number">Invoice Number</label>
            <input type="text" id="invoice_number" name="invoice_number" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="invoice_date">Invoice Date</label>
            <input type="date" id="invoice_date" name="invoice_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" id="due_date" name="due_date" class="form-control" required>
        </div>

        <h4>Items</h4>
        <table id="itemsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="items[0][item_name]" class="form-control" required></td>
                    <td><input type="number" name="items[0][quantity]" class="form-control qty" required></td>
                    <td><input type="number" step="0.01" name="items[0][price]" class="form-control price" required></td>
                    <td><input type="text" name="items[0][total]" class="form-control total" readonly></td>
                    <td><button type="button" class="btn btn-danger remove-item">Remove</button></td>
                </tr>
            </tbody>
        </table>
        <button type="button" id="add-item" class="btn btn-secondary">Add Item</button>
        <button type="submit" class="btn btn-primary">Save Invoice</button>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#itemsTable').DataTable();

    function updateTotal(row) {
        const qty = $(row).find('.qty').val();
        const price = $(row).find('.price').val();
        const total = qty * price;
        $(row).find('.total').val(total.toFixed(2));
    }

    $('#add-item').on('click', function() {
        var rowCount = $('#itemsTable tbody tr').length;
        $('#itemsTable tbody').append(`
            <tr>
                <td><input type="text" name="items[${rowCount}][item_name]" class="form-control" required></td>
                <td><input type="number" name="items[${rowCount}][quantity]" class="form-control qty" required></td>
                <td><input type="number" step="0.01" name="items[${rowCount}][price]" class="form-control price" required></td>
                <td><input type="text" name="items[${rowCount}][total]" class="form-control total" readonly></td>
                <td><button type="button" class="btn btn-danger remove-item">Remove</button></td>
            </tr>
        `);
    });

    $('#itemsTable').on('input', '.qty, .price', function() {
        updateTotal($(this).closest('tr'));
    });

    $('#itemsTable').on('click', '.remove-item', function() {
        $(this).closest('tr').remove();
    });
});
</script>
@endsection
