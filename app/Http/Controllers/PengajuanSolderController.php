<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSolder;
use App\Models\CategorySolder;
use App\Models\Sncu;
use App\Models\Snagcu;
use App\Models\Snag;
use App\Models\Tin;
use App\Models\DataSolder;
use App\Models\statusHistory;
use Carbon\Carbon;
use PDF;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;
use DB;


class PengajuanSolderController extends Controller
{

    public function index(Request $request)
    {
        // Ambil parameter filter dan jumlah data per halaman
        $filter = $request->get('filter', 'all'); // Default 'all'
        $pageSize = $request->get('page_size', 10); // Default 10 data per halaman
    
        $query = PengajuanSolder::query();
    
        // Logika filter data
        if ($filter === 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter === 'this_month') {
            // Filter berdasarkan bulan dan tahun saat ini
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        }
    
        // Ambil data dengan paginasi
        $pengajuansolder = $query->orderBy('created_at', 'ASC')->paginate($pageSize);
    
        return view('pengajuansolder.index', compact('pengajuansolder'));
    }
    
        
    public function getTipeSolderByCategory($categoryId)
    {
        $tipeSolders = TipeSolder::where('id_category', $categoryId)->get();
        return response()->json($tipeSolders);
    }
    
    public function create()
    {
        $solders = DataSolder::all(); // Ambil data dari tabel tipe_solder
        $categorysolder = CategorySolder::all();
        $datasolder1 = DataSolder::where('nama_kategori', 'Sn/Cu Series')->distinct()->get();
        $datasolder2 = DataSolder::where('nama_kategori', 'Sn/Ag/Cu Series')->distinct()->get();
        $datasolder3 = DataSolder::where('nama_kategori', 'Sn/Ag Series')->distinct()->get();
        $datasolder4 = DataSolder::where('nama_kategori', 'Tin-Lead Solder Bar')->distinct()->get();

        $tipesolder = DataSolder::select('tipe_solder')->distinct()->get();
    
    
        return view('pengajuansolder.create', compact('categorysolder', 'datasolder1', 'datasolder2', 'datasolder3', 'datasolder4','tipesolder','solders'));
    }

        public function createe($id)
        {
            $solders = DataSolder::all(); // Ambil data dari tabel tipe_solde
            $pengajuansolder = PengajuanSolder::findOrFail($id); // Data pengajuan berdasarkan IDr
            $categorysolder = CategorySolder::all();
            $datasolder1 = DataSolder::where('nama_kategori', 'Sn/Cu Series')->distinct()->get();
            $datasolder2 = DataSolder::where('nama_kategori', 'Sn/Ag/Cu Series')->distinct()->get();
            $datasolder3 = DataSolder::where('nama_kategori', 'Sn/Ag Series')->distinct()->get();
            $datasolder4 = DataSolder::where('nama_kategori', 'Tin-Lead Solder Bar')->distinct()->get();

            $tipesolder = DataSolder::select('tipe_solder')->distinct()->get();
        
        
            return view('pengajuansolder.createe', compact('categorysolder', 'datasolder1', 'datasolder2', 'datasolder3', 'datasolder4','tipesolder','solders','pengajuansolder'));
        }
        
