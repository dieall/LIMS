<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solar;

class SolarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $solar = Solar::orderBy('created_at', 'DESC')->get();
  
        return view('solar.index', compact('solar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('solar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Solar::create($request->all());
 
        return redirect()->route('solar')->with('success', 'solar added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $solar = Solar::findOrFail($id);
  
        return view('solar.show', compact('solar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $solar = Solar::findOrFail($id);
  
        return view('solar.edit', compact('solar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $solar = Solar::findOrFail($id);
  
        $solar->update($request->all());
  
        return redirect()->route('solar')->with('success', 'solar updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $solar = Solar::findOrFail($id);
  
        $solar->delete();
  
        return redirect()->route('solar')->with('success', 'solar deleted successfully');
    }
}
