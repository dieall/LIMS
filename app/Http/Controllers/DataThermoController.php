<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataThermo;
use App\Models\ThermoData;
use App\Models\User;
use carbon\Carbon;


class DataThermoController extends Controller
{
    // Menampilkan data Thermo
    public function index(request $request)
    {
        $filter = $request->get('filter', 'all'); // Default filter: 'all'
        $pageSize = $request->get('page_size', 10); // Default jumlah data per halaman: 10
    
        $query = DataThermo::query(); // Mulai query
    
        // Filter berdasarkan waktu
        if ($filter === 'today') {
            $query->whereDate('created_at', Carbon::today()); // Data hari ini
        } elseif ($filter === 'this_month') {
            // Filter berdasarkan bulan dan tahun saat ini
            $query->whereMonth('created_at', Carbon::now()->month)
                  ->whereYear('created_at', Carbon::now()->year); // Data bulan ini
        }
    
        // Ambil data sesuai dengan filter dan jumlah data per halaman
        $datathermo = $query->orderBy('created_at', 'ASC') // Urutkan berdasarkan tanggal
                              ->paginate($pageSize); // Paginasi
    
        // Menambahkan filter dan page_size ke pagination links
        $datathermo->appends([
            'filter' => $filter,
            'page_size' => $pageSize,
        ]);
        
        $datathermo = DataThermo::all();
        return view('datathermo.index', compact('datathermo'));
    }

    // Menampilkan form untuk membuat data Thermo baru
    public function create()
    {
        // Ambil pengguna berdasarkan level tertentu
        $users = User::where('level', 'Operator Lab')->get(); // Mengambil pengguna dengan level 'operator_lab'
    
        // Ambil data thermodata
        $thermodata = ThermoData::all();
    
        // Kirimkan data ke view
        return view('datathermo.create', compact('users', 'thermodata'));
    }
    

   
    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'tgl' => 'required|date_format:Y-m-d',  // Validasi untuk tanggal
            'waktu' => 'required|date_format:H:i',
            'nama_thermo' => 'required|array',
            'suhu' => 'required|array',
            'kelembapan' => 'nullable|array',
            'user_id' => 'required|exists:users,id',
        ]);
    
        // Membuat instance baru dari model datathermo
        $datathermo = new DataThermo();
    
        // Menyimpan data instrumen dan data tambahan
        $datathermo->user_id = $request->input('user_id');
        $datathermo->nama_thermo = json_encode($request->input('nama_thermo')); // Menggunakan json_encode untuk array
        $datathermo->suhu = json_encode($request->input('suhu')); // Menggunakan json_encode untuk array suhu
        $datathermo->kelembapan = json_encode($request->input('kelembapan') ?? []); // Menggunakan json_encode untuk array kelembapan
    
        // Menyimpan data tambahan
        $datathermo->tgl = Carbon::createFromFormat('Y-m-d', $request->input('tgl'))->format('Y-m-d'); // Convert to correct format
        $datathermo->waktu = $request->input('waktu');
    
        // Menyimpan data ke database
        $datathermo->save();
    
        // Redirect ke halaman daftar instrumen setelah data disimpan
        return redirect()->route('datathermo')->with('success', 'DataThermo berhasil ditambahkan!');
    }
    

    // Menampilkan detail data Thermo
    public function show($id)
    {
        // Ambil data instrumen berdasarkan ID
        $datathermo = DataThermo::findOrFail($id);
    
        // Decode JSON fields
        $nama_thermo = json_decode($datathermo->nama_thermo, true) ?? [];
        $suhu = json_decode($datathermo->suhu, true) ?? [];
        $kelembapan = json_decode($datathermo->kelembapan, true) ?? [];
    
        // Menentukan panjang maksimal dari array untuk memastikan loop berfungsi
        $maxLength = max(count($nama_thermo), count($suhu), count($kelembapan));
    
        // Mengirimkan data ke view
        return view('datathermo.show', compact('datathermo', 'nama_thermo', 'suhu', 'kelembapan', 'maxLength'));
    }

    // Menampilkan form untuk mengedit data Thermo
    public function edit($id)
    {
        $dataThermo = DataThermo::findOrFail($id);
        return view('datathermo.edit', compact('dataThermo'));
    }

    // Mengupdate data Thermo
    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl' => 'required|date',
            'waktu' => 'required|time',
            'nama_thermo' => 'required|string|max:255',
            'suhu' => 'required|string|max:25',
            'kelembapan' => 'required|string|max:25',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $dataThermo = DataThermo::findOrFail($id);
        $dataThermo->update([
            'tgl' => $request->tgl,
            'waktu' => $request->waktu,
            'nama_thermo' => $request->nama_thermo,
            'suhu' => $request->suhu,
            'kelembapan' => $request->kelembapan,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('datathermo.index')->with('success', 'Data Thermo berhasil diupdate');
    }

    // Menghapus data Thermo
    public function destroy($id)
    {
        $dataThermo = DataThermo::findOrFail($id);
        $dataThermo->delete();

        return redirect()->route('datathermo.index')->with('success', 'Data Thermo berhasil dihapus');
    }
}
