<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Transaksi;
use App\Models\Category;
use App\Models\Tc191; // Model untuk tabel tc191
use App\Models\Tc192F; // Model untuk tabel tc191

use PDF;

use Illuminate\Support\Facades\DB;

class ResultController extends Controller
{
    public function index()
    {

        $result = Result::orderBy('created_at', 'ASC')->get();
  
        return view('result.index', compact('result'));
    }

    public function create() 
    {
        // Mengambil semua kategori
        $category = Category::all(); 
        $transaksi = Transaksi::with('category')->get();
        $id = Transaksi::all(); // Ganti $tid_c192f dengan $id_tc192f
    
        $id_tc191 = Tc191::all(); // Ambil semua data dari tabel tc191
        $id_tc192f = Tc192F::all();
    
        return view('result.create', compact('id_tc191','id_tc192f', 'id', 'category'));
        
    }
  

public function store(Request $request)
{
    // Validasi input
    $validatedData = $request->validate([
        'id_category' => 'required|exists:category,id_category',
        'id_transaksi' => 'required|exists:transaksi,id',
        'results.*.result' => 'required|string',
    ]);

    // Menggabungkan hasil menjadi satu string
    $combinedResults = implode(', ', array_column($validatedData['results'], 'result'));

    // Menyimpan data transaksi untuk hasil gabungan
    $result = new Result([
        'id_category' => $validatedData['id_category'],
        'id_transaksi' => $validatedData['id_transaksi'],
        'result' => $combinedResults,
    ]);
    $result->save();

    // Redirect ke halaman print dengan ID transaksi yang baru saja disimpan
    return redirect()->route('result.print', $validatedData['id_transaksi'])
                     ->with('success', 'Data Pengajuan Sampel berhasil disimpan.');
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

    public function createResult(Request $request)
    {
        $transaksi = Transaksi::with('category')->get(); // Pastikan relasi sudah benar
        // Mengambil semua transaksi yang tersedia atau transaksi spesifik
        $transaksi = DB::table('transaksi')
                        ->get(); // Atau sesuaikan dengan kondisi (misal, where user_id, dll.)
    
        // Mengirim data transaksi ke view create result
        return view('result.create', compact('transaksi'));
    }



    public function print($id)
    {
        // Mengambil data transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);
        
        // Mengambil semua data hasil yang sesuai dengan ID transaksi
        $results = Result::where('id_transaksi', $id)->get();
        
        // Mengambil maksimal 30 parameter dari tc191
        $parameters = Tc191::take(30)->get(); // Mengambil 30 parameter
    
        // Load view dengan data transaksi, hasil, dan parameter
        $pdf = PDF::loadView('result.print', compact('transaksi', 'results', 'parameters'));
    
        // Generate dan download PDF
        return $pdf->stream('result-' . $transaksi->id . '.pdf');
    }
    

    public function tc192f($id)
    {
        // Mengambil data transaksi berdasarkan ID
        $transaksi = Transaksi::findOrFail($id);
        
        // Mengambil semua data hasil yang sesuai dengan ID transaksi
        $results = Result::where('id_transaksi', $id)->get();
        
        // Mengambil maksimal 30 parameter dari tc191
        $parameters = Tc192F::take(30)->get(); // Mengambil 30 parameter
    
        // Load view dengan data transaksi, hasil, dan parameter
        $pdf = PDF::loadView('result.tc192f', compact('transaksi', 'results', 'parameters'));
    
        // Generate dan download PDF
        return $pdf->stream('result-' . $transaksi->id . '.pdf');
    }
}
