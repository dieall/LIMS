<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanRawmat;
use App\Models\DataRawmat;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;

class PengajuanRawmatController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter dan jumlah data per halaman
        $filter = $request->get('filter', 'all'); // Default filter adalah 'all'
        $pageSize = $request->get('page_size', 10); // Default jumlah data per halaman adalah 10
    
        // Query dasar
        $query = PengajuanRawmat::query();
    
        // Logika filter data
        if ($filter === 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter === 'this_month') {
            // Filter berdasarkan bulan dan tahun saat ini
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        }
    
        // Paginasi dengan jumlah data per halaman
        $pengajuanrawmat = $query->orderBy('created_at', 'ASC')->paginate($pageSize);
    
        // Kirim parameter tambahan ke view agar query string tetap dipertahankan
        $pengajuanrawmat->appends([
            'filter' => $filter,
            'page_size' => $pageSize,
        ]);
    
        return view('pengajuanrawmat.index', compact('pengajuanrawmat'));
    }

    public function create() 
    {
        // Mengambil semua kategori

        $datarawmat = DataRawmat::all(); 
        
        // Ambil semua data dari tabel tc191
    
        return view('pengajuanrawmat.create', compact( 'datarawmat'));
    }
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'tgl' => 'required|date',
            'supplier' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'spesifikasi' => 'required|array',  // Validasi array spesifikasi
            'satuan' => 'required|array',        // Validasi array satuan
            'coa' => 'required|array',           // Validasi array coa
            'result' => 'required|array',        // Validasi array result
        ]);
    
        // Membuat instance baru dari model PengajuanRawmat
        $data = new PengajuanRawmat();
    
        // Mengambil data inputan form
        $data->tgl = $request->input('tgl');
        $data->supplier = $request->input('supplier');
        $data->nama = $request->input('nama'); // Mengambil nama
    
        // Mengambil data spesifikasi, satuan, COA, result dan menyimpannya sebagai JSON
        $data->spesifikasi = json_encode($request->input('spesifikasi'));
        $data->satuan = json_encode($request->input('satuan'));
        $data->coa = json_encode($request->input('coa'));
        $data->result = json_encode($request->input('result'));
    
        // Menyimpan data ke database
        $data->save();
    
        // Redirect ke rute pengajuanrawmat setelah data disimpan
        return redirect()->route('pengajuanrawmat')->with('success', 'Data berhasil ditambahkan');
    }
    
    public function show(string $id)
    {
        $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
  
        return view('pengajuanrawmat.show', compact('pengajuanrawmat'));
    }

    public function edit(string $id)
    {
        $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
  
        return view('pengajuanrawmat.edit', compact('pengajuanrawmat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
  
        $pengajuanrawmat->update($request->all());
  
        return redirect()->route('pengajuanrawmat')->with('success', 'Pengajuan Rawmat updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cari data berdasarkan ID
        $pengajuanRawmat = PengajuanRawmat::findOrFail($id);
    
        try {
            // Hapus data
            $pengajuanRawmat->delete();
    
            // Redirect ke index dengan pesan sukses
            return redirect()->route('pengajuanrawmat.index')
                ->with('success', 'Data Pengajuan Raw Material berhasil dihapus.');
        } catch (\Exception $e) {
            // Redirect ke index dengan pesan error jika terjadi masalah
            return redirect()->route('pengajuanrawmat.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function details()
    {
        return $this->hasMany(RawmatDetail::class, 'pengajuan_rawmat_id'); // Ganti sesuai nama model dan foreign key Anda
    }

    public function print($id)
    {
        // Ambil data pengajuan solder berdasarkan ID
        $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
    
    
        return view('pengajuanrawmat.print', compact('pengajuanrawmat'));
    }

}
