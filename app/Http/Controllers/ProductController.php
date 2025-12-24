<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Products;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | USER SIDE – LIST PRODUCTS
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Products::with('category');

        // Filter by category (optional)
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(12);

        return view('user.products', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | USER SIDE – VIEW SINGLE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $product = Products::with('category')->findOrFail($id);
        return view('user.product-details', compact('product'));
    }

    /*
    |--------------------------------------------------------------------------
    | USER SIDE – SEARCH PRODUCT
    |--------------------------------------------------------------------------
    */
    public function search(Request $request)
    {
        $request->validate([
            'search' => 'required|string'
        ]);

        $products = Products::where('name', 'LIKE', '%'.$request->search.'%')
            ->paginate(12);

        return view('user.products', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDE – CREATE PRODUCT FORM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $categories = Categories::all();
        return view('admin.products.create', compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDE – STORE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'category_id' => 'required',
            'image'       => 'required|image'
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads/products'), $imageName);

        Products::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'category_id' => $request->category_id,
            'image'       => 'uploads/products/'.$imageName
        ]);

        return redirect()->route('products.index')
            ->with('success','Product added successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDE – EDIT PRODUCT FORM
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $product = Products::findOrFail($id);
        $categories = Categories::all();

        return view('admin.products.edit', compact('product','categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDE – UPDATE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $product = Products::findOrFail($id);

        $request->validate([
            'name'        => 'required',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'category_id' => 'required',
            'image'       => 'nullable|image'
        ]);

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $product->image = 'uploads/products/'.$imageName;
        }

        $product->update([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'category_id' => $request->category_id
        ]);

        return redirect()->route('products.index')
            ->with('success','Product updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDE – DELETE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        Products::findOrFail($id)->delete();

        return redirect()->route('products.index')
            ->with('success','Product deleted successfully');
    }
}
