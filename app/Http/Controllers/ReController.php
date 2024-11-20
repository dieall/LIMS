<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Re;

class ReController extends Controller
{
    public function index()
    {
        $re = Re::orderBy('created_at', 'DESC')->get();
  
        return view('re.index', compact('re'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('re.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Re::create($request->all());
 
        return redirect()->route('re')->with('success', 'R3 added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $re = Re::findOrFail($id);
  
        return view('re.show', compact('re'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $re = Re::findOrFail($id);
  
        return view('re.edit', compact('re'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $re = Re::findOrFail($id);
  
        $re->update($request->all());
  
        return redirect()->route('re')->with('success', 'R3 updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $re = Re::findOrFail($id);
  
        $re->delete();
  
        return redirect()->route('re')->with('success', 'RI deleted successfully');
    }
}
