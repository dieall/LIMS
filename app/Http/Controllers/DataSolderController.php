<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataSolder;

class DataSolderController extends Controller
{
 
    public function index()
    {
        $datasolder = DataSolder::orderBy('created_at', 'ASC')->get();
  
        return view('datasolder.index', compact('datasolder'));
    }


    public function create()
    
    {
        return view('datasolder.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DataSolder::create($request->all());
 
        return redirect()->route('datasolder')->with('success', 'Data Solder added successfully');
    }


    public function show(string $id)
    {
        //
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
