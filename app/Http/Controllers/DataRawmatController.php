<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataRawmat;

class DataRawmatController extends Controller
{

    public function index(Request $request)
    {
        // Ambil parameter filter dan page size
        $filter = $request->get('filter', 'all');
        $pageSize = $request->get('page_size', 10); // Default page size 10
    
        // Query dasar
        $query = DataRawmat::query();
    
        // Terapkan filter jika ada
        if ($filter !== 'all') {
            $query->where('supplier', $filter);
        }
    
        // Pagination dengan page size
        $datarawmat = $query->orderBy('created_at', 'ASC')->paginate($pageSize);
    
        // Kirim data ke view
        return view('datarawmat.index', compact('datarawmat'));
    }
    
    

    public function create()
    {
        // Ambil semua data kategori dari database menggunakan Eloquent
        $datarawmat = DataRawmat::all();
        
        // Kirim data datarawmat ke view
        return view('datarawmat.create', compact('datarawmat'));
    }

    public function store(Request $request)
    {
        DataRawmat::create($request->all());
 
        return redirect()->route('datarawmat')->with('success', 'Data Rawmat added successfully');
    }

    public function show($id)
    {
        $dataRawmat = DataRawmat::findOrFail($id);
        return view('datarawmat.show', compact('dataRawmat'));
    }
    
    public function edit($id)
    {
        $dataRawmat = DataRawmat::findOrFail($id);
        
        // Kolom yang harus ditampilkan berdasarkan nilai yang ada
        $fields = [
            'nama', 'supplier'
        ];

        return view('datarawmat.edit', compact('dataRawmat', 'fields'));
    }

    // Proses untuk update data
    public function update(Request $request, $id)
    {
        $dataRawmat = DataRawmat::findOrFail($id);

        // Validasi data yang terisi
        $validatedData = $request->validate([
            'nama' => 'required|string|max:100',
            'supplier' => 'required|string|max:100',
        ]);

        // Update data dengan nilai yang baru
        $dataRawmat->update($validatedData);

        return redirect()->route('datarawmat')->with('success', 'Data updated successfully!');
    }

    public function destroy($id)
    {
        $dataRawmat = DataRawmat::findOrFail($id);

        // Hapus data
        $dataRawmat->delete();

        return redirect()->route('datarawmat')->with('success', 'Data deleted successfully!');
    }
}
