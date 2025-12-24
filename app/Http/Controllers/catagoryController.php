<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN – LIST ALL CATEGORIES
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $categories = Categories::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN – SHOW CREATE FORM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.categories.create');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN – STORE CATEGORY
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        Categories::create([
            'name' => $request->name
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category added successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN – SHOW EDIT FORM
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN – UPDATE CATEGORY
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $category = Categories::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN – DELETE CATEGORY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        Categories::findOrFail($id)->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
