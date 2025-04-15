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
        $filter = $request->get('filter', 'all');
        $pageSize = $request->get('page_size', 10);
    
        // Query dasar
        $query = PengajuanRawmat::query();
    
        // Logika filter data
        if ($filter === 'today') {
            $query->whereDate('tgl', Carbon::today());
        } elseif ($filter === 'this_month') {
            // Filter berdasarkan bulan dan tahun saat ini
            $query->whereMonth('tgl', Carbon::now()->month)
                  ->whereYear('tgl', Carbon::now()->year);
        }
    
        // Paginasi dengan jumlah data per halaman
        $pengajuanrawmat = $query->orderBy('created_at', 'DESC')->paginate($pageSize);
    
        // Kirim parameter tambahan ke view agar query string tetap dipertahankan
        $pengajuanrawmat->appends(request()->all());
    
        return view('pengajuanrawmat.index', compact('pengajuanrawmat', 'filter', 'pageSize'));
    }

    public function create() 
    {
        // Mengambil semua kategori
        $datarawmat = DataRawmat::orderBy('nama')->get(); 
        
        return view('pengajuanrawmat.create', compact('datarawmat'));
    }
    
    public function store(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'tgl' => 'required|date',
            'supplier' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'spesifikasi' => 'required|array',
            'satuan' => 'required|array',
            'coa' => 'required|array',
            'result' => 'required|array',
        ]);
    
        try {
            // Membuat instance baru dari model PengajuanRawmat
            $data = new PengajuanRawmat();
        
            // Mengambil data inputan form
            $data->tgl = $validated['tgl'];
            $data->supplier = $validated['supplier'];
            $data->nama = $validated['nama'];
        
            // Mengambil data spesifikasi, satuan, COA, result dan menyimpannya sebagai JSON
            $data->spesifikasi = json_encode($validated['spesifikasi']);
            $data->satuan = json_encode($validated['satuan']);
            $data->coa = json_encode($validated['coa']);
            $data->result = json_encode($validated['result']);
        
            // Menyimpan data ke database
            $data->save();
        
            // Redirect ke rute pengajuanrawmat setelah data disimpan
            return redirect()->route('pengajuanrawmat.index')
                ->with('success', 'Data pengajuan raw material berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
    
    public function show(string $id)
    {
        try {
            $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
            return view('pengajuanrawmat.show', compact('pengajuanrawmat'));
        } catch (\Exception $e) {
            return redirect()->route('pengajuanrawmat.index')
                ->with('error', 'Data tidak ditemukan');
        }
    }

    public function edit(string $id)
    {
        try {
            $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
            $datarawmat = DataRawmat::orderBy('nama')->get();
            return view('pengajuanrawmat.edit', compact('pengajuanrawmat', 'datarawmat'));
        } catch (\Exception $e) {
            return redirect()->route('pengajuanrawmat.index')
                ->with('error', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, string $id)
    {
        // Validasi data input (sama seperti store)
        $validated = $request->validate([
            'tgl' => 'required|date',
            'supplier' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'spesifikasi' => 'required|array',
            'satuan' => 'required|array',
            'coa' => 'required|array',
            'result' => 'required|array',
        ]);
    
        try {
            $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
            
            // Update data
            $pengajuanrawmat->tgl = $validated['tgl'];
            $pengajuanrawmat->supplier = $validated['supplier'];
            $pengajuanrawmat->nama = $validated['nama'];
            $pengajuanrawmat->spesifikasi = json_encode($validated['spesifikasi']);
            $pengajuanrawmat->satuan = json_encode($validated['satuan']);
            $pengajuanrawmat->coa = json_encode($validated['coa']);
            $pengajuanrawmat->result = json_encode($validated['result']);
            
            $pengajuanrawmat->save();
      
            return redirect()->route('pengajuanrawmat.index')
                ->with('success', 'Data pengajuan raw material berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $pengajuanRawmat = PengajuanRawmat::findOrFail($id);
            $pengajuanRawmat->delete();
    
            return redirect()->route('pengajuanrawmat.index')
                ->with('success', 'Data pengajuan raw material berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->route('pengajuanrawmat.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage());
        }
    }

    public function print($id)
    {
        try {
            $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
            return view('pengajuanrawmat.print', compact('pengajuanrawmat'));
        } catch (\Exception $e) {
            return redirect()->route('pengajuanrawmat.index')
                ->with('error', 'Data tidak ditemukan untuk dicetak');
        }
    }
}
