<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tinchem;
use App\Models\Category;
use App\Models\Transaksi;

use Carbon\Carbon;


use DB;

class TinchemController extends Controller
{

    public function index()
    {
        // Mengambil semua data tinchem
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
        $dataCounts = [
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
        $labels = array_keys($dataCounts);  // Mendapatkan label ('TC-191', 'TC-185 VN', dll.)
        $data = array_column($dataCounts, 'total');  // Mendapatkan data (jumlah total)

        // Mengirimkan semua variabel ke view
        return view('tinchem.index', compact('tinchem', 'labels', 'data'));
    }


    public function create()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('tinchem.create', compact('transaksi', 'category'));
    }

    public function create1()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('tinchem.create1', compact('transaksi', 'category'));
    }

    public function create2()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('tinchem.create2', compact('transaksi', 'category'));
    }


    public function create3()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('tinchem.create3', compact('transaksi', 'category'));
    }



    public function create4()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('tinchem.create4', compact('transaksi', 'category'));
    }


    public function create5()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('tinchem.create5', compact('transaksi', 'category'));
    }

    public function create6()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('tinchem.create6', compact('transaksi', 'category'));
    }

    public function create7()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('tinchem.create7', compact('transaksi', 'category'));
    }

    public function create8()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();
    
        return view('tinchem.create8', compact('transaksi', 'category'));
    }
    public function create9()
    {
        $today = Carbon::today(); // Mendapatkan tanggal hari ini
        $category = Category::all(); 
    
        // Ambil data transaksi hanya untuk tanggal hari ini dan urutkan berdasarkan 'nama'
        $transaksi = Transaksi::with('category')
            ->whereDate('tgl', $today)
            ->orderBy('nama', 'ASC') // Urutkan berdasarkan 'nama' secara ascending (A-Z)
            ->get();

            
    
        return view('tinchem.create9', compact('transaksi', 'category'));
    }































































































    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'id' => 'required|string',
            'id_category' => 'required|exists:category,id_category',
            'id_transaksi' => 'required|exists:transaksi,id',
            'tgl' => 'nullable|string',
            'clarity' => 'nullable|string',
            'trans' => 'nullable|string',
            'tin' => 'nullable|string',
            'ri' => 'nullable|string',
            'sg' => 'nullable|string',
            'acid' => 'nullable|string',
            'sulfur' => 'nullable|string',
            'water' => 'nullable|string',
            'mono' => 'nullable|string',
            'spec' => 'nullable|string',
            'den' => 'nullable|string',
            'yellow' => 'nullable|string',


        ]);
    
        // Insert data ke tabel tb_tinstab
        $tinchem = new Tinchem([
            'id' => $validatedData['id'],
            'id_category' => $validatedData['id_category'],
            'id_transaksi' => $validatedData['id_transaksi'],
            'tgl' => $validatedData['tgl'],
            'clarity' => $validatedData['clarity'],
            'trans' => $validatedData['trans'],
            'tin' => $validatedData['tin'],
            'ri' => $validatedData['ri'],
            'sg' => $validatedData['sg'],
            'acid' => $validatedData['acid'],
            'sulfur' => $validatedData['sulfur'],
            'water' => $validatedData['water'],
            'mono' => $validatedData['mono'],
            'spec' => $validatedData['spec'],
            'den' => $validatedData['den'],
            'yellow' => $validatedData['yellow'],

        ]);
    
        $tinchem->save(); // Menyimpan data ke dalam tabel
            
        // Redirect ke halaman tinstab dengan pesan sukses
        return redirect()->route('tinchem')->with('success', 'Tinchem added successfully');
    }

    public function show(string $idx)
    {
        $tinchem = Tinchem::findOrFail($idx);
  
        return view('tinchem.show', compact('tinchem'));
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
