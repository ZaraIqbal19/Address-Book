@extends('admin.layout')

@section('content')
<div class="container">
<h4>Order Details</h4>

<p><strong>Customer:</strong> {{ $order->customer->name }}</p>
<p><strong>Email:</strong> {{ $order->customer->email }}</p>

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
    <td>₹ {{ $item->price }}</td>
    <td>{{ $item->quantity }}</td>
    <td>₹ {{ $item->price * $item->quantity }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection
