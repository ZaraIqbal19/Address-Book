@extends('admin.layout')

@section('content')
<div class="container mt-4">
<div class="row">

<div class="col-md-4">
    <div class="card bg-primary text-white text-center">
        <div class="card-body">
            <h4>{{ $products }}</h4>
            <p>Products</p>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card bg-success text-white text-center">
        <div class="card-body">
            <h4>{{ $orders }}</h4>
            <p>Orders</p>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="card bg-dark text-white text-center">
        <div class="card-body">
            <h4>{{ $customers }}</h4>
            <p>Customers</p>
        </div>
    </div>
</div>

</div>
</div>
@endsection
