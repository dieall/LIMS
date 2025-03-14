<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan Anda mengimpor model User
use App\Models\Tinstab;
use App\Models\Dmt;
use App\Models\Tinchem;
use App\Models\PengajuanSolder;
use App\Models\PengajuanChemical;
use App\Models\PengajuanRawmat;
use DB;
use Carbon\Carbon; // Tambahkan Carbon untuk manipulasi tanggal

class DashboardController extends Controller
{
    public function index()
    {
    // Hitung jumlah data yang sudah di-approve hari ini
        $jumlahApprovedHariIni = PengajuanSolder::where('status', 'Approve')
        ->whereDate('created_at', Carbon::today()) // Filter hanya untuk hari ini
        ->count();

            // Hitung jumlah data chemical yang di-approve hari ini
        $jumlahApprovedChemicalHariIni = PengajuanChemical::where('status', 'Approve')
        ->whereDate('updated_at', Carbon::today())
        ->count();

        $jumlahRawmatHariIni = PengajuanRawmat::whereDate('created_at', Carbon::today()) // Hanya data yang masuk hari ini
        ->count();


        // Count the entries based on specific ID patterns
        $mt630Count = DB::table('tb_tinstab')->where('id', 'like', 'MT-630%')->count();
        $mt620Count = DB::table('tb_tinstab')->where('id', 'like', 'MT-620%')->count();
    
        // Retrieve all tinstab data from the table
        $tinstab = DB::table('tb_tinstab')->get(); // or use Tinstab::all();
    
        // Store counts in an array
        $dataCounts = [
            'MT-630' => ['total' => $mt630Count],
            'MT-620' => ['total' => $mt620Count],
        ];
    
        $chartData = Dmt::selectRaw('id, COUNT(*) as total')
            ->groupBy('id')
            ->pluck('total', 'id');
    
        $tinchem = Tinchem::orderBy('created_at', 'ASC')->get();
    
        // Menghitung jumlah data untuk setiap kode BQR berdasarkan kolom id
        $tc191Count = DB::table('tb_tinchem')->where('id', 'like', 'TC-191%')->count();
        $tc185Count = DB::table('tb_tinchem')->where('id', 'like', 'TC-185 VN%')->count();
        $tc181Count = DB::table('tb_tinchem')->where('id', 'like', 'TC-181%')->count();
        $tc192FCount = DB::table('tb_tinchem')->where('id', 'like', 'TC-192 F%')->count();
        $tc181FSCount = DB::table('tb_tinchem')->where('id', 'like', 'TC-181 FS%')->count();
        $tc191FCount = DB::table('tb_tinchem')->where('id', 'like', 'TC-191 F%')->count();
        $tcz159Count = DB::table('tb_tinchem')->where('id', 'like', 'TCZ-159%')->count();
        $tcz139Count = DB::table('tb_tinchem')->where('id', 'like', 'TCZ-139%')->count();
        $tcz139MCount = DB::table('tb_tinchem')->where('id', 'like', 'TCZ-139 M%')->count();
    
        // Menyusun data yang akan digunakan untuk chart
        $dataCountsTinchem = [
            'TC-191' => ['total' => $tc191Count],
            'TC-185 VN' => ['total' => $tc185Count],
            'TC-181' => ['total' => $tc181Count],
            'TC-192 F' => ['total' => $tc192FCount],
            'TCZ-139' => ['total' => $tcz139Count],
            'TCZ-139 M' => ['total' => $tcz139MCount],
            'TC-181 FS' => ['total' => $tc181FSCount],
            'TCZ-159' => ['total' => $tcz159Count],
            'TC-191 F' => ['total' => $tc191FCount],
        ];
    
        // Mengatur label dan data untuk pie chart
        $labels = array_keys($dataCountsTinchem);  // Mendapatkan label ('TC-191', 'TC-185 VN', dll.)
        $data = array_column($dataCountsTinchem, 'total');
    
        // Count the number of users (pegawai)
        $jumlahPegawai = User::count();
    
        // Query data bulanan dari `tbs_pengajuan`
        $currentYear = date('Y'); // Tahun berjalan

        // Data dari tbs_pengajuan
            // Data dari tbs_pengajuan (status Approved saja)
            $tbsData = DB::table('tbs_pengajuan')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('status', 'Approve') // Filter hanya data yang di-approve
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

            // Data dari tbr_pengajuan (semua data yang ditambahkan)
            $tbrData = DB::table('tbr_pengajuan')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear) // Tidak memfilter status
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

            // Data dari tbc_pengajuan (status Approved saja)
            $tbcData = DB::table('tbc_pengajuan')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->where('status', 'Approve') // Filter hanya data yang di-approve
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

            // Pastikan setiap bulan (1-12) ada dalam dataset
            $tbsMonthlyData = array_map(function ($month) use ($tbsData) {
            return $tbsData[$month] ?? 0;
            }, range(1, 12));

            $tbrMonthlyData = array_map(function ($month) use ($tbrData) {
            return $tbrData[$month] ?? 0;
            }, range(1, 12));

            $tbcMonthlyData = array_map(function ($month) use ($tbcData) {
            return $tbcData[$month] ?? 0;
            }, range(1, 12));








            // Ambil data PengajuanSolder berdasarkan bulan
        $pengajuanSolder = PengajuanSolder::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
        ->whereYear('created_at', $currentYear)
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();

        // Ambil data PengajuanRawmat berdasarkan bulan
        $pengajuanRawmat = PengajuanRawmat::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Ambil data PengajuanChemical berdasarkan bulan
        $pengajuanChemical = PengajuanChemical::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
            ->whereYear('updated_at', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Menjamin setiap bulan ada data dan menjumlahkan total dari ketiga kategori
        $totalMonthlyData = array_map(function ($month) use ($pengajuanSolder, $pengajuanRawmat, $pengajuanChemical) {
            $solder = $pengajuanSolder[$month] ?? 0;
            $rawmat = $pengajuanRawmat[$month] ?? 0;
            $chemical = $pengajuanChemical[$month] ?? 0;
            return $solder + $rawmat + $chemical; // Menjumlahkan total pengajuan
        }, range(1, 12));

        $today = Carbon::today();

        // Query untuk data PengajuanSolder dengan status tertentu
        $pengajuanSolder = PengajuanSolder::whereDate('created_at', $today)
            ->whereIn('status', ['Pengajuan', 'Proses Analisa', 'Analisa Selesai', 'Review Hasil'])
            ->get();
    
        // Query untuk data PengajuanChemical dengan status tertentu
        $pengajuanChemical = PengajuanChemical::whereDate('created_at', $today)
            ->whereIn('status', ['Pengajuan', 'Proses Analisa', 'Analisa Selesai', 'Review Hasil'])
            ->get();
    

        // Return the view with the necessary data
        return view('dashboard', compact(
            'jumlahPegawai',
            'dataCounts',
            'tinstab',
            'chartData',
            'labels',
            'data',
            'jumlahApprovedHariIni',
            'jumlahApprovedChemicalHariIni',
            'jumlahRawmatHariIni',
            'totalMonthlyData',
            'pengajuanSolder',
            'pengajuanChemical',
            'tbsMonthlyData', 'tbrMonthlyData', 'tbcMonthlyData'
            
        ));
    }
    

 
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
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
}
