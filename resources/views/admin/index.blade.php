@extends('admin.layout')

@section('content')
<div class="container">
<h3>Customer Orders</h3>

<table class="table table-bordered">
<thead>
<tr>
    <th>#</th>
    <th>Customer</th>
    <th>Total</th>
    <th>Date</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($orders as $order)
<tr>
    <td>{{ $order->id }}</td>
    <td>{{ $order->customer->name }}</td>
    <td>₹ {{ $order->total }}</td>
    <td>{{ $order->created_at->format('d-m-Y') }}</td>
    <td>
        <a href="{{ route('admin.order.details',$order->id) }}"
           class="btn btn-info btn-sm">View</a>

        <form method="POST"
              action="{{ route('admin.order.delete',$order->id) }}"
              style="display:inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection

@extends('admin.layout')

@section('content')
<div class="container">
<h3>Customers</h3>

<table class="table table-bordered">
<thead>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($customers as $cust)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $customers->name }}</td>
    <td>{{ $customers->email }}</td>
    <td>{{ $customers->cell_phone }}</td>
    <td>
        <form method="POST"
              action="{{ route('admin.customer.delete',$customers->id) }}">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection

@extends('admin.layout')

@section('content')
<div class="container">
<h3>Categories</h3>

<a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">
Add Category
</a>

<table class="table table-bordered">
<thead>
<tr>
    <th>#</th>
    <th>Name</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($categories as $cat)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $cat->name }}</td>
    <td>
        <a href="{{ route('categories.edit',$cat->id) }}"
        class="btn btn-warning btn-sm">Edit</a>

        <form method="POST" action="{{ route('categories.destroy',$cat->id) }}"
            style="display:inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">Delete</button>
        </form>
    </td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection

