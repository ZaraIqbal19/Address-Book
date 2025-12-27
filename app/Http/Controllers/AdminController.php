<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Order;
use App\Models\order_item;
use App\Models\cart;
use App\Models\Cart_item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Process\Process;

use function Laravel\Prompts\clear;

class AdminController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */
    public function admindashboard()
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
            'products'  => Product::count(),
            'orders'    => Order::count(),
            'customers' => Customer::count()
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW ALL ORDERS (CONFIRMATION)
    |--------------------------------------------------------------------------
    */
    public function orders()
    {
        $orders = Order::with('customer')->latest()->get();

        return view('admin.orders.index', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER DETAILS
    |--------------------------------------------------------------------------
    */
    public function orderDetails($id)
    {
        $order = order::with(['customer','items.product'])
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
        Order::findOrFail($id)->delete();
        return back()->with('success','Order deleted successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW CUSTOMERS
    |--------------------------------------------------------------------------
    */
    public function customers()
    {
        $customers = Customer::latest()->get();
        return view('admin.customers.index', compact('customers'));
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CUSTOMER
    |--------------------------------------------------------------------------
    */
    public function deleteCustomer($id)
    {
        Customer::findOrFail($id)->delete();
        return back()->with('success','Customer deleted successfully');
    }





// category
 /*
    |--------------------------------------------------------------------------
    | ADMIN – LIST ALL CATEGORIES
    |--------------------------------------------------------------------------
    */
    public function ShowCatogries()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN – SHOW CREATE FORM
    |--------------------------------------------------------------------------
    */
    // // i have to create the route of this function
    // public function createcatogry()
    // {
    //     return view('admin.categories.create');
    // }

    /*
    |--------------------------------------------------------------------------
    | ADMIN – STORE CATEGORY
    |--------------------------------------------------------------------------
    */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|unique:categories,name'
    //     ]);

    //     Categories::create([
    //         'name' => $request->name
    //     ]);

    //     return redirect()->route('categories.index')
    //         ->with('success', 'Category added successfully');
    // }

    /*
    |--------------------------------------------------------------------------
    | ADMIN – SHOW EDIT FORM
    |--------------------------------------------------------------------------
    */
    // public function edit($id)
    // {
    //     $category = Categories::findOrFail($id);
    //     return view('admin.categories.edit', compact('category'));
    // }

    /*
    |--------------------------------------------------------------------------
    | ADMIN – UPDATE CATEGORY
    |--------------------------------------------------------------------------
    */
    // public function update(Request $request, $id)
    // {
    //     $category = Categories::findOrFail($id);

    //     $request->validate([
    //         'name' => 'required|unique:categories,name,' . $category->id
    //     ]);

    //     $category->update([
    //         'name' => $request->name
    //     ]);

    //     return redirect()->route('categories.index')
    //         ->with('success', 'Category updated successfully');
    // }

    /*
    |--------------------------------------------------------------------------
    | ADMIN – DELETE CATEGORY
    |--------------------------------------------------------------------------
    */
    // public function destroy($id)
    // {
    //     Categories::findOrFail($id)->delete();

    //     return redirect()->route('categories.index')
    //         ->with('success', 'Category deleted successfully');
    // }


// Home Controller

public function showlatestproducts()
    {
        $categories = Category::orderBy('name')->get();

        $products = Product::with('category')
            ->latest()
            ->take(8)   // show latest 8 products on home
            ->get();

        return view('user.home', compact('categories', 'products'));
    }

    // product controller
     /*
    |--------------------------------------------------------------------------
    | USER SIDE – LIST PRODUCTS
    |--------------------------------------------------------------------------
    */
    // public function index(Request $request)
    // {
    //     $query = Products::with('category');

    //     // Filter by category (optional)
    //     if ($request->has('category')) {
    //         $query->where('category_id', $request->category);
    //     }

    //     $products = $query->paginate(12);

    //     return view('user.products', compact('products'));
    // }

    // /*
    // |--------------------------------------------------------------------------
    // | USER SIDE – VIEW SINGLE PRODUCT
    // |--------------------------------------------------------------------------
    // */
    // public function show($id)
    // {
    //     $product = Products::with('category')->findOrFail($id);
    //     return view('user.product-details', compact('product'));
    // }

    // /*
    // |--------------------------------------------------------------------------
    // | USER SIDE – SEARCH PRODUCT
    // |--------------------------------------------------------------------------
    // */
    // public function search(Request $request)
    // {
    //     $request->validate([
    //         'search' => 'required|string'
    //     ]);

    //     $products = Products::where('name', 'LIKE', '%'.$request->search.'%')
    //         ->paginate(12);

    //     return view('user.products', compact('products'));
    // }

    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDE – CREATE PRODUCT FORM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $categories = Category::all();
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

        Product::create([
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
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product','categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDE – UPDATE PRODUCT
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

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
        Product::findOrFail($id)->delete();

        return redirect()->route('products.index')
            ->with('success','Product deleted successfully');
    }

    public function addcategory(Request $req)
    {
        $categoryname = $req->categoryname;
        $table = new Category();
        $table->categoryname = $categoryname;
        $table->save();
        return redirect()->back()->with('Message','Category has been added');
    }


    


}

