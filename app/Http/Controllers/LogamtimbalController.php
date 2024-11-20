<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logamtimbal;

class LogamtimbalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logamtimbal = Logamtimbal::orderBy('created_at', 'DESC')->get();

        return view('logamtimbal.index', compact('logamtimbal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('logamtimbal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        logamtimbal::create($request->all());
 
        return redirect()->route('logamtimbal')->with('success', 'Logam Timbal added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $logamtimbal = Logamtimbal::findOrFail($id);
  
        return view('logamtimbal.show', compact('logamtimbal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $logamtimbal = Logamtimbal::findOrFail($id);
  
        return view('logamtimbal.edit', compact('logamtimbal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $logamtimbal = Logamtimbal::findOrFail($id);
  
        $logamtimbal->update($request->all());
  
        return redirect()->route('logamtimbal')->with('success', 'Logam Timbal updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $logamtimbal = Logamtimbal::findOrFail($id);
  
        $logamtimbal->delete();
  
        return redirect()->route('logamtimbal')->with('success', 'Logam Timbal deleted successfully');
    }
}