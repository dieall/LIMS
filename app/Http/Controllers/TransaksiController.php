<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Category;




use PDF;
use DB;


class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->input('perPage', 10);
    
        // Ambil data transaksi dengan pagination sesuai jumlah 'perPage'
        $transaksi = Transaksi::with('category')->orderBy('created_at', 'ASC')->paginate($perPage);
    
        return view('transaksi.index', compact('transaksi'));
    }

    public function create() 
    {
        // Mengambil semua kategori

        $category = Category::all(); 
        
        // Ambil semua data dari tabel tc191
    
        return view('transaksi.create', compact( 'category'));
    }
  
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'tgl' => 'required|date',
            'id_category' => 'required|exists:category,id_category',
            'tipe_sampel' => 'required|string',
            'batch' => 'required|string',
            'deskripsi' => 'required|string',
            'nama' => 'required|string',
            'audit_trail' => 'required|string',
            'jam_masuk' => 'required|string',
  
             // Periksa nama kolom
        ]);
    
        // Membuat instansi baru Transaksi
        $transaksi = new Transaksi([
            'tgl' => $validatedData['tgl'],
            'id_category' => $validatedData['id_category'],
            'tipe_sampel' => $validatedData['tipe_sampel'],
            'batch' => $validatedData['batch'],
            'deskripsi' => $validatedData['deskripsi'],
            'nama' => $validatedData['nama'],
            'audit_trail' => $validatedData['audit_trail'],
            'jam_masuk' => $validatedData['jam_masuk'],
           
             // Pastikan ini terisi
        ]);
    
        // Menyimpan data transaksi
        $transaksi->save();
    
        // Redirect setelah berhasil menyimpan
        return redirect()->route('transaksi')->with('success', 'Data Pengajuan Sampel berhasil disimpan.');
    }


    public function show(string $id)
    {
        // Belum diimplementasikan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Belum diimplementasikan
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaksi = Transaksi::findOrFail($id);
  
        $transaksi->update($request->all());
  
        return redirect()->route('transaksi')->with('success', 'Data Pengajuan Sampel updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)

    {
        $transaksi = Transaksi::findOrFail($id);
  
        $transaksi->delete();
  
        return redirect()->route('transaksi')->with('success', 'Data Pengajuan Sampel deleted successfully');
    }

    public function printPDF($id)
    {
        $transaksi = Transaksi::findOrFail($id); // Ambil data transaksi berdasarkan ID
        $pdf = PDF::loadView('transaksi.pdf', compact('transaksi')); // Load view dengan data

        return $pdf->stream('transaksi-' . $transaksi->id . '.pdf'); // Generate dan download PDF
    }

    public function print2($id)
    {
        $transaksi = Transaksi::findOrFail($id); // Ambil data transaksi berdasarkan ID
        
        // Load view dengan data transaksi untuk dicetak menjadi PDF
        $pdf = PDF::loadView('transaksi.print2', compact('transaksi'));
    
        // Stream PDF ke browser dengan nama file yang benar (gunakan ekstensi .pdf)
        return $pdf->stream('transaksi-' . $transaksi->id . '.pdf');
    }
    
    
    
    public function cetak()
    {
        $transaksis = Transaksi::all(); // Ambil semua data dari tabel transaksi
        return view('transaksi.cetak', compact('transaksis'));
    }
    public function getDataByTable($table)
    {
        // Pastikan nama tabel valid, lakukan pengecekan di sini
        if ($table === 'tc191') {
            $data = Tc191::all(); // Model Tc191
        } elseif ($table === 'tc192f') {
            $data = Tc192F::all(); // Model Tc192F
        } else {
            return response()->json(['error' => 'Invalid table'], 400);
        }
    
        return response()->json($data);
    }


}
