<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PengajuanSolder;
use App\Models\CategorySolder;
use App\Models\Sncu;
use App\Models\Snagcu;
use App\Models\Snag;
use App\Models\Tin;


class PengajuanSolderController extends Controller
{

    public function index()
    {
        $pengajuansolder = PengajuanSolder::orderBy('created_at', 'ASC')->get();

        return view('pengajuansolder.index', compact('pengajuansolder'));
    }

    public function create()
    {
        $categorysolder = CategorySolder::all();
        $tbs_sncu   = Sncu::all(); 
        $tbs_snagcu = Snagcu::all(); 
        $tbs_snag   = Snag::all();
        $tbs_tin    = Tin::all();
    
    
        return view('pengajuansolder.create', compact('categorysolder', 'tbs_sncu','tbs_snagcu','tbs_snag','tbs_tin'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama' => 'required|string',
            'tgl' => 'required|date',
            'tipe_solder' => 'required|string',
            'batch' => 'required|string',
            'audit_trail' => 'required|string',
            'jam_masuk' => 'required|string',
            'id_category' => 'required|exists:category_solder,id_category',
             // Periksa nama kolom
        ]);
    
        // Membuat instansi baru Transaksi
        $pengajuansolder = new PengajuanSolder([
            'nama' => $validatedData['nama'],
            'tgl' => $validatedData['tgl'],
            'tipe_solder' => $validatedData['tipe_solder'],
            'batch' => $validatedData['batch'],
            'audit_trail' => $validatedData['audit_trail'],
            'jam_masuk' => $validatedData['jam_masuk'],
            'id_category' => $validatedData['id_category'],

        ]);
    
        // Menyimpan data transaksi
        $pengajuansolder->save();
    
        // Redirect setelah berhasil menyimpan
        return redirect()->route('pengajuansolder.index')->with('success', 'Data Pengajuan Solder berhasil disimpan.');
    }

    public function show($id)
    {
        $pengajuansolder = PengajuanSolder::findOrFail($id); // Data pengajuan berdasarkan ID
        $categorysolder = CategorySolder::all();
        $tbs_sncu = Sncu::all();
        $tbs_snagcu = Snagcu::all();
        $tbs_snag = Snag::all();
        $tbs_tin = Tin::all();
    
        return view('pengajuansolder.show', compact(
            'pengajuansolder', 
            'categorysolder', 
            'tbs_sncu', 
            'tbs_snagcu', 
            'tbs_snag', 
            'tbs_tin'
        ));
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
