<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan Anda mengimpor model User
use App\Models\Tinstab;
use App\Models\Dmt;
use App\Models\Tinchem;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
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
    
        // Return the view with the necessary data
        return view('dashboard', compact('jumlahPegawai', 'dataCounts', 'tinstab','chartData','labels', 'data'));
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
