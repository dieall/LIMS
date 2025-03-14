<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trial;

class TrialController extends Controller
{
    public function index()
    {
        $trial = Trial::orderBy('created_at', 'DESC')->get();
  
        return view('trial.index', compact('trial'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('trial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Trial::create($request->all());
 
        return redirect()->route('trial')->with('success', 'Trial added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trial = Trial::findOrFail($id);
  
        return view('trial.show', compact('trial'));
    }

    public function edit($id)
    {
        $trial = Trial::findOrFail($id);
        return view('trial.edit', compact('trial'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_trial' => 'required|string|max:255', // Validasi
        ]);

        $trial = Trial::findOrFail($id);
        $trial->update($request->all());

        return redirect()->route('trial')->with('success', 'Trial updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trial = Trial::findOrFail($id);
  
        $trial->delete();
  
        return redirect()->route('trial')->with('success', 'Trial deleted successfully');
    }
}
