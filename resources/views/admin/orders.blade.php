@extends('admin.layout')

@section('content')

<style>
    .order-container {
        background: #ffffff;
        padding: 30px;
        border-radius: 18px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.08);
        margin-top: 30px;
    }

    .order-title {
        font-weight: 700;
        margin-bottom: 20px;
        border-left: 6px solid #0d6efd;
        padding-left: 15px;
    }

    .customer-info {
        background: #f5f8ff;
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 25px;
    }

    .customer-info p {
        margin-bottom: 6px;
        font-size: 15px;
    }

    .table {
        margin-top: 20px;
        border-radius: 12px;
        overflow: hidden;
    }

    .table thead {
        background: #0d6efd;
        color: #ffffff;
    }

    .table th {
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        padding: 14px;
    }

    .table td {
        padding: 14px;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background: #f8faff;
    }

    .price {
        font-weight: 600;
        color: #198754;
    }

    .total {
        font-weight: 700;
        color: #dc3545;
    }

    .back-btn {
        margin-top: 25px;
    }
</style>

<div class="container order-container">

    <h4 class="order-title">Order Details</h4>

    <div class="customer-info">
        <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
        <p><strong>Email:</strong> {{ $order->customer->email }}</p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td class="price">₹ {{ $item->price }}</td>
                <td>{{ $item->quantity }}</td>
                <td class="total">₹ {{ $item->price * $item->quantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ url()->previous() }}" class="btn btn-secondary back-btn">
        ← Back
    </a>

</div>

@endsection

