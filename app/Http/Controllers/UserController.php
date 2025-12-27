<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Order;
use App\Models\order_item;
use App\Models\cart;
use App\Models\Cart_item;


class UserController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('user.cart', compact('cart'));
    }

    /* Cart Controller
    |--------------------------------------------------------------------------
    | ADD PRODUCT TO CART
    |--------------------------------------------------------------------------
    */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
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

    public function checkout()
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->route('cart')
                ->with('error', 'Your cart is empty!');
        }

        return view('user.checkout', compact('cart'));
    }


    // ordercontroller

/*
    |--------------------------------------------------------------------------
    | CHECKOUT PAGE
    |--------------------------------------------------------------------------
    */


    /*
    |--------------------------------------------------------------------------
    | PLACE ORDER
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'address'     => 'required',
            'email'       => 'required|email',
            'work_phone'  => 'required',
            'cell_phone'  => 'required',
            'dob'         => 'required|date',
            'category'    => 'required',
            'remarks'     => 'nullable|string'
        ]);

        $cart = session()->get('cart');

        if (!$cart) {
            return redirect()->route('cart');
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE CUSTOMER
        |--------------------------------------------------------------------------
        */
        $customer = Customer::create([
            'name'        => $request->name,
            'address'     => $request->address,
            'email'       => $request->email,
            'work_phone'  => $request->work_phone,
            'cell_phone'  => $request->cell_phone,
            'dob'         => $request->dob,
            'category'    => $request->category,
            'remarks'     => $request->remarks
        ]);

        /*
        |--------------------------------------------------------------------------
        | CALCULATE TOTAL
        |--------------------------------------------------------------------------
        */
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        /*
        |--------------------------------------------------------------------------
        | SAVE ORDER
        |--------------------------------------------------------------------------
        */
        $order = Order::create([
            'customer_id' => $customer->id,
            'total'       => $total
        ]);

        /*
        |--------------------------------------------------------------------------
        | SAVE ORDER ITEMS
        |--------------------------------------------------------------------------
        */
        foreach ($cart as $productId => $item) {
                order_item::create([
                'order_id'  => $order->id,
                'product_id'=> $productId,
                'quantity'  => $item['quantity'],
                'price'     => $item['price']
            ]);

            // Reduce stock
            Product::where('id', $productId)
                ->decrement('stock', $item['quantity']);
        }

        /*
        |--------------------------------------------------------------------------
        | CLEAR CART
        |--------------------------------------------------------------------------
        */
        session()->forget('cart');

        return redirect()->route('order.success');
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER SUCCESS PAGE
    |--------------------------------------------------------------------------
    */

    public function success()
    {
        return view('user.order-success');
    }


}

