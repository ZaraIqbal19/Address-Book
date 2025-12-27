@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Product Categories</h3>
    <div class="row mb-5">
        @foreach($categories as $category)
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5>{{ $category->name }}</h5>
                        <a href="{{ route('products', ['category' => $category->id]) }}"class="btn btn-outline-primary btn-sm">View Products</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h3 class="mb-4">Latest Products</h3>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm">
                    <img src="{{ asset($product->image) }}" class="card-img-top">
                    <div class="card-body">
                        <h6>{{ $product->name }}</h6>
                        <p class="text-muted">₹ {{ $product->price }}</p>
                        <a href="{{ route('product.show', $product->id) }}"class="btn btn-primary btn-sm w-100">View</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
