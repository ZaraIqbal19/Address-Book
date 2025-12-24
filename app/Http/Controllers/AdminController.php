<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function dashboard()
    {
        $totalProducts = DB::table('products')->count();
        $totalCategories = DB::table('categories')->count();
        $totalOrders = DB::table('orders')->count();
        $totalCustomers = DB::table('customers')->count();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'totalOrders',
            'totalCustomers'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | DATABASE MAINTENANCE
    |--------------------------------------------------------------------------
    */
    public function database()
    {
        return view('admin.database');
    }

    /*
    |--------------------------------------------------------------------------
    | DATABASE BACKUP
    |--------------------------------------------------------------------------
    */
    public function backup()
    {
        $filename = 'backup_' . date('Y_m_d_His') . '.sql';

        $process = new Process([
            'mysqldump',
            '-u' . env('DB_USERNAME'),
            '-p' . env('DB_PASSWORD'),
            env('DB_DATABASE')
        ]);

        $process->run();

        file_put_contents(
            storage_path("app/$filename"),
            $process->getOutput()
        );

        return back()->with('success', 'Database Backup Created Successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | REPORT: TOP 10 BEST SELLING PRODUCTS
    |--------------------------------------------------------------------------
    */
    public function topProducts()
    {
        $products = DB::table('order_items')
            ->select(
                'products.name',
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->groupBy('products.name')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        return view('admin.reports.top-products', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | REPORT: TOP 10 CUSTOMERS
    |--------------------------------------------------------------------------
    */
    public function topCustomers()
    {
        $customers = DB::table('orders')
            ->select(
                'customers.name',
                DB::raw('COUNT(orders.id) as total_orders')
            )
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->groupBy('customers.name')
            ->orderByDesc('total_orders')
            ->limit(10)
            ->get();

        return view('admin.reports.top-customers', compact('customers'));
    }

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function admin()
    {
        return view('admin.dashboard', [
            'products'  => Products::count(),
            'orders'    => Orders::count(),
            'customers' => Customers::count()
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW ALL ORDERS (CONFIRMATION)
    |--------------------------------------------------------------------------
    */
    public function orders()
    {
        $orders = Orders::with('customer')
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER DETAILS
    |--------------------------------------------------------------------------
    */
    public function orderDetails($id)
    {
        $order = orders::with(['customer','items.product'])
            ->findOrFail($id);

        return view('admin.orders.details', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE ORDER
    |--------------------------------------------------------------------------
    */
    public function deleteOrder($id)
    {
        Orders::findOrFail($id)->delete();
        return back()->with('success','Order deleted successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW CUSTOMERS
    |--------------------------------------------------------------------------
    */
    public function customers()
    {
        $customers = Customers::latest()->get();
        return view('admin.customers.index', compact('customers'));
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CUSTOMER
    |--------------------------------------------------------------------------
    */
    public function deleteCustomer($id)
    {
        Customers::findOrFail($id)->delete();
        return back()->with('success','Customer deleted successfully');
    }
}


