<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sir;

class SirController extends Controller
{
    public function index()
    {
        $sir = Sir::orderBy('created_at', 'DESC')->get();
  
        return view('sir.index', compact('sir'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sir.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Sir::create($request->all());
 
        return redirect()->route('sir')->with('success', 'Sir added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sir = Sir::findOrFail($id);
  
        return view('sir.show', compact('sir'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sir = Sir::findOrFail($id);
  
        return view('sir.edit', compact('sir'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sir = Sir::findOrFail($id);
  
        $sir->update($request->all());
  
        return redirect()->route('sir')->with('success', 'SIR updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sir = Sir::findOrFail($id);
  
        $sir->delete();
  
        return redirect()->route('sir')->with('success', 'SIR deleted successfully');
    }
}
