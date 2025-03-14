<table style="width: 100%; border-collapse: collapse; border: 1px solid black; text-align: center;">
    <thead>
        <tr>
            <th rowspan="2" style="border: 1px solid black; padding: 5px;">Composition</th>
            <th rowspan="2" style="border: 1px solid black; padding: 5px;">Method</th>
            <th rowspan="2" style="border: 1px solid black; padding: 5px;">Specification</th>
            @foreach ($DataSolder as $solder)
                <th colspan="1" style="border: 1px solid black; padding: 5px;">sss{{ $solder->lot_no }}<br>{{ $solder->created_at->format('d-M-y') }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($fields as $fieldKey => $fieldLabel)
            <tr>
                <td style="border: 1px solid black; padding: 5px;">{{ $fieldLabel }}</td>
                <td style="border: 1px solid black; padding: 5px;">OES</td>
                <td style="border: 1px solid black; padding: 5px;">{{ $pengajuansolder->DataSolder->$fieldKey ?? '-' }}</td>
                @foreach ($DataSolder as $solder)
                    <td style="border: 1px solid black; padding: 5px;">{{ $solder->$fieldKey ?? '-' }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" style="border: 1px solid black; padding: 5px;">Weight (Kg)</td>
            @foreach ($DataSolder as $solder)
                <td style="border: 1px solid black; padding: 5px;">{{ $solder->weight ?? '960 Kg' }}</td>
            @endforeach
        </tr>
    </tfoot>
</table>
