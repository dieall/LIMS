<?php

namespace App\Exports;

use App\Models\Import;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ImportExport implements FromCollection, WithHeadings
{
    /**
     * Return a collection of data to be exported.
     */
    public function collection()
    {
        return Import::all(); // Ambil semua data dari model Import
    }

    /**
     * Return headings for the exported Excel file.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Created At',
            'Updated At',
        ];
    }
}
