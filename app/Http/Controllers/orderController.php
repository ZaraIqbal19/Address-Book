<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Customers;
use App\Models\Order;
use App\Models\order_items;
use App\Models\OrderItem;
use App\Models\Orders;
use App\Models\Product;
use App\Models\Products;

class OrderController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CHECKOUT PAGE
    |--------------------------------------------------------------------------
    */
    public function checkout()
    {
        $cart = session()->get('cart');

        if (!$cart || count($cart) == 0) {
            return redirect()->route('cart')
                ->with('error', 'Your cart is empty!');
        }

        return view('user.checkout', compact('cart'));
    }

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
        $customer = Customers::create([
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
        $order = Orders::create([
            'customer_id' => $customer->id,
            'total'       => $total
        ]);

        /*
        |--------------------------------------------------------------------------
        | SAVE ORDER ITEMS
        |--------------------------------------------------------------------------
        */
        foreach ($cart as $productId => $item) {
            order_items::create([
                'order_id'  => $order->id,
                'product_id'=> $productId,
                'quantity'  => $item['quantity'],
                'price'     => $item['price']
            ]);

            // Reduce stock
            Products::where('id', $productId)
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
