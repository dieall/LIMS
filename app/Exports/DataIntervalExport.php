<?php

namespace App\Exports;

use App\Models\StatusHistory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DataIntervalExport implements FromCollection, WithHeadings, WithMapping
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    // Mendapatkan data yang ingin diekspor
    public function collection()
    {
        // Ambil semua data yang memiliki status 'Proses Analisa' dan 'Analisa Selesai' untuk user tertentu
        return StatusHistory::where('user_id', $this->userId)
            ->whereIn('status', ['Proses Analisa', 'Analisa Selesai'])
            ->with('pengajuanSolder', 'pengajuanChemical') // Relasi dengan pengajuanSolder dan pengajuanChemical
            ->get();
    }

    // Menambahkan heading pada file Excel
    public function headings(): array
    {
        return [
            'No',
            'Status',
            'Interval',
            'Batch (Solder)',
            'Tipe Solder',
            'Nama Chemical',
            'Batch (Chemical)',
            'Changed At'
        ];
    }

    // Menentukan data per baris untuk ekspor
    public function map($data): array
    {
        return [
            // No urut
            $data->status === 'Proses Analisa' ? 1 : 2, // menampilkan 1 atau 2 berdasarkan statusnya
            $data->status,
            $data->interval . ' menit',
            $data->pengajuanSolder ? $data->pengajuanSolder->batch : null, // Menampilkan batch solder jika ada
            $data->pengajuanSolder ? $data->pengajuanSolder->tipe_solder : null, // Menampilkan tipe solder jika ada
            $data->pengajuanChemical ? $data->pengajuanChemical->nama_chemical : null, // Menampilkan nama chemical jika ada
            $data->pengajuanChemical ? $data->pengajuanChemical->batch : null, // Menampilkan batch chemical jika ada
            $data->changed_at,
        ];
    }
}
