<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;



class CategoryController extends Controller
{

    public function index()
    {
        $category = Category::orderBy('created_at', 'ASC')->get();
  
        return view('category.index', compact('category'));
    }

    public function create()
    {
        // Ambil semua data kategori dari database menggunakan Eloquent
        $categories = Category::all();
        
        // Kirim data categories ke view
        return view('category.create', compact('categories'));
    }

   
    public function store(Request $request)
    {
        Category::create($request->all());
 
        return redirect()->route('category')->with('success', 'Category added successfully');
    }

    public function show(string $id)
    {
        $category = Category::findOrFail($id);
  
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
  
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
  
        $category->update($request->all());
  
        return redirect()->route('category')->with('success', 'category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
  
        $category->delete();
  
        return redirect()->route('category')->with('success', 'category deleted successfully');
    }
}
