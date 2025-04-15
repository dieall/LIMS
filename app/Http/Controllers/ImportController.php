<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PengajuanSolder;
use App\Models\PengajuanChemical;
use App\Models\PengajuanRawmat;
use App\Models\Instrument;
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
            'previous_status', 'previous_jam_masuk', 'deskripsi'
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
                    'ID Category', 'Sn', 'Ag', 'Cu', 'Pb', 'Sb', 'Zn', 'Fe', 'As', 'Ni', 'Bi', 'Cd', 'Ai', 'Pe', 'Ga', 'Status',
                    'Previous Status', 'Previous Jam Masuk', 'Deskripsi'
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
    
        // Filter berdasarkan tanggal jika ada
        if ($startDate && $endDate) {
            $query->whereBetween('tgl', [$startDate, $endDate]);
        }
    
        // Mengambil data dari database
        $data = $query->select(['id', 'nama', 'supplier', 'spesifikasi', 'satuan', 'coa', 'result', 'tgl', 'created_at', 'updated_at'])->get();
    
        // Format data untuk diekspor ke Excel
        $formattedData = [];
        foreach ($data as $row) {
            // Pastikan nama dan supplier tidak perlu di-decode jika itu bukan array
            $nama = $row->nama; // Jika disimpan sebagai string, langsung ambil
            $supplier = $row->supplier; // Jika disimpan sebagai string, langsung ambil
            
            // Pastikan spesifikasi, satuan, coa, dan result adalah array
            $spesifikasi = json_decode($row->spesifikasi, true);
            $satuan = json_decode($row->satuan, true);
            $coa = json_decode($row->coa, true);
            $result = json_decode($row->result, true);
    
            // Menentukan panjang array yang maksimal di antara spesifikasi, satuan, coa, result
            $maxLength = max(count($spesifikasi), count($satuan), count($coa), count($result));
    
            // Menyusun data baris-baris untuk setiap kombinasi spesifikasi, satuan, coa, dan result
            for ($i = 0; $i < $maxLength; $i++) {
                $formattedData[] = [
                    $nama, // Nama tetap sama untuk setiap baris
                    $supplier, // Supplier tetap sama untuk setiap baris
                    $spesifikasi[$i] ?? '', // Jika tidak ada, beri nilai kosong
                    $satuan[$i] ?? '', // Jika tidak ada, beri nilai kosong
                    $coa[$i] ?? '', // Jika tidak ada, beri nilai kosong
                    $result[$i] ?? '', // Jika tidak ada, beri nilai kosong
                ];
            }
        }
    
        // Format tanggal untuk nama file
        $dateToday = Carbon::now()->format('Y-m-d'); 
    
        // Menghasilkan file Excel
        return Excel::download(new class($formattedData) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
            private $data;
    
            public function __construct($data)
            {
                $this->data = $data;
            }
    
            public function array(): array
            {
                return $this->data;
            }
    
            public function headings(): array
            {
                return ['Nama', 'Supplier', 'Spesifikasi', 'Satuan', 'COA', 'Result'];
            }
        }, 'Data_Rawmat_' . $dateToday . '.xlsx');
    }

    

        


    
        public function exportInstrument(Request $request)
        {
            $startDate = $request->query('start_date');
            $endDate = $request->query('end_date');
            
            // Query untuk mengambil data instrumen
            $query = Instrument::query();
            
            // Filter berdasarkan tanggal jika ada
            if ($startDate && $endDate) {
                $query->whereBetween('tgl', [$startDate, $endDate]);
            }
            
            // Mengambil data dari database dengan relasi 'user'
            $data = $query->with('user') // Relasi untuk mendapatkan nama user
                          ->select(['id', 'nama_instrument', 'kondisi', 'keterangan', 'shift', 'tgl', 'jam', 'user_id', 'created_at', 'updated_at'])
                          ->get();
            
            // Menentukan instrumen yang akan dijadikan tab
            $instruments = [
                'Rotavapor 1', 'Rotavapor 2', 'Rotavapor 3', 'Automatic Titration', 'Viscometer', 'Furnace', 'Lemari Asam', 'Karl Fischer',
                'Neraca Massa 220 gram', 'Timbangan 8 Kg', 'Arc Spark-Bruker', 'Arc Spark-SpectroLab', 'Hydraulic Press', 'Oven', 
                'Two Roll Mill Manual', 'Two Roll Mill Automatic', 'Rheometer Brabender', 'ED XRF', 'NMR', 'FT IR', 'Spectrometer UV-Vis',
                'GC Perkin', 'GC Shimadzu', 'Densitymeter', 'Refractometer', 'ICP-OES', 'Tap Density', 'Thermohygrometer 1', 
                'Thermohygrometer 2', 'Thermohygrometer 3', 'Thermohygrometer 4', 'Thermohygrometer 5', 'Thermohygrometer 6', 
                'Thermohygrometer 7', 'Thermohygrometer 8', 'Thermohygrometer 9', 'Thermohygrometer 10'
            ];
            
            // Format data untuk diekspor ke Excel
            $formattedData = [];
            foreach ($instruments as $instrument) {
                // Filter data berdasarkan instrumen
                $instrumentData = $data->filter(function ($item) use ($instrument) {
                    return in_array($instrument, json_decode($item->nama_instrument, true));
                });
        
                // Siapkan data untuk setiap instrumen
                $instrumentRows = [];
                foreach ($instrumentData as $row) {
                    // Decode JSON fields
                    $nama_instrument = json_decode($row->nama_instrument, true);
                    $kondisi = json_decode($row->kondisi, true);
                    $keterangan = json_decode($row->keterangan, true);
                    
                    // Tentukan panjang array maksimal
                    $maxLength = max(count($nama_instrument), count($kondisi), count($keterangan));
                    
                    // Selaraskan panjang array agar konsisten
                    $nama_instrument = array_pad($nama_instrument, $maxLength, '    ');
                    $kondisi = array_pad($kondisi, $maxLength, '');
                    $keterangan = array_pad($keterangan, $maxLength, '');
                    
                    // Menyusun data baris-baris untuk setiap kombinasi nama_instrument, kondisi, dan keterangan
                    for ($i = 0; $i < $maxLength; $i++) {
                        $rowData = [];
                        $rowData['Nama Instrument'] = $nama_instrument[$i] ?? '';
                        $rowData['Kondisi'] = $kondisi[$i] ?? '';
                        $rowData['Keterangan'] = $keterangan[$i] ?? '';
                        $rowData['Shift'] = $row->shift;
                        $rowData['Tanggal'] = \Carbon\Carbon::parse($row->tgl)->format('d-m-Y');
                        $rowData['Jam'] = \Carbon\Carbon::parse($row->jam)->format('H:i');
                        $rowData['Nama User'] = $row->user->name ?? '';
                        
                        // Tambahkan ke baris instrumen
                        $instrumentRows[] = $rowData;
                    }
                }
                
                // Menyimpan data per instrumen ke dalam formattedData
                $formattedData[$instrument] = $instrumentRows;
            }
            
            // Format tanggal untuk nama file
            $dateToday = Carbon::now()->format('Y-m-d'); 
            
            // Menghasilkan file Excel dengan worksheet per instrumen
            return Excel::download(new class($formattedData) implements \Maatwebsite\Excel\Concerns\WithMultipleSheets, \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings {
                private $data;
            
                public function __construct($data)
                {
                    $this->data = $data;
                }
            
                public function array(): array
                {
                    // Menyusun data yang akan di-export
                    return $this->data;
                }
            
                public function headings(): array
                {
                    // Header yang akan muncul di setiap sheet
                    return ['Nama Instrument', 'Kondisi', 'Keterangan', 'Shift', 'Tanggal', 'Jam', 'Nama User'];
                }
            
                public function sheets(): array
                {
                    $sheets = [];
                    foreach ($this->data as $instrumentName => $rows) {
                        $sheets[] = new class($rows, $instrumentName) implements \Maatwebsite\Excel\Concerns\FromArray, \Maatwebsite\Excel\Concerns\WithHeadings, \Maatwebsite\Excel\Concerns\WithTitle {
                            private $data;
                            private $instrumentName;
        
                            public function __construct($data, $instrumentName)
                            {
                                $this->data = $data;
                                $this->instrumentName = $instrumentName;
                            }
        
                            public function array(): array
                            {
                                return $this->data;
                            }
        
                            public function headings(): array
                            {
                                return ['Nama Instrument', 'Kondisi', 'Keterangan', 'Shift', 'Tanggal', 'Jam', 'Nama User'];
                            }
        
                            public function title(): string
                            {
                                return $this->instrumentName;
                            }
                        };
                    }
                    return $sheets;
                }
            }, 'Data_Instrument_' . $dateToday . '.xlsx');
        }
        
    }

