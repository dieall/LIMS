<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logamtimah;

class LogamtimahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $logamtimah = Logamtimah::orderBy('created_at', 'DESC')->get();
  
        return view('logamtimah.index', compact('logamtimah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('logamtimah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Logamtimah::create($request->all());
 
        return redirect()->route('logamtimah')->with('success', 'Logam Timah added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $logamtimah = Logamtimah::findOrFail($id);
  
        return view('logamtimah.show', compact('logamtimah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $logamtimah = LogamTimah::findOrFail($id);
        return view('logamtimah.edit', compact('logamtimah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_logamtimah' => 'required|string|max:255', // Validasi
        ]);

        $logamtimah = LogamTimah::findOrFail($id);
        $logamtimah->update($request->all());

        return redirect()->route('logamtimah')->with('success', 'Logam Timah updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $logamtimah = Logamtimah::findOrFail($id);
  
        $logamtimah->delete();
  
        return redirect()->route('logamtimah')->with('success', 'Logam Timah deleted successfully');
    }
}
