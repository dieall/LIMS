<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mixing;

class MixingController extends Controller
{
    public function index()
    {
        $mixing = Mixing::orderBy('created_at', 'DESC')->get();
  
        return view('mixing.index', compact('mixing'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mixing.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Mixing::create($request->all());
 
        return redirect()->route('mixing')->with('success', 'Mixing added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mixing = Mixing::findOrFail($id);
  
        return view('mixing.show', compact('mixing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mixing = Mixing::findOrFail($id);
  
        return view('mixing.edit', compact('mixing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mixing = Mixing::findOrFail($id);
  
        $mixing->update($request->all());
  
        return redirect()->route('mixing')->with('success', 'NH3 updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mixing = Mixing::findOrFail($id);
  
        $mixing->delete();
  
        return redirect()->route('mixing')->with('success', 'Mixing deleted successfully');
    }
}
