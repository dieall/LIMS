<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tinstab;
use App\Models\Transaksi; // Jangan lupa untuk memanggil model Transaksi
use App\Models\Category;

use Carbon\Carbon;


use DB;

class TinstabController extends Controller
{

    public function index(Request $request)
    {
        // Get the selected table type from the request
        $selectedTable = $request->input('table', 'all');
    
        // Query data based on the selected table type
        if ($selectedTable === 'all') {
            $tinstab = Tinstab::with(['category', 'transaksi'])->get(); // Mengambil semua data dengan relasi
        } else {
            $tinstab = Tinstab::with(['category', 'transaksi'])
                            ->where('id', $selectedTable)
                            ->get();
        }
    
        // Count data for the pie chart
        $totalData = Tinstab::select('id', DB::raw('count(*) as total'))
                            ->groupBy('id')
                            ->pluck('total', 'id');
    
        // Prepare dataCounts based on the totalData
        $dataCounts = [
            'MT-620' => ['total' => $totalData->get('MT-620', 0)], // Default to 0 if not found
            'MT-630' => ['total' => $totalData->get('MT-630', 0)], // Default to 0 if not found
        ];
    
        return view('tinstab.index', compact('tinstab', 'dataCounts', 'selectedTable'));
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
    
        return view('tinstab.create', compact('transaksi', 'category'));
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
    
        return view('tinstab.create1', compact('transaksi', 'category'));
    }
    

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'id' => 'required|string',
            'clarity' => 'required|string',
            'transmission' => 'required|string',
            'tin' => 'required|string',
            'ri' => 'required|string',
            'sg' => 'required|string',
            'acid' => 'required|string',
            'sulfur' => 'required|string',
            'water' => 'required|string',
            'yellow' => 'required|string',
            'eh' => 'required|string', // Update field name
            'visco' => 'required|string',
            'pt' => 'required|string',
            'mono' => 'required|string',
            'id_category' => 'required|exists:category,id_category',
            'id_transaksi' => 'required|exists:transaksi,id',
            'tgl'=> 'required|string',
        ]);
    
        // Insert data ke tabel tb_tinstab
        $tinstab = new Tinstab([
            'id' => $validatedData['id'],
            'id_category' => $validatedData['id_category'],
            'id_transaksi' => $validatedData['id_transaksi'],
            'clarity' => $validatedData['clarity'],
            'transmission' => $validatedData['transmission'],
            'tin' => $validatedData['tin'],
            'ri' => $validatedData['ri'],
            'sg' => $validatedData['sg'],
            'acid' => $validatedData['acid'],
            'sulfur' => $validatedData['sulfur'],
            'water' => $validatedData['water'],
            'yellow' => $validatedData['yellow'],
            'eh' => $validatedData['eh'], // Updated field
            'visco' => $validatedData['visco'],
            'pt' => $validatedData['pt'],
            'mono' => $validatedData['mono'],
            'tgl' => $validatedData['tgl'],
        ]);
    
        $tinstab->save(); // Menyimpan data ke dalam tabel
            
        // Redirect ke halaman tinstab dengan pesan sukses
        return redirect()->route('tinstab')->with('success', 'Tinstab added successfully');
    }
    

    public function show(string $idx)
    {
        $tinstab = Tinstab::findOrFail($idx);
  
        return view('tinstab.show', compact('tinstab'));
    }


    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
