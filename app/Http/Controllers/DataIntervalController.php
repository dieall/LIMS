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
            
            // Get status history for the selected month (semua status)
            $allStatusHistories = StatusHistory::where('user_id', $user_id)
                ->whereMonth('changed_at', $selectedMonth)
                ->orderBy('changed_at', 'asc')
                ->get();
            
            // Hitung interval antara Proses Analisa dan Analisa Selesai
            $this->calculateIntervals($allStatusHistories);
            
            // Filter untuk menampilkan hanya status selain Proses Analisa
            $statusHistories = $allStatusHistories->filter(function($data) {
                return $data->status !== 'Proses Analisa';
            });
            
            // Filter for solder and chemical data
            $solderData = $statusHistories->filter(function($data) {
                return $data->pengajuan_solder_id !== null;
            });
            
            $chemicalData = $statusHistories->filter(function($data) {
                return $data->pengajuan_chemical_id !== null;
            });
            
            // Calculate total interval time
            list($hours, $minutes) = $this->calculateTotalIntervalFromCompleted($statusHistories);
            
// Calculate average intervals by category
$solderCount = $solderData->count();
$chemicalCount = $chemicalData->count();
$totalSamples = $solderCount + $chemicalCount;

// Calculate average minutes per solder sample
$avgSolderMinutes = 0;
if ($solderCount > 0) {
    $solderMinutes = 0;
    foreach ($solderData as $data) {
        $solderMinutes += is_numeric($data->interval) ? floatval($data->interval) : 0;
    }
    $avgSolderMinutes = round($solderMinutes / $solderCount);
}

// Calculate average minutes per chemical sample
$avgChemicalMinutes = 0;
if ($chemicalCount > 0) {
    $chemicalMinutes = 0;
    foreach ($chemicalData as $data) {
        $chemicalMinutes += is_numeric($data->interval) ? floatval($data->interval) : 0;
    }
    $avgChemicalMinutes = round($chemicalMinutes / $chemicalCount);
}

// Calculate overall average minutes per sample
$avgOverallMinutes = 0;
if ($totalSamples > 0) {
    $totalMinutes = ($hours * 60) + $minutes;
    $avgOverallMinutes = round($totalMinutes / $totalSamples);
}

// Add averages to view data
return view('datainterval.show', compact(
    'user', 
    'solderData', 
    'chemicalData', 
    'hours', 
    'minutes', 
    'selectedMonth',
    'avgSolderMinutes',
    'avgChemicalMinutes',
    'avgOverallMinutes'
));

        } catch (\Exception $e) {
            return redirect()->route('datainterval')->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Calculate intervals between 'Proses Analisa' and 'Analisa Selesai' statuses.
     *
     * @param \Illuminate\Database\Eloquent\Collection $statusHistories
     */
    private function calculateIntervals(Collection $statusHistories)
    {
        // Group process and completion pairs
        $analysisPairs = [];
        $currentStart = null;
        
        foreach ($statusHistories as $history) {
            if ($history->status === 'Proses Analisa') {
                $currentStart = $history;
            } elseif (in_array($history->status, ['Analisa Selesai', 'Selesai Analisa']) && $currentStart) {
                $startTime = Carbon::parse($currentStart->changed_at);
                $endTime = Carbon::parse($history->changed_at);
                $interval = $startTime->diffInMinutes($endTime);
                
                // Assign interval to the 'Analisa Selesai' record
                $history->interval = $interval;
                
                $currentStart = null;
            }
        }
    }
    
    /**
     * Calculate total interval from completed analysis records.
     *
     * @param \Illuminate\Database\Eloquent\Collection $statusHistories
     * @return array [hours, minutes]
     */
    private function calculateTotalIntervalFromCompleted(Collection $statusHistories)
    {
        $totalMinutes = 0;
        
        // Sum up intervals from all completed analysis records
        foreach ($statusHistories as $history) {
            if (in_array($history->status, ['Analisa Selesai', 'Selesai Analisa']) && is_numeric($history->interval)) {
                $totalMinutes += floatval($history->interval);
            }
        }
        
        // Convert to hours and minutes
        $hours = floor($totalMinutes / 60);
        $minutes = round($totalMinutes % 60);
        
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
        $minutes = round($totalMinutes % 60);
        
        return [$hours, $minutes];
    }
}
