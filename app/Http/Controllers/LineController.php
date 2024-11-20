<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Line;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $line = Line::orderBy('created_at', 'DESC')->get();
  
        return view('line.index', compact('line'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('line.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Line::create($request->all());
 
        return redirect()->route('line')->with('success', 'LINE added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $line = Line::findOrFail($id);
  
        return view('line.show', compact('line'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $line = Line::findOrFail($id);
  
        return view('line.edit', compact('line'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $line = Line::findOrFail($id);
  
        $line->update($request->all());
  
        return redirect()->route('line')->with('success', 'LINE updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $line = Line::findOrFail($id);
  
        $line->delete();
  
        return redirect()->route('line')->with('success', 'Line deleted successfully');
    }
}
