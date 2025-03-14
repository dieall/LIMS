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
        // Ambil parameter filter dan jumlah data per halaman
        $filter = $request->get('filter', 'all'); // Default filter: 'all'
        $pageSize = $request->get('page_size', 10); // Default jumlah data per halaman: 10
    
        // Query dasar
        $query = PengajuanChemical::query();
    
        // Logika filter data
        if ($filter === 'today') {
            $query->whereDate('created_at', Carbon::today());
        }
    
        // Ambil data dengan pagination
        $pengajuanchemical = $query->orderBy('created_at', 'ASC')->paginate($pageSize);
    
        // Tambahkan parameter ke pagination
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
    
        // Redirect setelah berhasil menyimpan
        return redirect()->route('pengajuanchemical.index')->with('success', 'Data Pengajuan Chemical berhasil disimpan.');
    }


    public function edit(string $id)
    {
        $pengajuanchemical = PengajuanChemical::findOrFail($id);
    
        return view('pengajuanchemical.edit', compact('pengajuanchemical'));
    }
    public function update(Request $request, string $id)
    {
        $pengajuanchemical = PengajuanChemical::findOrFail($id);

        $pengajuanchemical->update($request->all());

        return redirect()->route('pengajuanchemical')->with('success', 'Pengajuan Chemical updated successfully');
    }
    public function show($id)
    {
        // Mencari data pengajuan chemical berdasarkan ID
        $pengajuanchemical = PengajuanChemical::with('user')->find($id);
        
        // Mengembalikan view show dengan data pengajuan
        return view('pengajuanchemical.show', compact('pengajuanchemical'));
    }





    public function prosesAnalisa($id)
    {
        $data = PengajuanChemical::findOrFail($id);
    
        // Cek apakah status ini sudah pernah disimpan di status_histories
        $existingHistory = StatusHistory::where('pengajuan_chemical_id', $data->id)
            ->where('status', $data->status)
            ->first();
    
        if (!$existingHistory) {
            // Simpan status sebelumnya ke status_histories
            StatusHistory::create([
                'pengajuan_chemical_id' => $data->id,
                'status' => $data->status,
                'changed_at' => $data->jam_masuk ?? now(), // Ambil jam_masuk jika ada
            ]);
        }
    
        // Ubah status menjadi "Proses Analisa"
        $data->status = 'Proses Analisa';
        $data->jam_masuk = now(); // Waktu baru untuk status baru
        $data->save();
    
        return redirect()->route('pengajuanchemical.show', $data->id);
    }
    
    public function analisaSelesai($id)
    {
        $data = PengajuanChemical::findOrFail($id);
    
        // Menyimpan status sebelumnya jika status sebelumnya belum tercatat
        if ($data->status != 'Analisa Selesai') {
            StatusHistory::create([
                'pengajuan_chemical_id' => $data->id,
                'status' => $data->status,
                'changed_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ]);
        }
    
        // Ubah status menjadi "Analisa Selesai"
        $data->status = 'Analisa Selesai';
        $data->save();
    
        // Redirect atau response
        return redirect()->route('pengajuanchemical.show', $data->id);
    }
    
    public function reviewHasil($id)
    {
        $data = PengajuanChemical::findOrFail($id);
    
        // Pastikan status sudah selesai dianalisa
        if ($data->status != 'Analisa Selesai') {
            return redirect()->back()->with('error', 'Status harus dalam Analisa Selesai sebelum melakukan Review Hasil');
        }
    
        // Menyimpan status sebelumnya jika status sebelumnya belum tercatat
        if ($data->status != 'Review Hasil') {
            StatusHistory::create([
                'pengajuan_chemical_id' => $data->id,
                'status' => $data->status,
                'changed_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
            ]);
        }
    
        // Ubah status pengajuan solder menjadi "Review Hasil"
        $data->status = 'Review Hasil';
        $data->jam_masuk = Carbon::now();
        $data->save();
    
        return redirect()->route('pengajuanchemical.show', $data->id)->with('success', 'Status berhasil diubah ke Review Hasil');
    }
    

    public function tolakReviewHasil($id, Request $request)
{
    $data = PengajuanChemical::findOrFail($id);

    // Pastikan status sudah dalam "Review Hasil"
    if ($data->status != 'Review Hasil') {
        return redirect()->back()->with('error', 'Status harus dalam Review Hasil sebelum dapat melakukan penolakan');
    }

    // Validasi apakah alasan penolakan sudah diisi
    $request->validate([
        'rejection_reason' => 'required|string|max:255',  // Validasi untuk alasan penolakan
    ]);

    // Menyimpan status sebelumnya di status_histories
    StatusHistory::create([
        'pengajuan_chemical_id' => $data->id,
        'status' => $data->status,
        'changed_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
        'rejection_reason' => $request->rejection_reason,  // Menyimpan alasan penolakan
    ]);

    // Ubah status pengajuan solder menjadi "Tidak Diterima"
    $data->status = 'Proses Analisa';
    $data->save();

    return redirect()->route('pengajuanchemical.show', $data->id)->with('success', 'Pengajuan Solder ditolak dan status diubah menjadi Tidak Diterima');
}

public function approve($id)
{
    $data = PengajuanChemical::findOrFail($id);

    // Pastikan status sudah dalam "Review Hasil"
    if ($data->status != 'Review Hasil') {
        return redirect()->back()->with('error', 'Status harus dalam Review Hasil sebelum melakukan Approve');
    }

    // Simpan status sebelumnya di status_histories
    StatusHistory::create([
        'pengajuan_chemical_id' => $data->id,
        'status' => $data->status,
        'changed_at' => Carbon::now()->format('Y-m-d H:i:s.u'),
    ]);

    // Tambahkan delay 100 milidetik untuk membedakan timestamp
    usleep(100000); // Delay 100 ms

    // Ubah status pengajuan solder menjadi "Approve"
    $data->status = 'Approve';
    $data->jam_masuk = Carbon::now()->format('Y-m-d H:i:s.u');
    $data->save();

    return redirect()->route('pengajuanchemical.show', $data->id)->with('success', 'Status berhasil diubah ke Approve');
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
                'Solid',
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
