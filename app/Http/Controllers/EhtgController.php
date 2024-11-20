<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ehtg;

class EhtgController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ehtg = Ehtg::orderBy('created_at', 'DESC')->get();
  
        return view('ehtg.index', compact('ehtg'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ehtg.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Ehtg::create($request->all());
 
        return redirect()->route('ehtg')->with('success', 'EHTG added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ehtg = Ehtg::findOrFail($id);
  
        return view('ehtg.show', compact('ehtg'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ehtg = Ehtg::findOrFail($id);
  
        return view('ehtg.edit', compact('ehtg'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ehtg = Ehtg::findOrFail($id);
  
        $ehtg->update($request->all());
  
        return redirect()->route('ehtg')->with('success', 'EHTG updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ehtg = Ehtg::findOrFail($id);
  
        $ehtg->delete();
  
        return redirect()->route('ehtg')->with('success', 'EHTG deleted successfully');
    }
}
