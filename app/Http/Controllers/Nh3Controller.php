<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nh3;

class Nh3Controller extends Controller
{
    public function index()
    {
        $nh3 = Nh3::orderBy('created_at', 'DESC')->get();
  
        return view('nh3.index', compact('nh3'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('nh3.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Nh3::create($request->all());
 
        return redirect()->route('nh3')->with('success', 'NH3 added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $nh3 = Nh3::findOrFail($id);
  
        return view('nh3.show', compact('nh3'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $nh3 = Nh3::findOrFail($id);
  
        return view('nh3.edit', compact('nh3'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $nh3 = Nh3::findOrFail($id);
  
        $nh3->update($request->all());
  
        return redirect()->route('nh3')->with('success', 'NH3 updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nh3 = Nh3::findOrFail($id);
  
        $nh3->delete();
  
        return redirect()->route('nh3')->with('success', 'NH3 deleted successfully');
    }
}
