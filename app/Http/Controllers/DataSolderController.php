<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSolder;

class DataSolderController extends Controller
{
 
    public function index(Request $request)
    {
        // Ambil filter dari permintaan (default 'all')
        $filter = $request->get('filter', 'all');
        $pageSize = $request->get('page_size', 50); // Default page size 10
    
        // Query dasar untuk DataSolder
        $query = DataSolder::query();
    
        // Terapkan filter jika ada
        if ($filter !== 'all') {
            $query->where('nama_kategori', $filter);
        }
    
        // Terapkan pagination
        $datasolder = $query->orderBy('created_at', 'ASC')->paginate($pageSize);
    
        // Kirim data ke Blade
        return view('datasolder.index', compact('datasolder'));
    }
    


    public function create()
    
    {
        return view('datasolder.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DataSolder::create($request->all());
 
        return redirect()->route('datasolder')->with('success', 'Data Solder added successfully');
    }


    public function show($id)
    {
        $solder = DataSolder::findOrFail($id);
        return view('datasolder.show', compact('solder'));
    }
    

    public function edit(string $id)
    {
        $datasolder = DataSolder::findOrFail($id);
  
        return view('datasolder.edit', compact('datasolder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $datasolder = DataSolder::findOrFail($id);
  
        $datasolder->update($request->all());
  
        return redirect()->route('datasolder')->with('success', 'datasolder updated successfully');
    }

    public function destroy(string $id)
    {
        // Cari data solder berdasarkan ID
        $datasolder = DataSolder::find($id);
    
        // Pastikan data ditemukan
        if (!$datasolder) {
            // Jika tidak ditemukan, kembalikan response error atau redirect ke halaman sebelumnya
            return redirect()->route('datasolder')->with('error', 'Data tidak ditemukan!');
        }
    
        // Hapus data solder
        $datasolder->delete();
    
        // Redirect ke halaman daftar solder dengan pesan sukses
        return redirect()->route('datasolder')->with('success', 'Data solder berhasil dihapus!');
    }
}
