<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanRawmat;
use App\Models\DataRawmat;
use App\Models\StatusHistory;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;
use Illuminate\Support\Facades\DB;

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
    
    public function createe($id = null)
{
    $pengajuanrawmat = null;

    if ($id) {
        $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
    }

    // Get distinct raw material categories
    $datarawmat_categories = PengajuanRawmat::select('nama_rawmat')
        ->distinct()
        ->whereNotNull('nama_rawmat')
        ->get();

    $today = Carbon::today(); // Get today's date

    // Get today's raw material transactions
    $transaksi = PengajuanRawmat::select(
            'id', 'nama', 'nama_rawmat', 'created_at', 'batch', 
            'supplier', 'no_mobil', 'desc', 'user_id'
        )
        ->whereDate('created_at', $today)
        ->where('status', 'Proses Analisa') // Only show items in analysis process
        ->orderBy('created_at', 'DESC')
        ->get();

    // Get raw materials by category for dropdown population
    $rawmat_tin_chemical = PengajuanRawmat::where('nama_rawmat', 'Raw Mat Tin Chemical')->get();
    $rawmat_tin_chemical_varian = PengajuanRawmat::where('nama_rawmat', 'Raw Mat Tin Chemical Varian')->get();
    $rawmat_tin_solder = PengajuanRawmat::where('nama_rawmat', 'Raw Mat Tin Solder')->get();
    $bahan_bakar = PengajuanRawmat::where('nama_rawmat', 'Bahan Bakar')->get();

    // Get all raw material specifications from the database
    $all_rawmat_specs = DB::table('tbr_rawmat')->get();

    return view('pengajuanrawmat.createe', compact(
        'pengajuanrawmat',
        'datarawmat_categories', 
        'rawmat_tin_chemical', 
        'rawmat_tin_chemical_varian', 
        'rawmat_tin_solder', 
        'bahan_bakar', 
        'transaksi', 
        'all_rawmat_specs'
    ));
}

/**
 * Get raw material names by category
 */
