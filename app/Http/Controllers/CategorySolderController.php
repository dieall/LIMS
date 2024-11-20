<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategorySolder;

class CategorySolderController extends Controller
{

    public function index()
    {
        $categorysolder = CategorySolder::orderBy('created_at', 'ASC')->get();
  
        return view('categorysolder.index', compact('categorysolder'));
    }

 
    public function create()
    {
        $categories = CategorySolder::all();
        
        // Kirim data categories ke view
        return view('categorysolder.create', compact('categories'));
    }


    public function store(Request $request)
    {
        CategorySolder::create($request->all());
 
        return redirect()->route('categorysolder')->with('success', 'Category Solder added successfully');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

  
    public function update(Request $request, string $id)
    {
        //
    }

  
    public function destroy(string $id)
    {
        //
    }
}
