<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tin;

class TinController extends Controller
{
    public function index()
    {
        $tin = Tin::orderBy('created_at', 'ASC')->get();

        return view('tin.index', compact('tin'));
    }


    public function create()
    {
        return view('tin.create');
    }



    public function store(Request $request)
    {
        Tin::create($request->all());
        
        // Redirect dengan pesan sukses
        return redirect()->route('tin.index')->with('success', 'Data Tin Lead Series berhasil ditambahkan.');
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
