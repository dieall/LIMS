<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ri;


class RiController extends Controller
{
    public function index()
    {
        $ri = Ri::orderBy('created_at', 'DESC')->get();
  
        return view('ri.index', compact('ri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ri.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Ri::create($request->all());
 
        return redirect()->route('ri')->with('success', 'R1 added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ri = Ri::findOrFail($id);
  
        return view('ri.show', compact('ri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ri = Ri::findOrFail($id);
  
        return view('ri.edit', compact('ri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ri = Ri::findOrFail($id);
  
        $ri->update($request->all());
  
        return redirect()->route('ri')->with('success', 'RI updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ri = Ri::findOrFail($id);
  
        $ri->delete();
  
        return redirect()->route('ri')->with('success', 'RI deleted successfully');
    }
}
