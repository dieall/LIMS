<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataInterval;
use App\Models\User;
use App\Models\StatusHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataIntervalExport;
class DataIntervalController extends Controller
{
    public function index()
    {
        // Mengambil user_id yang unik tanpa pengurutan, hanya untuk user dengan level 'Operator Lab'
        $datainterval = DataInterval::select('user_id')
            ->distinct()
            ->whereHas('user', function ($query) {
                $query->where('level', 'Operator Lab'); // Filter berdasarkan level "Operator Lab"
            })
            ->get();
    
        return view('datainterval.index', compact('datainterval'));
    }
    
    
    
    public function export($user_id, Request $request)
    {
        // Ambil bulan yang dipilih, default ke bulan ini jika tidak ada filter
        $selectedMonth = $request->input('month', Carbon::now()->format('m'));

        return Excel::download(new DataIntervalExport($user_id, $selectedMonth), 'data_interval_'.$user_id.'_'.$selectedMonth.'.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('datainterval.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DataInterval::create($request->all());
 
        return redirect()->route('datainterval')->with('success', 'datainterval added successfully');
    }


    public function show($user_id, Request $request)
    {
        // Ambil bulan yang dipilih, default ke bulan ini jika tidak ada filter
        $selectedMonth = $request->input('month', Carbon::now()->format('m')); // Default bulan saat ini

        // Ambil data berdasarkan user_id dan bulan yang dipilih
        $datainterval = StatusHistory::where('user_id', $user_id)
            ->whereIn('status', ['Proses Analisa', 'Analisa Selesai'])
            ->whereMonth('changed_at', $selectedMonth) // Filter berdasarkan bulan
            ->orderBy('changed_at', 'asc')
            ->get();

        // Ambil nama user berdasarkan user_id
        $user = User::findOrFail($user_id);

        // Pisahkan data untuk solder dan chemical
        $solderData = $datainterval->filter(function($data) {
            return $data->pengajuan_solder_id !== null;
        });

        $chemicalData = $datainterval->filter(function($data) {
            return $data->pengajuan_chemical_id !== null;
        });

        // Variabel untuk menyimpan total durasi dalam menit
        $totalIntervalMinutes = 0;
        $lastProcessAnalisa = null;

        // Hitung total interval
        foreach ($datainterval as $data) {
            if ($data->status === 'Proses Analisa') {
                $lastProcessAnalisa = $data;
            }

            if ($data->status === 'Analisa Selesai' && $lastProcessAnalisa) {
                $startTime = Carbon::parse($lastProcessAnalisa->changed_at);
                $endTime = Carbon::parse($data->changed_at);
                $interval = $startTime->diffInMinutes($endTime);
                $totalIntervalMinutes += $interval;

                $lastProcessAnalisa = null;
            }
        }

        // Hitung jam dan menit
        $hours = floor($totalIntervalMinutes / 60);
        $minutes = $totalIntervalMinutes % 60;

        // Kirim data ke view
        return view('datainterval.show', compact('datainterval', 'user', 'solderData', 'chemicalData', 'hours', 'minutes', 'selectedMonth'));
    }
    
    
    
    

    public function edit(string $id)
    {
        $datainterval = DataInterval::findOrFail($id);
  
        return view('datainterval.edit', compact('datainterval'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $datainterval = DataInterval::findOrFail($id);
  
        $datainterval->update($request->all());
  
        return redirect()->route('datainterval')->with('success', 'datainterval updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datainterval = DataInterval::findOrFail($id);
  
        $datainterval->delete();
  
        return redirect()->route('datainterval')->with('success', 'datainterval deleted successfully');
    }
}
