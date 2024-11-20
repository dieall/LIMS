<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mecl;

class MeclController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan pilihan jumlah item per halaman dari request, default ke 10
        $perPage = $request->input('per_page', 10);
        
        // Query dengan pagination
        $mecl = Mecl::paginate($perPage);
    
        return view('mecl.index', compact('mecl'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mecl.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Mecl::create($request->all());
 
        return redirect()->route('mecl')->with('success', 'Mecl added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mecl = Mecl::findOrFail($id);
  
        return view('mecl.show', compact('mecl'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $mecl = Mecl::findOrFail($id);
        return view('mecl.edit', compact('mecl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mecl' => 'required|string|max:255', // Validasi
        ]);

        $mecl = Mecl::findOrFail($id);
        $mecl->update($request->all());

        return redirect()->route('mecl')->with('success', 'Logam Timah updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mecl = Mecl::findOrFail($id);
  
        $mecl->delete();
  
        return redirect()->route('mecl')->with('success', 'Logam Timah deleted successfully');
    }
}