public function getNamesByCategory($kategori)
{
    // Get raw material names based on category
    $names = DB::table('tbr_rawmat')
        ->where('nama_rawmat', $kategori)
        ->select('nama')
        ->get();

    return response()->json($names);
}



    public function store(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'tgl' => 'required|date',
            'supplier' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'nama_rawmat' => 'required|string|max:255',
            'batch' => 'nullable|string',
            'no_mobil' => 'nullable|string',
            'desc' => 'nullable|string',
            'coa' => 'nullable|string',
            'jam_masuk' => 'required|string',
            // Chemical and physical properties
            'sn' => 'nullable|string',
            'purity' => 'nullable|string',
            'purity_tmac' => 'nullable|string',
            'appreance' => 'nullable|string',
            'sg' => 'nullable|string',
            'fe_amo' => 'nullable|string',
            'si_amo' => 'nullable|string',
            'sh' => 'nullable|string',
            'acid' => 'nullable|string',
            'ri' => 'nullable|string',
            'free' => 'nullable|string',
            'ph' => 'nullable|string',
            'fe' => 'nullable|string',
            'si' => 'nullable|string',
            'sulfur' => 'nullable|string',
            'visual' => 'nullable|string',
            'water' => 'nullable|string',
            'color' => 'nullable|string',
            'acidity' => 'nullable|string',
            'lodine' => 'nullable|string',
            'ag' => 'nullable|string',
            'cu' => 'nullable|string',
            'pb' => 'nullable|string',
            'sb' => 'nullable|string',
            'zn' => 'nullable|string',
            'as' => 'nullable|string',
            'ni' => 'nullable|string',
            'bi' => 'nullable|string',
            'cd' => 'nullable|string',
            'ai' => 'nullable|string',
            'pe' => 'nullable|string',
            'ga' => 'nullable|string',
            'densi' => 'nullable|string',
            'clarity' => 'nullable|string',
            'apha' => 'nullable|string',
            // Status fields
            'status' => 'nullable|string',
            'sn_status' => 'nullable|string',
            'purity_status' => 'nullable|string',
            'purity_tmac_status' => 'nullable|string',
            'appreance_status' => 'nullable|string',
            'sg_status' => 'nullable|string',
            'fe_amo_status' => 'nullable|string',
            'si_amo_status' => 'nullable|string',
            'sh_status' => 'nullable|string',
            'acid_status' => 'nullable|string',
            'ri_status' => 'nullable|string',
            'free_status' => 'nullable|string',
            'ph_status' => 'nullable|string',
            'fe_status' => 'nullable|string',
            'si_status' => 'nullable|string',
            'sulfur_status' => 'nullable|string',
            'visual_status' => 'nullable|string',
            'water_status' => 'nullable|string',
            'color_status' => 'nullable|string',
            'acidity_status' => 'nullable|string',
            'lodine_status' => 'nullable|string',
            'ag_status' => 'nullable|string',
            'cu_status' => 'nullable|string',
            'pb_status' => 'nullable|string',
            'sb_status' => 'nullable|string',
            'zn_status' => 'nullable|string',
            'as_status' => 'nullable|string',
            'ni_status' => 'nullable|string',
            'bi_status' => 'nullable|string',
            'cd_status' => 'nullable|string',
            'ai_status' => 'nullable|string',
            'pe_status' => 'nullable|string',
            'ga_status' => 'nullable|string',
            'densi_status' => 'nullable|string',
            'clarity_status' => 'nullable|string',
            'apha_status' => 'nullable|string',
            'user_id' => 'required|string',
        ]);
    
        try {
            // Set default status if not provided
            $validated['status'] = $validated['status'] ?? 'Pengajuan';
            
            // Create new record with validated data
            $data = PengajuanRawmat::create($validated);
            
            // Simpan status "Pengajuan" ke StatusHistory
            StatusHistory::create([
                'pengajuan_rawmat_id' => $data->id, // Use the correct primary key column
                'status' => 'Pengajuan',
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'interval' => '-',
            ]);
        
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
        // Validasi data input
        $validated = $request->validate([
            'tgl' => 'required|date',
            'supplier' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            // Tambahkan validasi lainnya sesuai kebutuhan
        ]);
    
        try {
            $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
            
            // Update field-field utama
            $pengajuanrawmat->tgl = $validated['tgl'];
            $pengajuanrawmat->supplier = $validated['supplier'];
            $pengajuanrawmat->nama = $validated['nama'];
            $pengajuanrawmat->batch = $request->batch ?? $pengajuanrawmat->batch;
            $pengajuanrawmat->no_mobil = $request->no_mobil ?? $pengajuanrawmat->no_mobil;
            $pengajuanrawmat->desc = $request->desc ?? $pengajuanrawmat->desc;
            $pengajuanrawmat->coa = $request->coa ?? $pengajuanrawmat->coa;
            
            // Update field-field chemical dan status
            $chemicalFields = [
                'sn', 'purity', 'purity_tmac', 'appreance', 'sg', 'fe_amo', 'si_amo', 'sh', 
                'acid', 'ri', 'free', 'ph', 'fe', 'si', 'sulfur', 'visual', 'water', 'color',
                'acidity', 'lodine', 'ag', 'cu', 'pb', 'sb', 'zn', 'as', 'ni', 'bi', 'cd',
                'ai', 'pe', 'ga', 'densi', 'clarity', 'apha'
            ];
            
            foreach ($chemicalFields as $field) {
                if ($request->has($field)) {
                    $pengajuanrawmat->$field = $request->$field;
                }
                
                // Update corresponding status field if it exists
                $statusField = $field . '_status';
                if ($request->has($statusField)) {
                    $pengajuanrawmat->$statusField = $request->$statusField;
                }
            }
            
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
    
    /**
     * Change status to "Pengajuan"
     */
    public function pengajuan($id)
    {
        $data = PengajuanRawmat::findOrFail($id);
    
        // Cek apakah status Pengajuan sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_rawmat_id', $data->id)
            ->where('status', 'Pengajuan')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Pengajuan ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_rawmat_id', $data->id)
                ->orderBy('changed_at', 'desc')
                ->first();
    
            // Hitung interval waktu jika ada history sebelumnya
            $interval = '-';
            if ($previousHistory) {
                $previousChangedAt = Carbon::parse($previousHistory->changed_at);
                $currentChangedAt = Carbon::now();
                $interval = $previousChangedAt->diffInMinutes($currentChangedAt) . ' menit';
            }
    
            StatusHistory::create([
                'pengajuan_rawmat_id' => $data->id,
                'status' => 'Pengajuan',
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'interval' => $interval,
            ]);
        }
    
        // Ubah status menjadi "Pengajuan"
        $data->status = 'Pengajuan';
        $data->jam_masuk = Carbon::now();
        $data->save();
    
        return redirect()->route('pengajuanrawmat.show', $data->id)
            ->with('success', 'Status berhasil diubah menjadi Pengajuan');
    }
    
    /**
     * Change status to "Proses Analisa"
     */
    public function prosesAnalisa($id)
    {
        $data = PengajuanRawmat::findOrFail($id);
        
        // Check if we already have a "Proses Analisa" status record
        $existingHistory = StatusHistory::where('pengajuan_rawmat_id', $data->id)
            ->where('status', 'Proses Analisa')
            ->first();
    
        // If this is the second or later attempt to process analysis
        if ($existingHistory) {
            // Redirect to the edit route for continued analysis
            return redirect()->route('pengajuanrawmat.edit', $data->id);
        }
        
        // First time processing - create history record
        $previousHistory = StatusHistory::where('pengajuan_rawmat_id', $data->id)
            ->orderBy('changed_at', 'desc')
            ->first();
    
        // Calculate time interval if there's previous history
        $interval = '-';
        if ($previousHistory) {
            $previousChangedAt = Carbon::parse($previousHistory->changed_at);
            $currentChangedAt = Carbon::now();
            $interval = $previousChangedAt->diffInMinutes($currentChangedAt) . ' menit';
        }
    
        StatusHistory::create([
            'pengajuan_rawmat_id' => $data->id,
            'status' => 'Proses Analisa',
            'changed_at' => Carbon::now(),
            'user_id' => auth()->user()->id,
            'user_name' => ucwords(auth()->user()->name),
            'interval' => $interval,
        ]);
    
        // Update the record status
        $data->status = 'Proses Analisa';
        $data->jam_masuk = Carbon::now();
        $data->save();
    
        return redirect()->route('pengajuanrawmat.show', $data->id)
            ->with('success', 'Status berhasil diubah menjadi Proses Analisa');
    }
    
    /**
     * Change status to "Analisa Selesai"
     */
    public function analisaSelesai($id)
    {
        $data = PengajuanRawmat::findOrFail($id);
    
        // Cek apakah status ini sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_rawmat_id', $data->id)
            ->where('status', 'Analisa Selesai')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Analisa Selesai ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_rawmat_id', $data->id)
                ->orderBy('changed_at', 'desc')
                ->first();
    
            // Hitung interval waktu jika ada history sebelumnya
            $interval = '-';
            if ($previousHistory) {
                $previousChangedAt = Carbon::parse($previousHistory->changed_at);
                $currentChangedAt = Carbon::now();
                $interval = $previousChangedAt->diffInMinutes($currentChangedAt) . ' menit';
            }
    
            StatusHistory::create([
                'pengajuan_rawmat_id' => $data->id,
                'status' => 'Analisa Selesai',
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'interval' => $interval,
            ]);
        }
    
        // Ubah status menjadi "Analisa Selesai"
        $data->status = 'Analisa Selesai';
        $data->jam_masuk = Carbon::now();
        $data->save();
    
        return redirect()->route('pengajuanrawmat.show', $data->id)
            ->with('success', 'Status berhasil diubah menjadi Analisa Selesai');
    }
    
    /**
     * Change status to "Review Hasil"
     */
    public function reviewHasil($id)
    {
        $data = PengajuanRawmat::findOrFail($id);
    
        // Cek apakah status ini sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_rawmat_id', $data->id)
            ->where('status', 'Review Hasil')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Review Hasil ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_rawmat_id', $data->id)
                ->orderBy('changed_at', 'desc')
                ->first();
    
            // Hitung interval waktu jika ada history sebelumnya
            $interval = '-';
            if ($previousHistory) {
                $previousChangedAt = Carbon::parse($previousHistory->changed_at);
                $currentChangedAt = Carbon::now();
                $interval = $previousChangedAt->diffInMinutes($currentChangedAt) . ' menit';
            }
    
            StatusHistory::create([
                'pengajuan_rawmat_id' => $data->id,
                'status' => 'Review Hasil',
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'interval' => $interval,
            ]);
        }
    
        // Ubah status menjadi "Review Hasil"
        $data->status = 'Review Hasil';
        $data->jam_masuk = Carbon::now();
        $data->save();
    
        return redirect()->route('pengajuanrawmat.show', $data->id)
            ->with('success', 'Status berhasil diubah menjadi Review Hasil');
    }
    
    /**
     * Reject review hasil with reason
     */
    public function tolakReviewHasil($id, Request $request)
    {
        $data = PengajuanRawmat::findOrFail($id);
    
        // Pastikan status pengajuan adalah "Review Hasil"
        if ($data->status != 'Review Hasil') {
            return redirect()->back()
                ->with('error', 'Status harus dalam Review Hasil sebelum melakukan penolakan.');
        }
    
        // Validasi alasan penolakan
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);
    
        // Simpan status sebelumnya di status_histories
        $previousHistory = StatusHistory::where('pengajuan_rawmat_id', $data->id)
            ->orderBy('changed_at', 'desc')
            ->first();
    
        // Hitung interval waktu jika ada history sebelumnya
        $interval = '-';
        if ($previousHistory) {
            $previousChangedAt = Carbon::parse($previousHistory->changed_at);
            $currentChangedAt = Carbon::now();
            $interval = $previousChangedAt->diffInMinutes($currentChangedAt) . ' menit';
        }
    
        // Simpan status penolakan ke history
        StatusHistory::create([
            'pengajuan_rawmat_id' => $data->id,
            'status' => 'Review Hasil', // status sebelumnya
            'changed_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            'rejection_reason' => $request->rejection_reason,
            'user_id' => auth()->user()->id,
            'user_name' => ucwords(auth()->user()->name),
            'interval' => $interval,
        ]);
    
        // Ubah status pengajuan menjadi "Proses Analisa"
        $data->status = 'Proses Analisa';
        $data->jam_masuk = Carbon::now();
        $data->save();
    
        return redirect()->route('pengajuanrawmat.show', $data->id)
            ->with('success', 'Pengajuan Raw Material ditolak dan status diubah menjadi Proses Analisa.');
    }
    
    /**
     * Change status to "Approve"
     */
    public function approve($id)
    {
        $data = PengajuanRawmat::findOrFail($id);
    
        // Check if already CoA Approved - PREVENT DUPLICATE APPROVAL
        $isCoaApproved = StatusHistory::where('pengajuan_rawmat_id', $data->id)
            ->where('status', 'CoA Approved')
            ->exists();
            
        if ($isCoaApproved) {
            return redirect()->route('pengajuanrawmat.show', $data->id)
                ->with('info', 'Pengajuan sudah dalam status CoA Approved, tidak perlu diapprove lagi.');
        }
        
        // Cek apakah status ini sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_rawmat_id', $data->id)
            ->where('status', 'Approve')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Approve ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_rawmat_id', $data->id)
                ->orderBy('changed_at', 'desc')
                ->first();
    
            // Hitung interval waktu jika ada history sebelumnya
            $interval = '-';
            if ($previousHistory) {
                $previousChangedAt = Carbon::parse($previousHistory->changed_at);
                $currentChangedAt = Carbon::now();
                $interval = $previousChangedAt->diffInMinutes($currentChangedAt) . ' menit';
            }
    
            StatusHistory::create([
                'pengajuan_rawmat_id' => $data->id,
                'status' => 'Approve',
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'interval' => $interval,
            ]);
        }
    
        // Ubah status PengajuanRawmat menjadi "Approve"
        $data->status = 'Approve';
        $data->jam_masuk = Carbon::now();
        $data->save();
    
        return redirect()->route('pengajuanrawmat.show', $data->id)
            ->with('success', 'Status berhasil diubah menjadi Approve');
    }
    
   
    public function lokal($id)
    {
        try {
            $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
            
            // Check if CoA is fully approved
            $isCoaApproved = StatusHistory::where('pengajuan_rawmat_id', $pengajuanrawmat->id)
                ->where('status', 'CoA Approved')
                ->exists();
                
            return view('pengajuanrawmat.lokal', compact('pengajuanrawmat', 'isCoaApproved'));
        } catch (\Exception $e) {
            return redirect()->route('pengajuanrawmat.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }
    
    /**
     * View for CoA ekspor
     */
    public function expor($id)
    {
        try {
            $pengajuanrawmat = PengajuanRawmat::findOrFail($id);
            
            // Check if CoA is fully approved
            $isCoaApproved = StatusHistory::where('pengajuan_rawmat_id', $pengajuanrawmat->id)
                ->where('status', 'CoA Approved')
                ->exists();
                
            return view('pengajuanrawmat.expor', compact('pengajuanrawmat', 'isCoaApproved'));
        } catch (\Exception $e) {
            return redirect()->route('pengajuanrawmat.index')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    public function requestCoaApproval($id)
    {
        try {
            $data = PengajuanRawmat::findOrFail($id);
            
            // Ensure the data is in "Approve" status before starting CoA approval process
            if ($data->status !== 'Approve') {
                return redirect()->back()->with('error', 'Pengajuan harus sudah di-Approve sebelum meminta persetujuan CoA.');
            }
            
            // Create CoA Review Foreman status history with shorter status name
            StatusHistory::create([
                'pengajuan_rawmat_id' => $data->id,
                'status' => 'CoA Foreman', // Use shorter status name
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'is_approved' => null, // null means pending
                'interval' => '-',
            ]);
            
            return redirect()->route('pengajuanrawmat.index')
                ->with('success', 'Permintaan persetujuan CoA telah dikirim ke Foreman.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal meminta persetujuan CoA: ' . $e->getMessage());
        }
    }
    
    /**
     * Approve CoA by Foreman
     */
    public function approveCoaForeman($id)
    {
        try {
            $data = PengajuanRawmat::findOrFail($id);
            
            // Update the Foreman review status to approved
            StatusHistory::where('pengajuan_rawmat_id', $data->id)
                ->where('status', 'CoA Foreman')
                ->update([
                    'is_approved' => true,
                    'changed_at' => Carbon::now()
                ]);
            
            // Create CoA Review Supervisor status history
            StatusHistory::create([
                'pengajuan_rawmat_id' => $data->id,
                'status' => 'CoA Supervisor', // Use shorter status name
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'is_approved' => null, // null means pending
                'interval' => '-',
            ]);
            
            return redirect()->route('pengajuanrawmat.index')
                ->with('success', 'CoA telah disetujui oleh Foreman dan menunggu persetujuan Supervisor.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyetujui CoA: ' . $e->getMessage());
        }
    }
    
    /**
     * Reject CoA by Foreman with reason
     */
    public function rejectCoaForeman(Request $request, $id)
    {
        try {
            $data = PengajuanRawmat::findOrFail($id);
            
            // Validate rejection reason
            $request->validate([
                'rejection_reason' => 'required|string|max:255',
            ]);
            
            // Update the Foreman review status to rejected with reason
            StatusHistory::where('pengajuan_rawmat_id', $data->id)
                ->where('status', 'CoA Foreman')
                ->update([
                    'is_approved' => false,
                    'rejection_reason' => $request->rejection_reason,
                    'changed_at' => Carbon::now()
                ]);
            
            // Create a new status history entry for the rejection
            StatusHistory::create([
                'pengajuan_rawmat_id' => $data->id,
                'status' => 'CoA Rejected by Foreman',
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'is_approved' => false,
                'rejection_reason' => $request->rejection_reason,
                'interval' => '-',
            ]);
            
            return redirect()->route('pengajuanrawmat.index')
                ->with('success', 'CoA telah ditolak oleh Foreman dengan alasan: ' . $request->rejection_reason);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menolak CoA: ' . $e->getMessage());
        }
    }
    
    /**
     * Approve CoA by Supervisor (Final approval)
     */
    public function approveCoaSupervisor($id)
    {
        try {
            $data = PengajuanRawmat::findOrFail($id);
            
            // Verify that Foreman has approved
            $foremanApproved = StatusHistory::where('pengajuan_rawmat_id', $data->id)
                ->where('status', 'CoA Foreman')
                ->where('is_approved', true)
                ->exists();
                
            if (!$foremanApproved) {
                return redirect()->back()
                    ->with('error', 'CoA harus disetujui oleh Foreman terlebih dahulu.');
            }
            
            // Update the Supervisor review status to approved
            StatusHistory::where('pengajuan_rawmat_id', $data->id)
                ->where('status', 'CoA Supervisor')
                ->update([
                    'is_approved' => true,
                    'changed_at' => Carbon::now()
                ]);
            
            // Create CoA Approved status history (final approval)
            StatusHistory::create([
                'pengajuan_rawmat_id' => $data->id,
                'status' => 'CoA Approved',
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'is_approved' => true,
                'interval' => '-',
            ]);
            
            return redirect()->route('pengajuanrawmat.index')
                ->with('success', 'CoA telah disetujui sepenuhnya dan siap untuk dicetak.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menyetujui CoA: ' . $e->getMessage());
        }
    }
    
    /**
     * Reject CoA by Supervisor with reason
     */
    public function rejectCoaSupervisor(Request $request, $id)
    {
        try {
            $data = PengajuanRawmat::findOrFail($id);
            
            // Validate rejection reason
            $request->validate([
                'rejection_reason' => 'required|string|max:255',
            ]);
            
            // Update the Supervisor review status to rejected with reason
            StatusHistory::where('pengajuan_rawmat_id', $data->id)
                ->where('status', 'CoA Supervisor')
                ->update([
                    'is_approved' => false,
                    'rejection_reason' => $request->rejection_reason,
                    'changed_at' => Carbon::now()
                ]);
            
            // Create a new status history entry for the rejection
            StatusHistory::create([
                'pengajuan_rawmat_id' => $data->id,
                'status' => 'CoA Rejected by Supervisor',
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'is_approved' => false,
                'rejection_reason' => $request->rejection_reason,
                'interval' => '-',
            ]);
            
            return redirect()->route('pengajuanrawmat.index')
                ->with('success', 'CoA telah ditolak oleh Supervisor dengan alasan: ' . $request->rejection_reason);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menolak CoA: ' . $e->getMessage());
        }
    }
}
