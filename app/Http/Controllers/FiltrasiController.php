<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Filtrasi;

class FiltrasiController extends Controller
{
    public function index()
    {
        $filtrasi = Filtrasi::orderBy('created_at', 'DESC')->get();
  
        return view('filtrasi.index', compact('filtrasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('filtrasi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Filtrasi::create($request->all());
 
        return redirect()->route('filtrasi')->with('success', 'Filtrasi added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $filtrasi = Filtrasi::findOrFail($id);
  
        return view('filtrasi.show', compact('filtrasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $filtrasi = Filtrasi::findOrFail($id);
  
        return view('filtrasi.edit', compact('filtrasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $filtrasi = Filtrasi::findOrFail($id);
  
        $filtrasi->update($request->all());
  
        return redirect()->route('filtrasi')->with('success', 'Filtrasi updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $filtrasi = Filtrasi::findOrFail($id);
  
        $filtrasi->delete();
  
        return redirect()->route('filtrasi')->with('success', 'Filtrasi deleted successfully');
    }
}
