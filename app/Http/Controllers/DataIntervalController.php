<?php

namespace App\Http\Controllers;

use App\Models\DataInterval;
use App\Models\User;
use App\Models\StatusHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataIntervalExport;
use Illuminate\Database\Eloquent\Collection;

class DataIntervalController extends Controller
{
    /**
     * Display a listing of all lab operator users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get unique user_ids for lab operators only
        $datainterval = StatusHistory::select('user_id')
            ->distinct()
            ->whereHas('user', function ($query) {
                $query->where('level', 'Operator Lab');
            })
            ->get();
    
        return view('datainterval.index', compact('datainterval'));
    }
    
    /**
     * Display detailed information for a specific user.
     *
     * @param int $user_id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function show($user_id, Request $request)
    {
        try {
            // Get the selected month (default to current month)
            $selectedMonth = $request->input('month', Carbon::now()->format('m'));
            
            // Fetch the user
            $user = User::findOrFail($user_id);
            
            // Get status history for the selected month
            $statusHistories = StatusHistory::where('user_id', $user_id)
                ->whereMonth('changed_at', $selectedMonth)
                ->orderBy('changed_at', 'asc')
                ->get();
            
            // Filter for solder and chemical data
            $solderData = $statusHistories->filter(function($data) {
                return $data->pengajuan_solder_id !== null;
            });
            
            $chemicalData = $statusHistories->filter(function($data) {
                return $data->pengajuan_chemical_id !== null;
            });
            
            // Calculate total interval time
            list($hours, $minutes) = $this->calculateTotalInterval($statusHistories);
            
            return view('datainterval.show', compact(
                'user', 
                'solderData', 
                'chemicalData', 
                'hours', 
                'minutes', 
                'selectedMonth'
            ));
            
        } catch (\Exception $e) {
            return redirect()->route('datainterval')->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Calculate total interval between 'Proses Analisa' and 'Analisa Selesai' statuses.
     *
     * @param \Illuminate\Database\Eloquent\Collection $statusHistories
     * @return array [hours, minutes]
     */
    private function calculateTotalInterval(Collection $statusHistories)
    {
        $totalMinutes = 0;
        $analysisPairs = [];
        $currentStart = null;
        
        // Group process and completion pairs
        foreach ($statusHistories as $history) {
            if ($history->status === 'Proses Analisa') {
                $currentStart = $history;
            } elseif ($history->status === 'Analisa Selesai' && $currentStart) {
                $analysisPairs[] = [
                    'start' => $currentStart,
                    'end' => $history
                ];
                $currentStart = null;
            }
        }
        
        // Calculate total minutes
        foreach ($analysisPairs as $pair) {
            $startTime = Carbon::parse($pair['start']->changed_at);
            $endTime = Carbon::parse($pair['end']->changed_at);
            $totalMinutes += $startTime->diffInMinutes($endTime);
        }
        
        // Convert to hours and minutes
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        
        return [$hours, $minutes];
    }
    
    /**
     * Export user activity data to Excel.
     *
     * @param int $user_id
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export($user_id, Request $request)
    {
        $selectedMonth = $request->input('month', Carbon::now()->format('m'));
        $fileName = 'data_interval_'.$user_id.'_'.$selectedMonth.'.xlsx';
        
        return Excel::download(new DataIntervalExport($user_id, $selectedMonth), $fileName);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('datainterval.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        DataInterval::create($request->all());
 
        return redirect()->route('datainterval')->with('success', 'Data interval berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(string $id)
    {
        $datainterval = DataInterval::findOrFail($id);
  
        return view('datainterval.edit', compact('datainterval'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $id)
    {
        $datainterval = DataInterval::findOrFail($id);
  
        $datainterval->update($request->all());
  
        return redirect()->route('datainterval')->with('success', 'Data interval berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(string $id)
    {
        $datainterval = DataInterval::findOrFail($id);
  
        $datainterval->delete();
  
        return redirect()->route('datainterval')->with('success', 'Data interval berhasil dihapus');
    }
}
