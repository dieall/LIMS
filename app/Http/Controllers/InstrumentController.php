<?php

namespace App\Http\Controllers;

use App\Models\Instrument;
use App\Models\User;
use App\Models\InstrumentData;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InstrumentController extends Controller
{
    // Menampilkan daftar instrumen
    public function index()
    {
        // Mengambil semua instrumen dari database
        $instruments = Instrument::with('user')->get(); // Eager loading relasi 'user'

        // Mengembalikan view dengan daftar instrumen
        return view('instrument.index', compact('instruments'));
    }

    public function show($id)
    {
        // Ambil data instrumen berdasarkan ID
        $instrument = Instrument::findOrFail($id);
    
        // Decode JSON fields
        $nama_instrument = json_decode($instrument->nama_instrument, true) ?? [];
        $kondisi = json_decode($instrument->kondisi, true) ?? [];
        $keterangan = json_decode($instrument->keterangan, true) ?? [];
    
        // Menentukan panjang maksimal dari array untuk memastikan loop berfungsi
        $maxLength = max(count($nama_instrument), count($kondisi), count($keterangan));
    
        // Mengirimkan data ke view
        return view('instrument.show', compact('instrument', 'nama_instrument', 'kondisi', 'keterangan', 'maxLength'));
    }
    



    public function create()
    {
        $instruments = InstrumentData::all();
        $users = User::all();
        $shift = $this->getShift(); // Dapatkan shift otomatis
    
        return view('instrument.create', compact('users', 'instruments', 'shift'));
    }
    
    private function getShift()
    {
        $hour = now()->hour;
    
        if ($hour >= 0 && $hour < 8) {
            return 'Shift 1';
        } elseif ($hour >= 8 && $hour < 16) {
            return 'Shift 2';
        } else {
            return 'Shift 3';
        }
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'nama_instrument' => 'required|array',
            'kondisi' => 'required|array',
            'keterangan' => 'nullable|array',
            'user_id' => 'required|exists:users,id',
            'shift' => 'required|string|max:255',
            'tgl' => 'required|date_format:Y-m-d',  // Validasi untuk tanggal
            'jam' => 'required|date_format:H:i',
        ]);
    
        // Membuat instance baru dari model Instrument
        $instrument = new Instrument();
    
        // Menyimpan data instrumen dan data tambahan
        $instrument->user_id = $request->input('user_id');
        $instrument->nama_instrument = json_encode($request->input('nama_instrument'));
        $instrument->kondisi = json_encode($request->input('kondisi'));
        $instrument->keterangan = json_encode($request->input('keterangan') ?? []);
    
        // Menyimpan data tambahan
        $instrument->shift = $request->input('shift');
        $instrument->tgl = Carbon::createFromFormat('Y-m-d', $request->input('tgl'))->format('Y-m-d'); // Convert to correct format
        $instrument->jam = $request->input('jam');
    
        // Menyimpan data ke database
        $instrument->save();
    
        // Redirect ke halaman daftar instrumen setelah data disimpan
        return redirect()->route('instrument.index')->with('success', 'Instrumen berhasil ditambahkan!');
    }
    
    
    
    
}
