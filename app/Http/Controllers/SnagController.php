<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Snag;

class SnagController extends Controller
{
    public function index()
    {
        $snag = Snag::orderBy('created_at', 'ASC')->get();

        return view('snag.index', compact('snag'));
    }


    public function create()
    {
        return view('snag.create');
    }



    public function store(Request $request)
    {
        Snag::create($request->all());
        
        // Redirect dengan pesan sukses
        return redirect()->route('snag.index')->with('success', 'Data Sn/Ag Series berhasil ditambahkan.');
    }
    public function show(string $id)
    {
        //
    }

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
