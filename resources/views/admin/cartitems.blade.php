@extends('admin.adminlayout')
@section('admincontent')

@php
$totalamount = 0
@endphp
<div class="container">
    <h3>Your Cart</h3>
    <hr>
    <div
        class="table-responsive"
    >
        <table
            class="table table-striped"
        >
            <thead>
                <tr>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Bill of Ind Product</th>
                </tr>
            </thead>
            <tbody>
               @foreach($rec as $r)
               <tr class="">
                    <td scope="row">{{$r->ProductName}}</td>
                    <td>{{$r->RegularPrice}}</td>
                    <td>{{$r->quantity}}</td>
                    <td>{{$r->total}}</td>
                    @php
                    $totalamount += $r->total
                    @endphp
                </tr>
              
               @endforeach
            </tbody>
        </table>

        <h3>Grand Total</h3>
        <hr>
        <p>
            @php 
            echo $totalamount
            @endphp

        </p>
        <form action="/confirmorder" method="post">
            @csrf
            <button type="submit" class="btn btn-success">CheckOut</button>
        </form>
    </div>
    
</div>
@endsection