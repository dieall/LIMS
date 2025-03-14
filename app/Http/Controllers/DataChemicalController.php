<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataChemical;
use Carbon\Carbon;
class DataChemicalController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->get('page_size', 10); // Default page size is 10
        $filter = $request->get('filter', 'today'); // Default filter 'today' agar data hari ini ditampilkan secara default
        
        $query = DataChemical::query();
        $today = Carbon::today(); // Mendefinisikan variabel $today sebelum filter
        
        // Menambahkan filter untuk data hari ini
        if ($filter == 'today') {
            $query->whereDate('created_at', $today); // Filter berdasarkan tanggal hari ini
        }
        
        // Apply pagination
        $datachemical = $query->paginate($pageSize);
    
        return view('datachemical.index', compact('datachemical', 'today', 'filter'));
    }
    
    
    
    
    
    
    
     public function create()
    
     {
         return view('datachemical.create');
     }

    public function store(Request $request)
    {
        DataChemical::create($request->all());
 
        return redirect()->route('datachemical')->with('success', 'Data Chemical added successfully');
    }

    public function show(string $id)
    {
        $datachemical = DataChemical::findOrFail($id);
  
        return view('datachemical.show', compact('datachemical'));
    }
    public function edit($id)
    {
        // Menampilkan data berdasarkan ID
        $dataChemical = DataChemical::findOrFail($id);

        // Mengirim data ke view
        return view('datachemical.edit', compact('dataChemical'));
    }

    // Method untuk update data
    public function update(Request $request, $id)
    {
        // Validasi input yang diberikan
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'tgl' => 'nullable|date',
            'batch' => 'nullable|string|max:50',
            'desc' => 'nullable|string|max:50',
            'orang' => 'nullable|string|max:50',
            'clarity' => 'nullable|string|max:50',
            'transmission' => 'nullable|string|max:50',
            'ape' => 'nullable|string|max:50',
            'dimet' => 'nullable|string|max:50',
            'trime' => 'nullable|string|max:50',
            'tin' => 'nullable|string|max:50',
            'solid' => 'nullable|string|max:50',
            'ri' => 'nullable|string|max:50',
            'sg' => 'nullable|string|max:50',
            'acid' => 'nullable|string|max:50',
            'sulfur' => 'nullable|string|max:50',
            'water' => 'nullable|string|max:50',
            'mono' => 'nullable|string|max:50',
            'yellow' => 'nullable|string|max:50',
            'eh' => 'nullable|string|max:50',
            'visco' => 'nullable|string|max:50',
            'pt' => 'nullable|string|max:50',
            'moisture' => 'nullable|string|max:50',
            'cloride' => 'nullable|string|max:50',
            'spec' => 'nullable|string|max:50',
            'cla' => 'nullable|string|max:50',
            // Jangan lupa menambahkan kolom lainnya sesuai kebutuhan
        ]);

        // Temukan data yang akan diupdate berdasarkan ID
        $dataChemical = DataChemical::findOrFail($id);

        // Update data dengan nilai yang telah divalidasi
        $dataChemical->update($validated);

        // Redirect kembali ke index atau halaman lain setelah berhasil
        return redirect()->route('datachemical.index')->with('success', 'Data chemical berhasil diperbarui.');
    }
    
    public function destroy(string $id)
    {
        // Cari data solder berdasarkan ID
        $datachemical = DataChemical::find($id);
    
        // Pastikan data ditemukan
        if (!$datachemical) {
            // Jika tidak ditemukan, kembalikan response error atau redirect ke halaman sebelumnya
            return redirect()->route('datachemical')->with('error', 'Data tidak ditemukan!');
        }
    
        // Hapus data solder
        $datachemical->delete();
    
        // Redirect ke halaman daftar solder dengan pesan sukses
        return redirect()->route('datachemical')->with('success', 'Data Chemical berhasil dihapus!');
    }
}

