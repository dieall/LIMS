<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Snagcu;

class SnagcuController extends Controller
{
    public function index()
    {
        $snagcu = Snagcu::orderBy('created_at', 'ASC')->get();
  
        return view('snagcu.index', compact('snagcu'));
    }


    public function create()
    {
        return view('snagcu.create');
    }


 
    public function store(Request $request)
    {
        Snagcu::create($request->all());
        
        // Redirect dengan pesan sukses
        return redirect()->route('snagcu.index')->with('success', 'Data Sn/Cu Series berhasil ditambahkan.');
    }
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
