<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PengajuanChemical;
use App\Models\DataChemical;
use App\Models\statusHistory;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelType;

class PengajuanChemicalController extends Controller
{

    
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $pageSize = $request->get('page_size', 10);
    
        // Query dasar
        $query = PengajuanChemical::query();
    
        // Logika filter data
        if ($filter === 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter === 'this_month') {
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year);
        }
    
        // Ambil data dengan pagination
        $pengajuanchemical = $query->orderBy('created_at', 'ASC')->paginate($pageSize);
    
        // Debugging: pastikan data ada
        if ($pengajuanchemical->isEmpty()) {
            return view('pengajuanchemical.index')->with('error', 'Data tidak ditemukan.');
        }
    
        $pengajuanchemical->appends([
            'filter' => $filter,
            'page_size' => $pageSize,
        ]);
    
        return view('pengajuanchemical.index', compact('pengajuanchemical'));
    }
    

    public function create()
    {
        $datachemical = DataChemical::select('kategori')->distinct()->get();
    
        // Ambil data berdasarkan kategori
        $datasolder1 = DataChemical::where('kategori', 'DMT')->get();
        $datasolder2 = DataChemical::where('kategori', 'Tinstab')->get();
        $datasolder3 = DataChemical::where('kategori', 'Tinchem')->get();
    
        // $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $today = Carbon::today(); // Tanggal hari ini
        // Ambil data transaksi hanya untuk tanggal hari ini
        $transaksi = DataChemical::select('id', 'nama', 'kategori', 'created_at','orang','batch','desc')
        ->whereDate('created_at', $today) // Filter berdasarkan tanggal hari ini
        ->orderBy('created_at', 'ASC')
        ->get();

 
    
        return view('pengajuanchemical.create', compact('datachemical', 'datasolder1', 'datasolder2', 'datasolder3', 'transaksi'));
    }
    
    public function createe($id = null)
    {
        $pengajuanchemical = null;
    
        if ($id) {
            $pengajuanchemical = PengajuanChemical::findOrFail($id);
        }
    
        $datachemical = PengajuanChemical::select('nama_chemical')->distinct()->get();
        $datasolder = PengajuanChemical::whereIn('nama_chemical', ['DMT', 'Tinstab', 'Tinchem'])->get();
    
        $today = Carbon::today(); // Mengambil tanggal hari ini
    
        // Pastikan orderBy digunakan sebelum get(), bukan setelahnya
        $transaksi = PengajuanChemical::select('id', 'nama', 'nama_chemical', 'created_at', 'orang', 'batch', 'desc')
            ->whereDate('created_at', $today) // Filter transaksi hari ini
            ->orderBy('created_at', 'DESC') // Urutkan berdasarkan tanggal
            ->get();
    
        $datasolder1 = PengajuanChemical::where('nama_chemical', 'DMT')->get();
        $datasolder2 = PengajuanChemical::where('nama_chemical', 'Tinstab')->get();
        $datasolder3 = PengajuanChemical::where('nama_chemical', 'Tinchem')->get();
        $datasolder4 = PengajuanChemical::where('nama', 'like', 'DMTDCL-%')->get();
    
        $all_chemical_specs = DB::table('tbc_chemical')->get();
    
        return view('pengajuanchemical.createe', compact(
            'pengajuanchemical',
            'datachemical', 
            'datasolder1', 
            'datasolder2', 
            'datasolder3', 
            'datasolder4', 
            'transaksi', 
            'datasolder',
            'all_chemical_specs'
        ));
    }
    
    
    
    
    public function getNamesByCategory($kategori)
    {
        // Ambil data nama berdasarkan kategori
        $names = DataChemical::where('kategori', $kategori)->get(['nama']);
    
        return response()->json($names);
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_chemical' => 'required', // Pastikan id_chemical valid
            'nama' => 'nullable|string',
            'tgl' => 'nullable|date',
            'batch' => 'nullable|string',
            'desc' => 'nullable|string',
            'jam_masuk' => 'nullable|string',
            'status' => 'nullable|string',
            'clarity' => 'nullable|string',
            'transmission' => 'nullable|string',
            'ape' => 'nullable|string',
            'dimet' => 'nullable|string',
            'trime' => 'nullable|string',
            'tin' => 'nullable|string',
            'solid' => 'nullable|string',
            'ri' => 'nullable|string',
            'sg' => 'nullable|string',
            'acid' => 'nullable|string',
            'sulfur' => 'nullable|string',
            'water' => 'nullable|string',
            'mono' => 'nullable|string',
            'yellow' => 'nullable|string',
            'eh' => 'nullable|string',
            'visco' => 'nullable|string',
            'pt' => 'nullable|string',
            'moisture' => 'nullable|string',
            'cloride' => 'nullable|string',
            'spec' => 'nullable|string',
            'densi' => 'nullable|string',
            'orang' => 'nullable|string',
        ]);
    
        // Menyimpan data ke tabel
        $pengajuanchemical = new PengajuanChemical([
            'nama_chemical' => $validatedData['nama_chemical'] ?? null,
            'nama'      => $validatedData['nama'] ?? null,
            'tgl'       => $validatedData['tgl'] ?? null,
            'batch'     => $validatedData['batch'] ?? null,
            'desc'      => $validatedData['desc'] ?? null,
            'jam_masuk' => $validatedData['jam_masuk'] ?? null,
            'status'    => $validatedData['status'] ?? null,
            'clarity'   => $validatedData['clarity'] ?? null,
            'transmission' => $validatedData['transmission'] ?? null,
            'ape'       => $validatedData['ape'] ?? null,
            'dimet'     => $validatedData['dimet'] ?? null,
            'trime'     => $validatedData['trime'] ?? null,
            'tin'       => $validatedData['tin'] ?? null,
            'solid'     => $validatedData['solid'] ?? null,
            'ri'        => $validatedData['ri'] ?? null,
            'sg'        => $validatedData['sg'] ?? null,
            'acid'      => $validatedData['acid'] ?? null,
            'sulfur'    => $validatedData['sulfur'] ?? null,
            'water'     => $validatedData['water'] ?? null,
            'mono'      => $validatedData['mono'] ?? null,
            'yellow'    => $validatedData['yellow'] ?? null,
            'eh'        => $validatedData['eh'] ?? null,
            'visco'     => $validatedData['visco'] ?? null,
            'pt'        => $validatedData['pt'] ?? null,
            'moisture'  => $validatedData['moisture'] ?? null,
            'cloride'   => $validatedData['cloride'] ?? null,
            'spec'      => $validatedData['spec'] ?? null,
            'densi'     => $validatedData['densi'] ?? null,
            'orang'     => $validatedData['orang'] ?? null,

        ]);

        $pengajuanchemical->save();
    
        // Simpan status "Pengajuan" ke StatusHistory
        StatusHistory::create([
            'pengajuan_chemical_id' => $pengajuanchemical->id, // Menggunakan ID yang baru disimpan
            'status' => 'Pengajuan',
            'updated_at' => Carbon::now(),
            'user_id' => auth()->user()->id,
        ]);
    
        return redirect()->route('pengajuanchemical.index')->with('success', 'Data Pengajuan Chemical berhasil disimpan.');
    }

        public function edit(string $id)
        {
            $pengajuanchemical = PengajuanChemical::findOrFail($id);
        
            return view('pengajuanchemical.edit', compact('pengajuanchemical'));
        }
        public function update(Request $request, $id)
        {
            // Find the chemical record to update
            $pengajuanchemical = PengajuanChemical::findOrFail($id);
            
            // Update basic fields
            $pengajuanchemical->nama_chemical = $request->input('nama_chemical');
            $pengajuanchemical->nama = $request->input('nama');
            $pengajuanchemical->batch = $request->input('batch');
            $pengajuanchemical->desc = $request->input('desc');
            $pengajuanchemical->orang = $request->input('orang');
            $pengajuanchemical->tgl = $request->input('tgl');
            
            // Process chemical fields and their statuses
            if ($request->has('fields')) {
                foreach ($request->input('fields') as $field => $value) {
                    // Check if this field exists in our table schema
                    if (in_array($field, [
                        'clarity', 'transmission', 'ape', 'dimet', 'trime', 'tin', 'solid', 
                        'ri', 'sg', 'acid', 'sulfur', 'water', 'mono', 'yellow', 'eh', 
                        'visco', 'pt', 'moisture', 'cloride', 'spec', 'densi'
                    ])) {
                        // Update this field
                        $pengajuanchemical->$field = $value;
                        
                        // Update corresponding status field
                        $statusField = $field . '_status';
                        if ($request->has($statusField)) {
                            $pengajuanchemical->$statusField = $request->input($statusField);
                        }
                    }
                }
            }
            
            // Save all changes
            $pengajuanchemical->save();
            
            // Redirect back with success message
            return redirect()->route('pengajuanchemical.index')
                ->with('success', 'Data chemical berhasil diperbarui');
        }
        
    public function show($id)
    {
        // Mencari data pengajuan chemical berdasarkan ID
        $pengajuanchemical = PengajuanChemical::with('user')->find($id);
        
        // Mengembalikan view show dengan data pengajuan
        return view('pengajuanchemical.show', compact('pengajuanchemical'));
    }

    public function destroy(string $id)
    {
        $pengajuanchemical = PengajuanChemical::findOrFail($id);
  
        $pengajuanchemical->delete();
  
        return redirect()->route('pengajuanchemical')->with('success', 'Pengajuan Chemical deleted successfully');
    }



    public function pengajuan($id)
    {
        $data = PengajuanChemical::findOrFail($id);
    
        // Cek apakah status Pengajuan sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
            ->where('status', 'Pengajuan')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Pengajuan ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
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
                'pengajuan_chemical_id' => $data->id,
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
    
        return redirect()->route('pengajuanchemical.show', $data->id)->with('success', 'Status berhasil diubah menjadi Pengajuan');
    }
    public function prosesAnalisa($id)
    {
        $data = PengajuanChemical::findOrFail($id);
        
        // Check if we already have a "Proses Analisa" status record
        $existingHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
            ->where('status', 'Proses Analisa')
            ->first();
    
        // If this is the second or later attempt to process analysis
        if ($existingHistory) {
            // Redirect to the createe route for continued analysis
            return redirect()->route('pengajuanchemical.createe', $data->id);
        }
        
        // First time processing - create history record
        $previousHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
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
            'pengajuan_chemical_id' => $data->id,
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
    
        return redirect()->route('pengajuanchemical.show', $data->id)->with('success', 'Status berhasil diubah menjadi Proses Analisa');
    }
    
    
    public function analisaSelesai($id)
    {
        $data = PengajuanChemical::findOrFail($id);
    
        // Cek apakah status ini sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
            ->where('status', 'Analisa Selesai')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Analisa Selesai ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
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
                'pengajuan_chemical_id' => $data->id,
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
    
        return redirect()->route('pengajuanchemical.show', $data->id)->with('success', 'Status berhasil diubah menjadi Analisa Selesai');
    }
    
    public function reviewHasil($id)
    {
        $data = PengajuanChemical::findOrFail($id);
    
        // Cek apakah status ini sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
            ->where('status', 'Review Hasil')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Review Hasil ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
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
                'pengajuan_chemical_id' => $data->id,
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
    
        return redirect()->route('pengajuanchemical.show', $data->id)->with('success', 'Status berhasil diubah menjadi Review Hasil');
    }
    
        public function tolakReviewHasil($id, Request $request)
{
    $data = PengajuanChemical::findOrFail($id);

    // Pastikan status pengajuan adalah "Review Hasil"
    if ($data->status != 'Review Hasil') {
        return redirect()->back()->with('error', 'Status harus dalam Review Hasil sebelum melakukan penolakan.');
    }

    // Validasi alasan penolakan
    $request->validate([
        'rejection_reason' => 'required|string|max:255',
    ]);

    // Simpan status sebelumnya di status_histories
    $previousHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
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
        'pengajuan_chemical_id' => $data->id,
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

    return redirect()->route('pengajuanchemical.show', $data->id)
        ->with('success', 'Pengajuan Chemical ditolak dan status diubah menjadi Proses Analisa.');
}

    public function approve($id)
    {
        $data = PengajuanChemical::findOrFail($id);
    
        // Cek apakah status ini sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
            ->where('status', 'Approve')
            ->first();
    
        if (!$existingHistory) {
            // Simpan status Approve ke status_histories
            $previousHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
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
                'pengajuan_chemical_id' => $data->id,
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
    
        return redirect()->route('pengajuanchemical.show', $data->id)
            ->with('success', 'Status berhasil diubah menjadi Approve');
    }

public function exportToExcel()
{
    // Ambil semua data dari tabel
    $data = PengajuanChemical::select([
        'id',
        'nama_chemical',
        'nama',
        'tgl',
        'jam_masuk',
        'batch',
        'desc',
        'status',
        'clarity',
        'transmission',
        'ape',
        'dimet',
        'trime',
        'tin',
        'solid',
        'ri',
        'sg',
        'acid',
        'sulfur',
        'water',
        'mono',
        'yellow',
        'eh',
        'visco',
        'pt',
        'moisture',
        'cloride',
        'spec',
        'densi',
        'created_at',
        'updated_at',
        'orang',
    ])->get();

    // Ekspor data ke file Excel
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
                'Nama Chemical',
                'Nama',
                'Tanggal',
                'Jam Masuk',
                'Batch',
                'Deskripsi',
                'Status',
                'Clarity',
                'Transmission',
                'APE',
                'Dimet',
                'Trime',
                'Tin',
                'solid',
                'RI',
                'SG',
                'Acid',
                'Sulfur',
                'Water',
                'Mono',
                'Yellow',
                'EH',
                'Visco',
                'PT',
                'Moisture',
                'cloride',
                'Spec',
                'Densi',
                'Created At',
                'Updated At',
                'Orang',
            ];
        }
    }, 'pengajuan_chemical.xlsx');
}






