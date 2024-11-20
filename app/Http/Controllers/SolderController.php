<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solder;

class SolderController extends Controller
{

    public function index()
    {
        $solder = Solder::orderBy('created_at', 'DESC')->get();
  
        return view('solder.index', compact('solder'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('solder.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Solder::create($request->all());
 
        return redirect()->route('solder')->with('success', 'solder added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $solder = Solder::findOrFail($id);
  
        return view('solder.show', compact('solder'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $solder = Solder::findOrFail($id);
  
        return view('solder.edit', compact('solder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $solder = Solder::findOrFail($id);
  
        $solder->update($request->all());
  
        return redirect()->route('solder')->with('success', 'solder updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $solder = Solder::findOrFail($id);
  
        $solder->delete();
  
        return redirect()->route('solder')->with('success', 'solder deleted successfully');
    }
}
