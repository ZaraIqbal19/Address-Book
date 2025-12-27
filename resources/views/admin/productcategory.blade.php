@extends('admin.adminlayout')

@section('admincontent')

<style>
    .cat-container {
        max-width: 500px;
        margin: 60px auto;
        background: #ffffff;
        padding: 30px;
        border-radius: 18px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .cat-title {
        font-weight: 700;
        margin-bottom: 25px;
        text-align: center;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 10px;
    }

    .form-control {
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 15px;
    }

    .btn-success {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border-radius: 30px;
        font-weight: 600;
    }

    .success-msg {
        background: #e9f7ef;
        color: #198754;
        padding: 12px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: 20px;
        font-weight: 500;
    }
</style>

<div class="cat-container">

    <h4 class="cat-title">Add New Category</h4>

    @if(session('successmsg'))
        <div class="success-msg">
            {{ session('successmsg') }}
        </div>
    @endif

    <form action="/add_cat" method="post">
        @csrf

        <input
            type="text"
            name="cat_name"
            class="form-control"
            placeholder="Category Name"
            required
        >

        <input
            type="number"
            name="Quantity"
            class="form-control"
            placeholder="Category Quantity"
            required
        >

        <button type="submit" class="btn btn-success mt-3">
            Add Category
        </button>

    </form>

</div>

@endsection