        public function store(Request $request)
        {
            // Validasi input
            $validatedData = $request->validate([
                'nama' => 'nullable|string',
                'tgl' => 'nullable|date',
                'tipe_solder' => 'nullable|string',
                'batch' => 'nullable|string',
                'audit_trail' => 'nullable|string',
                'jam_masuk' => 'nullable|string',
                'deskripsi' => 'nullable|string',
                'id_category' => 'nullable|exists:category_solder,id_category',
                'sn' => 'nullable|string',
                'ag' => 'nullable|numeric',
                'cu' => 'nullable|numeric',
                'pb' => 'nullable|string',
                'sb' => 'nullable|numeric',
                'zn' => 'nullable|numeric',
                'fe' => 'nullable|numeric',
                'as' => 'nullable|numeric',
                'ni' => 'nullable|numeric',
                'bi' => 'nullable|numeric', 
                'cd' => 'nullable|numeric',
                'ai' => 'nullable|numeric',
                'pe' => 'nullable|numeric',
                'ga' => 'nullable|numeric',
                'status' => 'nullable|string',
                // Validasi untuk status tambahan
                'sn_status' => 'nullable|string',
                'ag_status' => 'nullable|string',
                'cu_status' => 'nullable|string',
                'pb_status' => 'nullable|string',
                'sb_status' => 'nullable|string',
                'zn_status' => 'nullable|string',
                'fe_status' => 'nullable|string',
                'as_status' => 'nullable|string',
                'ni_status' => 'nullable|string',
                'bi_status' => 'nullable|string',
                'cd_status' => 'nullable|string',
                'ai_status' => 'nullable|string',
                'pe_status' => 'nullable|string',
                'ga_status' => 'nullable|string',
            ]);
        
            // Menambahkan previous_status dengan nilai default
            $pengajuansolder = new PengajuanSolder([
                'nama' => $validatedData['nama'] ?? null,
                'tgl' => $validatedData['tgl'] ?? null,
                'tipe_solder' => $validatedData['tipe_solder'] ?? null,
                'batch' => $validatedData['batch'] ?? null,
                'audit_trail' => $validatedData['audit_trail'] ?? null,
                'jam_masuk' => $validatedData['jam_masuk'] ?? null,
                'deskripsi' => $validatedData['deskripsi'] ?? null,
                'id_category' => $validatedData['id_category'] ?? null,
                'sn' => $validatedData['sn'] ?? null,
                'ag' => $validatedData['ag'] ?? null,
                'cu' => $validatedData['cu'] ?? null,
                'pb' => $validatedData['pb'] ?? null,
                'sb' => $validatedData['sb'] ?? null,
                'zn' => $validatedData['zn'] ?? null,
                'fe' => $validatedData['fe'] ?? null,
                'as' => $validatedData['as'] ?? null,
                'ni' => $validatedData['ni'] ?? null,
                'bi' => $validatedData['bi'] ?? null,
                'cd' => $validatedData['cd'] ?? null,
                'ai' => $validatedData['ai'] ?? null,
                'pe' => $validatedData['pe'] ?? null,
                'ga' => $validatedData['ga'] ?? null,
                'status' => $validatedData['status'] ?? null,
                // Menambahkan status untuk masing-masing elemen
                'sn_status' => $validatedData['sn_status'] ?? null,
                'ag_status' => $validatedData['ag_status'] ?? null,
                'cu_status' => $validatedData['cu_status'] ?? null,
                'pb_status' => $validatedData['pb_status'] ?? null,
                'sb_status' => $validatedData['sb_status'] ?? null,
                'zn_status' => $validatedData['zn_status'] ?? null,
                'fe_status' => $validatedData['fe_status'] ?? null,
                'as_status' => $validatedData['as_status'] ?? null,
                'ni_status' => $validatedData['ni_status'] ?? null,
                'bi_status' => $validatedData['bi_status'] ?? null,
                'cd_status' => $validatedData['cd_status'] ?? null,
                'ai_status' => $validatedData['ai_status'] ?? null,
                'pe_status' => $validatedData['pe_status'] ?? null,
                'ga_status' => $validatedData['ga_status'] ?? null,
            ]);

    $pengajuansolder->save();

    // Simpan status "Pengajuan" ke StatusHistory
    StatusHistory::create([
        'pengajuan_solder_id' => $pengajuansolder->id, // Menggunakan ID yang baru disimpan
        'status' => 'Pengajuan',
        'updated_at' => Carbon::now(),
        'user_id' => auth()->user()->id,
    ]);

    return redirect()->route('pengajuansolder.index')->with('success', 'Data Pengajuan Solder berhasil disimpan.');
}


