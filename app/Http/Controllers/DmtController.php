<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dmt;
use App\Models\Transaksi; // Jangan lupa untuk memanggil model Transaksi
use App\Models\Category;

use Carbon\Carbon;


use DB;


class DmtController extends Controller
{
    public function index()
    {
        // Get all DMT data
        $dmt = Dmt::orderBy('created_at', 'ASC')->get();
    
        // Prepare data for the chart (example: counting the number of entries for each ID)
        $chartData = Dmt::selectRaw('id, COUNT(*) as total')
                        ->groupBy('id')
                        ->pluck('total', 'id');
    
        // Pass both data sets to the view
        return view('dmt.index', compact('dmt', 'chartData'));
    }
    
    

    public function create()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('dmt.create', compact('transaksi', 'category'));
    }

    public function create1()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('dmt.create1', compact('transaksi', 'category'));
    }

    public function create2()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('dmt.create2', compact('transaksi', 'category'));
    }
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'id' => 'required|string',
            'id_category' => 'required|exists:category,id_category',
            'id_transaksi' => 'required|exists:transaksi,id',
            'tgl' => 'nullable|string',
            'ape' => 'nullable|string',
            'solid' => 'nullable|string',
            'tinc' => 'nullable|string',
            'monomet' => 'nullable|string',
            'trime' => 'nullable|string',
            'cloride' => 'nullable|string',
            'spec' => 'nullable|string',
            'dimet' => 'nullable|string',
            'moisture' => 'nullable|string',
            'status' => 'nullable|string',


        ]);
    
        // Insert data ke tabel tb_tinstab
        $dmt = new Dmt([
            'id' => $validatedData['id'],
            'id_category' => $validatedData['id_category'],
            'id_transaksi' => $validatedData['id_transaksi'],
            'tgl' => $validatedData['tgl'],
            'ape' => $validatedData['ape'],
            'solid' => $validatedData['solid'],
            'tinc' => $validatedData['tinc'],
            'monomet' => $validatedData['monomet'],
            'trime' => $validatedData['trime'],
            'cloride' => $validatedData['cloride'],
            'spec' => $validatedData['spec'],
            'dimet' => $validatedData['dimet'],
            'moisture' => $validatedData['moisture'],
            'status' => $validatedData['status'],

        ]);
    
        $dmt->save(); // Menyimpan data ke dalam tabel
            
        // Redirect ke halaman tinstab dengan pesan sukses
        return redirect()->route('dmt')->with('success', 'DMT added successfully');
    }

    public function show(string $id)
    {
        $dmt = Dmt::findOrFail($id);
  
        return view('dmt.show', compact('dmt'));
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
