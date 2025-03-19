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
use App\Models\statusHistory;
use DB;
use Carbon\Carbon; // Tambahkan Carbon untuk manipulasi tanggal

class DashboardController extends Controller
{
    public function index(Request $request)
    {



    $pengajuansolder = StatusHistory::whereNotNull('pengajuan_solder_id')
        ->whereDate('changed_at', Carbon::today())
        ->orderBy('changed_at', 'desc')
        ->with('user') // Pastikan ada relasi ke tabel users
        ->get();

    $pengajuanchemical = StatusHistory::whereNotNull('pengajuan_chemical_id')
        ->whereDate('changed_at', Carbon::today())
        ->orderBy('changed_at', 'desc')
        ->with('user') // Pastikan ada relasi ke tabel users
        ->get();


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
    
        // Query data bulanan dari tbs_pengajuan
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
        // Ambil semua data StatusHistory dengan eager loading untuk relasi 'user', 'pengajuanSolder', dan 'pengajuanChemical'
        $histories = StatusHistory::orderBy('changed_at', 'desc')
        ->with('user', 'pengajuanSolder', 'pengajuanChemical') // Memastikan relasi dengan pengajuanSolder dan pengajuanChemical
        ->get();  // Ambil data status history
    
    // Kelompokkan berdasarkan nama pengguna
    $groupedHistories = $histories->filter(function($history) {
        return $history->user->level === 'Operator Lab'; // Pastikan role adalah "Operator Lab"
    })->groupBy(function($history) {
        return $history->user->name; // Kelompokkan berdasarkan nama pengguna
    });
    
    // Memasukkan data dari pengajuanSolder dan pengajuanChemical
    $histories->map(function($history) use ($histories) {
        // Menambahkan interval waktu antara status yang relevan
        if ($history->status === 'Proses Analisa') {
            $startTime = Carbon::parse($history->changed_at);
            
            $endTime = $histories->first(function($historyItem) use ($history) {
                return $historyItem->status === 'Analisa Selesai' 
                    && $historyItem->user->id === $history->user->id;
            });
            
            if ($endTime) {
                $endTime = Carbon::parse($endTime->changed_at); // Waktu selesai
                $interval = $startTime->diffInMinutes($endTime); // Hitung selisih waktu dalam menit
                $history->interval = $interval; // Simpan interval ke dalam objek history
            } else {
                $history->interval = 'N/A'; // Jika tidak ada status "Analisa Selesai"
            }
        }
    
        // Menambahkan data dari pengajuanSolder
        if ($history->pengajuanSolder) {
            $pengajuanSolder = $history->pengajuanSolder;
            $history->batch = $pengajuanSolder ? $pengajuanSolder->batch : 'N/A';
            $history->tipe_solder = $pengajuanSolder ? $pengajuanSolder->tipe_solder : 'N/A';
        }
    
        // Menambahkan data dari pengajuanChemical
        if ($history->pengajuanChemical) {
            $pengajuanChemical = $history->pengajuanChemical;
            $history->id = $pengajuanChemical ? $pengajuanChemical->id : 'N/A';
        }
    
        return $history;
    });
    
    // Menghitung total interval dan sampel untuk setiap user
    $groupedHistories->transform(function($histories) {
        $totalInterval = 0;
        $totalSampel = 0;
        
        $histories = $histories->sortBy('changed_at');  // Urutkan berdasarkan waktu
    
        $histories->each(function($history) use (&$totalInterval, &$totalSampel, $histories) {
            // Hanya hitung interval antara "Proses Analisa" dan "Analisa Selesai"
            if ($history->status === 'Proses Analisa') {
                $analisaSelesai = $histories->firstWhere(function($historyItem) use ($history) {
                    return $historyItem->status === 'Analisa Selesai' 
                        && Carbon::parse($historyItem->changed_at)->gt(Carbon::parse($history->changed_at)); // Pastikan Analisa Selesai setelah Proses Analisa
                });
    
                if ($analisaSelesai) {
                    $startTime = Carbon::parse($history->changed_at);
                    $endTime = Carbon::parse($analisaSelesai->changed_at);
                    $diffInMinutes = $startTime->diffInMinutes($endTime);
                    $totalInterval += $diffInMinutes;
    
                    $history->interval = $diffInMinutes . ' menit'; // Menyimpan interval
                }
            }
    
            // Menghitung jumlah sampel hanya dari status "Analisa Selesai"
            if ($history->status === 'Analisa Selesai') {
                $totalSampel++; // Tambah satu sampel untuk setiap "Analisa Selesai"
            }
        });
    
        // Mengonversi total interval menjadi format jam dan menit
        $totalHours = floor($totalInterval / 60); 
        $totalMinutes = $totalInterval % 60;      
    
        // Menyimpan total interval dalam format jam dan menit
        $histories->each(function($history) use ($totalHours, $totalMinutes, $totalSampel) {
            $history->totalInterval = $totalHours . ' Jam ' . $totalMinutes . ' Menit'; 
            $history->totalSampel = $totalSampel;
        });
    
        return $histories;
    });


   // Ambil data untuk pengajuanSolder dengan status Proses Analisa dan Analisa Selesai
    $historiesSolder = StatusHistory::whereNotNull('pengajuan_solder_id')
        ->whereIn('status', ['Proses Analisa', 'Analisa Selesai'])
        ->when($request->has('month'), function ($query) use ($request) {
            // Filter berdasarkan bulan yang dipilih
            $month = $request->input('month');
            return $query->whereMonth('changed_at', $month);  // Menyaring berdasarkan bulan
        })
        ->orderBy('changed_at', 'asc')
        ->with('user', 'pengajuanSolder') // Pastikan relasi dengan pengajuanSolder
        ->get();

    // Kelompokkan berdasarkan nama pengguna (user) untuk pengajuanSolder
    $groupedHistoriesSolder = $historiesSolder->filter(function ($history) {
        return $history->user->level === 'Operator Lab' && $history->pengajuanSolder;
    })->groupBy(function ($history) {
        return $history->user->name; // Kelompokkan berdasarkan nama pengguna
    });

    // Menghitung interval dan total sampel untuk setiap pengguna (hanya untuk pengajuanSolder)
    $groupedHistoriesSolder->transform(function ($histories) use ($request) {
        $totalInterval = 0;
        $totalSampel = 0;
        $month = $request->input('month'); // Ambil bulan yang dipilih

        $histories = $histories->sortBy('changed_at');  // Urutkan berdasarkan waktu

        $histories->each(function ($history) use (&$totalInterval, &$totalSampel, $histories, $month) {
            // Filter berdasarkan bulan yang dipilih
            if (Carbon::parse($history->changed_at)->month == $month) {
                // Hanya hitung interval antara "Proses Analisa" dan "Analisa Selesai"
                if ($history->status === 'Proses Analisa') {
                    $analisaSelesai = $histories->firstWhere(function ($historyItem) use ($history) {
                        return $historyItem->status === 'Analisa Selesai' 
                            && Carbon::parse($historyItem->changed_at)->gt(Carbon::parse($history->changed_at)); // Pastikan Analisa Selesai setelah Proses Analisa
                    });

                    if ($analisaSelesai) {
                        $startTime = Carbon::parse($history->changed_at);
                        $endTime = Carbon::parse($analisaSelesai->changed_at);
                        $diffInMinutes = $startTime->diffInMinutes($endTime);
                        $totalInterval += $diffInMinutes;

                        $history->interval = $diffInMinutes . ' menit'; // Menyimpan interval
                    }
                }

                // Menghitung jumlah sampel hanya dari status "Analisa Selesai"
                if ($history->status === 'Analisa Selesai') {
                    $totalSampel++; // Tambah satu sampel untuk setiap "Analisa Selesai"
                }
            }
        });

        // Mengonversi total interval menjadi format jam dan menit
        $totalHours = floor($totalInterval / 60); 
        $totalMinutes = $totalInterval % 60;      

        // Menyimpan total interval dalam format jam dan menit
        $histories->each(function ($history) use ($totalHours, $totalMinutes, $totalSampel) {
            $history->totalInterval = $totalHours . ' Jam ' . $totalMinutes . ' Menit';
            $history->totalSampel = $totalSampel;
        });

        return $histories;
    });




    // Ambil data untuk pengajuanChemical dengan status Proses Analisa dan Analisa Selesai
    $historiesChemical = StatusHistory::whereNotNull('pengajuan_chemical_id')
        ->whereIn('status', ['Proses Analisa', 'Analisa Selesai'])
        ->when($request->has('month'), function ($query) use ($request) {
            // Filter berdasarkan bulan yang dipilih
            $month = $request->input('month');
            return $query->whereMonth('changed_at', $month);  // Menyaring berdasarkan bulan
        })
        ->orderBy('changed_at', 'asc')
        ->with('user', 'pengajuanChemical') // Pastikan relasi dengan pengajuanChemical
        ->get();

    // Kelompokkan berdasarkan nama pengguna (user) untuk pengajuanChemical
    $groupedHistoriesChemical = $historiesChemical->filter(function ($history) {
        return $history->user->level === 'Operator Lab' && $history->pengajuanChemical;
    })->groupBy(function ($history) {
        return $history->user->name; // Kelompokkan berdasarkan nama pengguna
    });

    // Menghitung interval dan total sampel untuk setiap pengguna (hanya untuk pengajuanChemical)
    $groupedHistoriesChemical->transform(function ($histories) use ($request) {
        $totalInterval = 0;
        $totalSampel = 0;
        $month = $request->input('month'); // Ambil bulan yang dipilih

        $histories = $histories->sortBy('changed_at');  // Urutkan berdasarkan waktu

        $histories->each(function ($history) use (&$totalInterval, &$totalSampel, $histories, $month) {
            // Filter berdasarkan bulan yang dipilih
            if (Carbon::parse($history->changed_at)->month == $month) {
                // Hanya hitung interval antara "Proses Analisa" dan "Analisa Selesai"
                if ($history->status === 'Proses Analisa') {
                    $analisaSelesai = $histories->firstWhere(function ($historyItem) use ($history) {
                        return $historyItem->status === 'Analisa Selesai' 
                            && Carbon::parse($historyItem->changed_at)->gt(Carbon::parse($history->changed_at)); // Pastikan Analisa Selesai setelah Proses Analisa
                    });

                    if ($analisaSelesai) {
                        $startTime = Carbon::parse($history->changed_at);
                        $endTime = Carbon::parse($analisaSelesai->changed_at);
                        $diffInMinutes = $startTime->diffInMinutes($endTime);
                        $totalInterval += $diffInMinutes;

                        $history->interval = $diffInMinutes . ' menit'; // Menyimpan interval
                    }
                }

                // Menghitung jumlah sampel hanya dari status "Analisa Selesai"
                if ($history->status === 'Analisa Selesai') {
                    $totalSampel++; // Tambah satu sampel untuk setiap "Analisa Selesai"
                }
            }
        });

        // Mengonversi total interval menjadi format jam dan menit
        $totalHours = floor($totalInterval / 60); 
        $totalMinutes = $totalInterval % 60;      

        // Menyimpan total interval dalam format jam dan menit
        $histories->each(function ($history) use ($totalHours, $totalMinutes, $totalSampel) {
            $history->totalInterval = $totalHours . ' Jam ' . $totalMinutes . ' Menit';
            $history->totalSampel = $totalSampel;
        });

        return $histories;
    });

        

     $pengajuanSolderHistories = StatusHistory::whereNotNull('pengajuan_solder_id')
                ->whereDate('changed_at', Carbon::today())
                ->orderBy('changed_at', 'desc')
                ->with('user', 'pengajuanSolder') // Relasi dengan pengajuanSolder
                ->get();

        
        
        


// Data sudah dikelompokkan berdasarkan nama pengguna

        // Ambil pengajuan solder untuk menampilkan tipe_solder dan batch
        $pengajuanSolderDetails = PengajuanSolder::all(); // Ambil semua pengajuan solder yang relevan
     
            

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
            'tbsMonthlyData', 
            'tbrMonthlyData', 
            'tbcMonthlyData', 
            'histories',
            'groupedHistories',
            'pengajuanSolderDetails',
            'groupedHistoriesSolder',
            'groupedHistoriesChemical'// Mengirimkan groupedHistories ke view
        ));
        
    }
    
    public function showUserHistory($userName)
{
    // Ambil semua data history untuk pengguna berdasarkan nama
    $userHistories = StatusHistory::whereHas('user', function($query) use ($userName) {
        $query->where('name', $userName); // Filter berdasarkan nama pengguna
    })
    ->orderBy('changed_at', 'desc') // Urutkan berdasarkan waktu perubahan
    ->with('user', 'pengajuanSolder', 'pengajuanChemical') // Pastikan relasi dengan user dan pengajuan
    ->get();

    return view('dashboard', compact('userHistories', 'userName'));
}

 
}