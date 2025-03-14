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
        $filter = $request->get('filter', 'today'); // Default filter diubah menjadi 'today'
        $pageSize = $request->get('page_size', 10); // Default page size is 10
    
        $query = DataChemical::query();
    
        // Filter berdasarkan parameter
        if ($filter == 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter == 'limit14') {
            $query->whereBetween('id', [1, 14]); // Filter untuk ID 1 sampai 14
        }
    
        // Apply pagination
        $datachemical = $query->paginate($pageSize);
    
        return view('datachemical.index', compact('datachemical'));
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
        $dataChemical = DataChemical::findOrFail($id);
        
        // Menentukan kolom-kolom yang harus ditampilkan berdasarkan nilai yang ada
        $fields = [
            'nama', 'kategori', 'tgl', 'batch', 'desc', 'orang', 'status',
            'clarity', 'transmission', 'ape', 'dimet', 'trime', 'tin', 'solid',
            'ri', 'sg', 'acid', 'sulfur', 'water', 'mono', 'yellow', 'eh', 
            'visco', 'pt', 'moisture', 'cloride', 'spec', 'cla', 'densi'
        ];

        // Filter kolom yang ada datanya saja
        $fieldsWithData = array_filter($fields, function($field) use ($dataChemical) {
            return !is_null($dataChemical->{$field});
        });

        return view('datachemical.edit', compact('dataChemical', 'fieldsWithData'));
    }

    // Proses untuk update data
    public function update(Request $request, $id)
    {
        $dataChemical = DataChemical::findOrFail($id);

        // Validasi hanya kolom yang terisi
        $validatedData = $request->validate([
            'nama' => 'nullable|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'tgl' => 'nullable|date',
            'batch' => 'required|string|max:50',
            'desc' => 'required|string|max:50',
            'orang' => 'required|string|max:50',
            'status' => 'required|string|max:25',
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
            'densi' => 'nullable|string|max:50',
        ]);

        // Update data dengan nilai yang baru
        $dataChemical->update($validatedData);

        return redirect()->route('datachemical')->with('success', 'Data updated successfully!');
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

