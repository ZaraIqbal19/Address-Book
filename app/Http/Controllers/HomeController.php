<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Product;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HOME PAGE
    |--------------------------------------------------------------------------
    | Shows categories and latest products
    */
    public function index()
    {
        $categories = Categories::orderBy('name')->get();

        $products = Products::with('category')
            ->latest()
            ->take(8)   // show latest 8 products on home
            ->get();

        return view('user.home', compact('categories', 'products'));
    }
}