    public function show($id)
    {
        $pengajuanSolder = PengajuanSolder::where('id', $id)->orderBy('jam_masuk', 'asc')->first();

        $pengajuansolder = PengajuanSolder::findOrFail($id); // Data pengajuan berdasarkan ID
        $categorysolder = CategorySolder::all();
        $tbs_sncu = Sncu::all();
        $tbs_snagcu = Snagcu::all();
        $tbs_snag = Snag::all();
        $tbs_tin = Tin::all();
        $datasolder = DataSolder::all();

        $lastStatusHistory = $pengajuanSolder->statusHistory()->latest()->first();
        $lastStatusUser = $lastStatusHistory ? $lastStatusHistory->user->name : 'Tidak Diketahui';
    
        return view('pengajuansolder.show', compact(
            'pengajuansolder', 
            'categorysolder', 
            'tbs_sncu', 
            'tbs_snagcu', 
            'tbs_snag', 
            'tbs_tin',
            'datasolder',
            'pengajuanSolder',
            'lastStatusUser'
        ));
        
    }

    
    public function edit(string $id)
    {
        $pengajuansolder = PengajuanSolder::findOrFail($id);
    
        return view('pengajuansolder.edit', compact('pengajuansolder'));
    }

    public function update(Request $request, string $id)
    {
        // Find the solder record to update
        $pengajuansolder = PengajuanSolder::findOrFail($id);
        
        // Set basic fields with null/default handling
        $pengajuansolder->nama = $request->input('nama', $pengajuansolder->nama);
        $pengajuansolder->tgl = $request->input('tgl', $pengajuansolder->tgl);
        $pengajuansolder->tipe_solder = $request->input('tipe_solder', $pengajuansolder->tipe_solder); 
        $pengajuansolder->batch = $request->input('batch', $pengajuansolder->batch);
        $pengajuansolder->audit_trail = $request->input('audit_trail', $pengajuansolder->audit_trail);
        $pengajuansolder->jam_masuk = $request->input('jam_masuk', $pengajuansolder->jam_masuk);
        $pengajuansolder->id_category = $request->input('id_category', $pengajuansolder->id_category);
        $pengajuansolder->deskripsi = $request->input('deskripsi', $pengajuansolder->deskripsi);
        $pengajuansolder->status = $request->input('status', $pengajuansolder->status);
        
        // Process chemical fields and their status fields
        $chemicalFields = ['sn', 'ag', 'cu', 'pb', 'sb', 'zn', 'fe', 'as', 'ni', 'bi', 'cd', 'ai', 'pe', 'ga'];
        
        foreach ($chemicalFields as $field) {
            // Update element value
            if ($request->has($field)) {
                $pengajuansolder->$field = $request->input($field);
            }
            
            // Update element status (Passed or Not Passed)
            $statusField = $field . '_status';
            if ($request->has($statusField)) {
                $pengajuansolder->$statusField = $request->input($statusField);
            }
        }
        
        // Save all changes
        $pengajuansolder->save();
        
        // Stay on the same page with a success message
        return redirect()->route('pengajuansolder.createe', $pengajuansolder->id)
            ->with('success', 'Data berhasil disimpan dengan status validasi');
    }
    
    
    
    

    public function destroy(string $id)
    {
        $pengajuansolder = PengajuanSolder::findOrFail($id);
  
        $pengajuansolder->delete();
  
        return redirect()->route('pengajuansolder')->with('success', 'Pengajuan Solder deleted successfully');
    }
  
    
    public function getTipeSolderDetail($tipe_solder)
    {
        // Ambil data tipe solder berdasarkan nilai tipe_solder yang dipilih
        $solderDetail = DataSolder::where('tipe_solder', $tipe_solder)->get();
    
        // Kembalikan data dalam format JSON
        return response()->json($solderDetail);
    }
    public function validateTipeSolder($categoryId, $tipeSolder)
    {
        // Ambil data solder berdasarkan categoryId dan tipeSolder
        $tipe = DataSolder::where('category_id', $categoryId)
                          ->where('tipe_solder', $tipeSolder)
                          ->first();
    
        if ($tipe) {
            // Validasi untuk 'Cd', misalnya jika Cd harus < 0.04
            $cdValid = floatval($tipe->cd) < 0.04;
    
            return response()->json([
                'isValidCd' => $cdValid
            ]);
        }
    
        return response()->json([
            'isValidCd' => false
        ]);
    }

