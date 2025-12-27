@extends('admin.adminlayout')
@section('admincontent')
<div class="container.cat">
    @if(session('successmsg'))
    <p>Category Added</p>
    @endif
    <form action="/add_cat" method="post">
        @csrf
        <input type="text" name="cat_name">
        <br>
        <input type="Number" name="cat_Qty">
        <br>
        <button type="submit" class="btn btn-success">Add Category</button>
    </form>
</div>
@endsection
