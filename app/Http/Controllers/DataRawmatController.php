<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataRawmat;

class DataRawmatController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->get('page_size', 50);

        $query = DataRawmat::query();

        $datarawmat = $query->orderBy('created_at', 'ASC')->paginate($pageSize);

        return view('datarawmat.index', compact('datarawmat', 'pageSize'));
    }

    public function create()
    {
        $fieldGroups = [
            'Basic Information' => ['nama', 'nama_rawmat'],
            'Chemical Properties' => ['sn', 'ag', 'cu', 'pb', 'sb', 'zn', 'as', 'ni', 'bi', 'cd', 'ai', 'pe', 'ga'],
            'Physical Properties' => ['purity', 'purity_tmac', 'appreance', 'sg', 'visual', 'color'],
            'Additional Properties' => ['fe_amo', 'si_amo', 'sh', 'acid', 'ri', 'free', 'ph', 'fe', 'si', 'sulfur', 'water', 'acidity', 'lodine','densi','clarity','apha']
        ];

        return view('datarawmat.create', compact('fieldGroups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        DataRawmat::create($request->all());

        return redirect()->route('datarawmat')->with('success', 'Data Rawmat added successfully');
    }

    public function show($id)
    {
        $dataRawmat = DataRawmat::findOrFail($id);

        $fieldGroups = [
            'Basic Information' => ['nama', 'nama_rawmat'],
            'Chemical Properties' => ['sn', 'ag', 'cu', 'pb', 'sb', 'zn', 'as', 'ni', 'bi', 'cd', 'ai', 'pe', 'ga'],
            'Physical Properties' => ['purity', 'purity_tmac', 'appreance', 'sg', 'visual', 'color'],
            'Additional Properties' => ['fe_amo', 'si_amo', 'sh', 'acid', 'ri', 'free', 'ph', 'fe', 'si', 'sulfur', 'water', 'acidity', 'lodine','densi','clarity','apha']
        ];

        return view('datarawmat.show', compact('dataRawmat', 'fieldGroups'));
    }

    public function edit($id)
    {
        $dataRawmat = DataRawmat::findOrFail($id);

        $fieldGroups = [
            'Basic Information' => ['nama', 'nama_rawmat'],
            'Chemical Properties' => ['sn', 'ag', 'cu', 'pb', 'sb', 'zn', 'as', 'ni', 'bi', 'cd', 'ai', 'pe', 'ga'],
            'Physical Properties' => ['purity', 'purity_tmac', 'appreance', 'sg', 'visual', 'color'],
            'Additional Properties' => ['fe_amo', 'si_amo', 'sh', 'acid', 'ri', 'free', 'ph', 'fe', 'si', 'sulfur', 'water', 'acidity', 'lodine','densi','clarity','apha']
        ];

        return view('datarawmat.edit', compact('dataRawmat', 'fieldGroups'));
    }

    public function update(Request $request, $id)
    {
        $dataRawmat = DataRawmat::findOrFail($id);

        $validatedData = $request->validate([
            'nama' => 'required|string|max:100',
        ]);

        $dataRawmat->update($request->all());

        return redirect()->route('datarawmat')->with('success', 'Data updated successfully!');
    }

    public function destroy($id)
    {
        $dataRawmat = DataRawmat::findOrFail($id);

        $dataRawmat->delete();

        return redirect()->route('datarawmat')->with('success', 'Data deleted successfully!');
    }
}