    public function pengajuan($id)
    {
        $data = PengajuanSolder::findOrFail($id);
    
        // Cek apakah status Pengajuan sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_solder_id', $data->id)
            ->where('status', 'Pengajuan')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Pengajuan ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_solder_id', $data->id)
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
                'pengajuan_solder_id' => $data->id,
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
    
        return redirect()->route('pengajuansolder.show', $data->id)->with('success', 'Status berhasil diubah menjadi Pengajuan');
    }
    
    public function prosesAnalisa($id)
    {
        $data = PengajuanSolder::findOrFail($id);
        
        // Check if we already have a "Proses Analisa" status record
        $existingHistory = StatusHistory::where('pengajuan_solder_id', $data->id)
            ->where('status', 'Proses Analisa')
            ->first();
    
        // If there's no existing status history, create one
        if (!$existingHistory) {
            // Get the previous status history
            $previousHistory = StatusHistory::where('pengajuan_solder_id', $data->id)
                ->orderBy('changed_at', 'desc')
                ->first();
    
            // Calculate interval if there's previous history
            $interval = '-';
            if ($previousHistory) {
                $previousChangedAt = Carbon::parse($previousHistory->changed_at);
                $currentChangedAt = Carbon::now();
                $interval = $previousChangedAt->diffInMinutes($currentChangedAt) . ' menit';
            }
    
            // Create status history record
            StatusHistory::create([
                'pengajuan_solder_id' => $data->id,  // FIXED: Changed from pengajuan_chemical_id
                'status' => 'Proses Analisa',
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'interval' => $interval,
            ]);
        }
    
        // Always update status to "Proses Analisa" (ensure it's always in process mode)
        $data->status = 'Proses Analisa';
        $data->jam_masuk = Carbon::now();
        $data->save();
    
        // Always redirect to createe for analysis
        return redirect()->route('pengajuansolder.createe', $data->id)
            ->with('success', 'Status berhasil diubah menjadi Proses Analisa');
    }
    
    

    
    public function analisaSelesai($id)
    {
        $data = PengajuanSolder::findOrFail($id);
    
        // Cek apakah status ini sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_solder_id', $data->id)
            ->where('status', 'Analisa Selesai')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Analisa Selesai ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_solder_id', $data->id)
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
                'pengajuan_solder_id' => $data->id,
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
    
        return redirect()->route('pengajuansolder.show', $data->id)->with('success', 'Status berhasil diubah menjadi Analisa Selesai');
    }
    
    public function reviewHasil($id)
    {
        $data = PengajuanSolder::findOrFail($id);
    
        // Cek apakah status ini sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_solder_id', $data->id)
            ->where('status', 'Review Hasil')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Review Hasil ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_solder_id', $data->id)
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
                'pengajuan_solder_id' => $data->id,
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
    
        return redirect()->route('pengajuansolder.show', $data->id)->with('success', 'Status berhasil diubah menjadi Review Hasil');
    }
    
    public function tolakReviewHasil($id, Request $request)
    {
        $data = PengajuanSolder::findOrFail($id);
        
        // Pastikan status sebelumnya adalah "Review Hasil"
        if ($data->status != 'Review Hasil') {
            return redirect()->back()->with('error', 'Status harus dalam Review Hasil sebelum melakukan penolakan.');
        }
    
        // Validasi input alasan penolakan
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);
    
