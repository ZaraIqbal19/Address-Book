<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Products;

class CartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | VIEW CART
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('user.cart', compact('cart'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADD PRODUCT TO CART
    |--------------------------------------------------------------------------
    */
    public function add(Request $request, $id)
    {
        $product = Products::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => $request->quantity,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE CART QUANTITY
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        if ($request->quantity && session()->has('cart')) {
            $cart = session()->get('cart');
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart')
            ->with('success', 'Cart updated successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE ITEM FROM CART
    |--------------------------------------------------------------------------
    */
    public function remove($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart')
            ->with('success', 'Item removed from cart!');
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAR CART
    |--------------------------------------------------------------------------
    */
    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart')
            ->with('success', 'Cart cleared successfully!');
    }
}
