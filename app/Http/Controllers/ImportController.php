<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PengajuanSolder;
use App\Models\PengajuanChemical;
use App\Models\PengajuanRawmat;
use Carbon\Carbon;

class ImportController extends Controller
{
    public function index()
    {
        return view('import.index');
    }

    /**
     * Export Pengajuan Solder to Excel.
     */


    public function exportPengajuanSolder(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        
        // Filter data berdasarkan tanggal
        $query = PengajuanSolder::query();
        if ($startDate && $endDate) {
            $query->whereBetween('tgl', [$startDate, $endDate]);
        }
        
        $data = $query->select([
            'id', 'nama', 'tgl', 'tipe_solder', 'batch', 'audit_trail', 'jam_masuk', 'created_at', 'updated_at',
            'id_category', 'sn', 'ag', 'cu', 'pb', 'sb', 'zn', 'fe', 'as', 'ni', 'bi', 'cd', 'ai', 'pe', 'ga', 'status',
            'previous_status', 'previous_jam_masuk'
        ])->get();
        
        $dateToday = Carbon::now()->format('Y-m-d'); // Format tanggal saat ini
        
        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;
    
            public function __construct($data)
            {
                $this->data = $data;
            }
    
            public function collection()
            {
                return $this->data;
            }
    
            public function headings(): array
            {
                return [
                    'ID', 'Nama', 'Tanggal', 'Tipe Solder', 'Batch', 'Audit Trail', 'Jam Masuk', 'Created At', 'Updated At',
                    'ID Category', 'SN', 'AG', 'CU', 'PB', 'SB', 'ZN', 'FE', 'AS', 'NI', 'BI', 'CD', 'AI', 'PE', 'GA', 'Status',
                    'Previous Status', 'Previous Jam Masuk'
                ];
            }
        }, 'Data_Solder_' . $dateToday . '.xlsx');
    }
    
    
    /**
     * Export Pengajuan Chemical to Excel with date filtering.
     */
    public function exportPengajuanChemical(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        
        $query = PengajuanChemical::query();
        if ($startDate && $endDate) {
            $query->whereBetween('tgl', [$startDate, $endDate]);
        }
        
        $data = $query->select([
            'id', 'nama_chemical', 'nama', 'tgl', 'jam_masuk', 'batch', 'desc', 'status', 'clarity', 'transmission', 'ape',
            'dimet', 'trime', 'tin', 'solid', 'ri', 'sg', 'acid', 'sulfur', 'water', 'mono', 'yellow', 'eh', 'visco', 'pt',
            'moisture', 'cloride', 'spec', 'densi', 'created_at', 'updated_at', 'orang'
        ])->get();
        
        $dateToday = Carbon::now()->format('Y-m-d'); // Format tanggal saat ini
        
        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;
    
            public function __construct($data)
            {
                $this->data = $data;
            }
    
            public function collection()
            {
                return $this->data;
            }
    
            public function headings(): array
            {
                return [
                    'ID', 'Nama Chemical', 'Nama', 'Tanggal', 'Jam Masuk', 'Batch', 'Deskripsi', 'Status', 'Clarity', 'Transmission',
                    'APE', 'Dimet', 'Trime', 'Tin', 'Solid', 'RI', 'SG', 'Acid', 'Sulfur', 'Water', 'Mono', 'Yellow', 'EH', 'Visco',
                    'PT', 'Moisture', 'cloride', 'Spec', 'Densi', 'Created At', 'Updated At', 'Orang'
                ];
            }
        }, 'Data_Chemical_' . $dateToday . '.xlsx');
    }
    

 


    public function exportPengajuanRawmat(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        
        $query = PengajuanRawmat::query();
        if ($startDate && $endDate) {
            $query->whereBetween('tgl', [$startDate, $endDate]);
        }
        
        $data = $query->select([
            'id', 'nama', 'supplier', 'spesifikasi', 'satuan', 'coa', 'result', 'tgl', 'created_at', 'updated_at'
        ])->get();
        
        $dateToday = Carbon::now()->format('Y-m-d'); // Format tanggal saat ini
        
        return Excel::download(new class($data) implements \Maatwebsite\Excel\Concerns\FromCollection, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;
    
            public function __construct($data)
            {
                $this->data = $data;
            }
    
            public function collection()
            {
                return $this->data;
            }
    
            public function headings(): array
            {
                return [
                    'ID', 'Nama', 'Supplier', 'Spesifikasi', 'Satuan', 'COA', 'Result', 'Tanggal', 'Created At', 'Updated At'
                ];
            }
        }, 'Data_Rawmat_' . $dateToday . '.xlsx');
    }
    
    
}