        // Simpan status sebelumnya di status_histories
        $previousHistory = StatusHistory::where('pengajuan_solder_id', $data->id)
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
            'pengajuan_solder_id' => $data->id,
            'status' => 'Review Hasil', // status sebelumnya
            'changed_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            'rejection_reason' => $request->rejection_reason,
            'user_id' => auth()->user()->id,
            'user_name' => ucwords(auth()->user()->name),
            'interval' => $interval,
        ]);
    
        // Ubah status menjadi "Proses Analisa"
        $data->status = 'Proses Analisa';
        $data->jam_masuk = Carbon::now();
        $data->save();
    
        return redirect()->route('pengajuansolder.show', $data->id)
            ->with('success', 'Pengajuan Solder ditolak dan status diubah menjadi Proses Analisa.');
    }
    
    
    public function approve($id)
    {
        $data = PengajuanSolder::findOrFail($id);
    
        // Cek apakah status ini sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_solder_id', $data->id)
            ->where('status', 'Approve')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Approve ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_solder_id', $data->id)
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
                'pengajuan_solder_id' => $data->id,
                'status' => 'Approve',
                'changed_at' => Carbon::now(),
                'user_id' => auth()->user()->id,
                'user_name' => ucwords(auth()->user()->name),
                'interval' => $interval,
            ]);
        }
    
        // Ubah status PengajuanSolder menjadi "Approve"
        $data->status = 'Approve';
        $data->jam_masuk = Carbon::now();
        $data->save();
    
        return redirect()->route('pengajuansolder.show', $data->id)
            ->with('success', 'Status berhasil diubah menjadi Approve');
    }
    
    
public function print($id)
    {
        // Ambil data pengajuan solder berdasarkan ID
        $pengajuansolder = PengajuanSolder::findOrFail($id);
    
    
        return view('pengajuansolder.print', compact('pengajuansolder'));
    }


public function exportToExcel()
{
    // Ambil data yang relevan dari tabel
    $data = PengajuanSolder::select([
        'id',
        'nama',
        'tgl',
        'tipe_solder',
        'batch',
        'audit_trail',
        'jam_masuk',
        'created_at',
        'updated_at',
        'id_category',
        'sn',
        'ag',
        'cu',
        'pb',
        'sb',
        'zn',
        'fe',
        'as',
        'ni',
        'bi',
        'cd',
        'ai',
        'pe',
        'ga',
        'status',
        'previous_status',
        'previous_jam_masuk',
    ])->get();

    // Membuat dan mengekspor file Excel
    return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
        private $data;

        public function __construct($data)
        {
            $this->data = $data;
        }

        public function collection()
        {
            return $this->data;
        }

        public function headings(): array
        {
            return [
                'ID',
                'Nama',
                'Tanggal',
                'Tipe Solder',
                'Batch',
                'Audit Trail',
                'Jam Masuk',
                'Created At',
                'Updated At',
                'ID Kategori',
                'SN',
                'AG',
                'CU',
                'PB',
                'SB',
                'ZN',
                'FE',
                'AS',
                'NI',
                'BI',
                'CD',
                'AI',
                'PE',
                'GA',
                'Status',
                'Previous Status',
                'Previous Jam Masuk',
            ];
        }
    }, 'pengajuansolder.xlsx');
}

public function lokal($id)
{
    // Ambil data pengajuan chemical berdasarkan ID
    $pengajuansolder = PengajuanSolder::findOrFail($id);

    // Ambil data dari DataChemical berdasarkan nama
    $DataSolder = DataSolder::where('tipe_solder', $pengajuansolder->tipe_solder)
                                ->where('id', 5) // Filter untuk ID tertentu
                                ->first();

    return view('pengajuansolder.lokal', compact('pengajuansolder', 'DataSolder'));
}

        public function expor($id)
        {
            // Ambil data pengajuan solder berdasarkan ID
            $pengajuansolder = PengajuanSolder::findOrFail($id);

            // Ambil semua data pengajuan solder dengan tipe_solder yang sama
            $allPengajuanSolder = PengajuanSolder::where('tipe_solder', $pengajuansolder->tipe_solder)->get();

            // Jika ada permintaan AJAX untuk mendapatkan detail pengajuan solder berdasarkan ID
            if (request()->ajax() && request()->has('pengajuan_id')) {
                $pengajuanDetail = PengajuanSolder::findOrFail(request('pengajuan_id'));
                return response()->json($pengajuanDetail); // Kembalikan data JSON
            }

            // Render halaman dengan data
            return view('pengajuansolder.expor', compact('pengajuansolder', 'allPengajuanSolder'));
        }





}
