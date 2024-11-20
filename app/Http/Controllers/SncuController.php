<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sncu;

class SncuController extends Controller
{

    public function index()
    {
        $sncu = Sncu::orderBy('created_at', 'ASC')->get();
  
        return view('sncu.index', compact('sncu'));
    }


    public function create()
    {
        return view('sncu.create');
    }


 
    public function store(Request $request)
    {
        Sncu::create($request->all());
        
        // Redirect dengan pesan sukses
        return redirect()->route('sncu.index')->with('success', 'Data Sn/Cu Series berhasil ditambahkan.');
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

    public function getSncuData($categoryId)
    {
        // Ambil data tipe_sampel berdasarkan id_category dari tabel sncu
        $tipeSolders = Sncu::where('id_category', $categoryId)->pluck('tipe_solder');
        return response()->json($tipeSolders);
    }

    
}
