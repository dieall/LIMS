<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataThermo;
use App\Models\ThermoData;
use App\Models\User;
use Carbon\Carbon;

class DataThermoController extends Controller
{
    // Menampilkan data Thermo
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');
        $pageSize = $request->get('page_size', 10);
    
        $query = DataThermo::query(); // Removed eager loading of user relation
    
        // Filter berdasarkan waktu
        if ($filter === 'today') {
            $query->whereDate('tgl', Carbon::today());
        } elseif ($filter === 'this_month') {
            $query->whereMonth('tgl', Carbon::now()->month)
                  ->whereYear('tgl', Carbon::now()->year);
        }
    
        // Ambil data sesuai dengan filter dan jumlah data per halaman
        $datathermo = $query->orderBy('tgl', 'DESC')
                            ->orderBy('waktu', 'DESC')
                            ->paginate($pageSize);
    
        // Menambahkan filter dan page_size ke pagination links
        $datathermo->appends([
            'filter' => $filter,
            'page_size' => $pageSize,
        ]);
    
        return view('datathermo.index', compact('datathermo', 'filter', 'pageSize'));
    }

    // Menampilkan form untuk membuat data Thermo baru
    public function create()
    {
        // Optional: Get users for name suggestions
        $users = User::where('level', 'Operator Lab')->get();
    
        // Get thermodata - FIXED: removed orderBy('nama_lokasi')
        $thermodata = ThermoData::all();
    
        return view('datathermo.create', compact('users', 'thermodata'));
    }
    
    // Menyimpan data Thermo baru
    public function store(Request $request)
    {
        // Validasi data input - changed user_id to nama
        $validated = $request->validate([
            'tgl' => 'required|date_format:Y-m-d',
            'waktu' => 'required|date_format:H:i',
            'nama_thermo' => 'required|array',
            'suhu' => 'required|array',
            'kelembapan' => 'required|array',
            'nama' => 'required|string|max:100', // Changed from user_id
        ]);
    
        try {
            // Membuat instance baru dari model datathermo
            $datathermo = new DataThermo();
        
            // Menyimpan data - changed user_id to nama
            $datathermo->nama = $validated['nama'];
            $datathermo->nama_thermo = json_encode($validated['nama_thermo']);
            $datathermo->suhu = json_encode($validated['suhu']);
            $datathermo->kelembapan = json_encode($validated['kelembapan']);
        
            // Menyimpan data tambahan
            $datathermo->tgl = $validated['tgl'];
            $datathermo->waktu = $validated['waktu'];
        
            // Menyimpan data ke database
            $datathermo->save();
        
            return redirect()->route('datathermo')->with('success', 'Data thermohygrometer berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan data: ' . $e->getMessage())->withInput();
        }
    }

    // Menampilkan detail data Thermo
    public function show($id)
    {
        try {
            // Ambil data thermo berdasarkan ID - removed user relation
            $datathermo = DataThermo::findOrFail($id);
        
            // Decode JSON fields dengan error handling
            try {
                $nama_thermo = json_decode($datathermo->nama_thermo, true);
                $suhu = json_decode($datathermo->suhu, true);
                $kelembapan = json_decode($datathermo->kelembapan, true);
                
                $nama_thermo = is_array($nama_thermo) ? $nama_thermo : [];
                $suhu = is_array($suhu) ? $suhu : [];
                $kelembapan = is_array($kelembapan) ? $kelembapan : [];
            } catch (\Exception $e) {
                return redirect()->route('datathermo')
                    ->with('error', 'Data thermohygrometer tidak valid: ' . $e->getMessage());
            }
        
            // Menentukan panjang maksimal array
            $maxLength = max(count($nama_thermo), count($suhu), count($kelembapan));
            
            if ($maxLength === 0) {
                return redirect()->route('datathermo')
                    ->with('error', 'Data pengukuran thermohygrometer kosong atau tidak valid.');
            }
        
            // Mengirimkan data ke view
            return view('datathermo.show', compact('datathermo', 'nama_thermo', 'suhu', 'kelembapan', 'maxLength'));
        } catch (\Exception $e) {
            return redirect()->route('datathermo')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    // Menampilkan form untuk mengedit data Thermo
    public function edit($id)
    {
        try {
            // Removed user relation
            $dataThermo = DataThermo::findOrFail($id);
            
            // Still getting users for dropdown suggestions (optional)
            $users = User::where('level', 'Operator Lab')->get();
            
            return view('datathermo.edit', compact('dataThermo', 'users'));
        } catch (\Exception $e) {
            return redirect()->route('datathermo')
                ->with('error', 'Data tidak ditemukan: ' . $e->getMessage());
        }
    }

    // Mengupdate data Thermo
    public function update(Request $request, $id)
    {
        // Validasi data input - changed user_id to nama
        $validated = $request->validate([
            'tgl' => 'required|date_format:Y-m-d',
            'waktu' => 'required|date_format:H:i',
            'nama_thermo' => 'required|array',
            'suhu' => 'required|array',
            'kelembapan' => 'required|array',
            'nama' => 'required|string|max:100', // Changed from user_id
        ]);

        try {
            $dataThermo = DataThermo::findOrFail($id);
            
            // Update data thermohygrometer - changed user_id to nama
            $dataThermo->nama = $validated['nama'];
            $dataThermo->tgl = $validated['tgl'];
            $dataThermo->waktu = $validated['waktu'];
            $dataThermo->nama_thermo = json_encode($validated['nama_thermo']);
            $dataThermo->suhu = json_encode($validated['suhu']);
            $dataThermo->kelembapan = json_encode($validated['kelembapan']);
            
            $dataThermo->save();

            return redirect()->route('datathermo')->with('success', 'Data thermohygrometer berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Menghapus data Thermo
    public function destroy($id)
    {
        try {
            $dataThermo = DataThermo::findOrFail($id);
            
            // Check permissions based on nama rather than user_id
            if (auth()->user()->level !== 'Admin' && auth()->user()->name !== $dataThermo->nama) {
                return redirect()->back()
                    ->with('error', 'Anda tidak memiliki izin untuk menghapus data ini.');
            }
            
            $dataThermo->delete();

            return redirect()->route('datathermo')->with('success', 'Data thermohygrometer berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