//coa

public function lokal($id)
{
    // Ambil data pengajuan chemical berdasarkan ID
    $pengajuanchemical = PengajuanChemical::findOrFail($id);

    // Ambil data dari DataChemical berdasarkan nama
    $DataChemical = DataChemical::where('nama', $pengajuanchemical->nama)
                                ->where('id', 5) // Filter untuk ID tertentu
                                ->first();

    return view('pengajuanchemical.lokal', compact('pengajuanchemical', 'DataChemical'));
}

public function expor($id)
{
    // Ambil data pengajuan chemical berdasarkan ID
    $pengajuanchemical = PengajuanChemical::findOrFail($id);

    // Ambil data dari DataChemical berdasarkan nama
    $DataChemical = DataChemical::where('nama', $pengajuanchemical->nama)
                                ->where('id', 5) // Filter untuk ID tertentu
                                ->first();

    return view('pengajuanchemical.expor', compact('pengajuanchemical', 'DataChemical'));
}

public function print($id)
{
    // Ambil data pengajuan chemical berdasarkan ID
    $pengajuanchemical = PengajuanChemical::findOrFail($id);


    return view('pengajuanchemical.print', compact('pengajuanchemical'));
}




public function printlokal(Request $request, $id)
{
    // Ambil data dari form
    $data = [
        'brand' => $request->input('brand'),
        'lot_no' => $request->input('lot_no'),
        'date_of_inspection' => $request->input('date_of_inspection'),
        'date_of_release' => $request->input('date_of_release'),
        'po_number' => $request->input('po_number'),
        'net_weight' => $request->input('net_weight'),
    ];

    // Render view cetak dengan data
    $html = view('pengajuanchemical.printlokal', compact('data'))->render();

    // Tambahkan JavaScript untuk mencetak langsung
    $html .= '<script type="text/javascript">window.onload = function() { window.print(); }</script>';

    return response($html);
}


    
}