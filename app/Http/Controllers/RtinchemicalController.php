<?php

namespace App\Http\Controllers;

use App\Models\Rtinchemical;
use Illuminate\Http\Request;

class RtinchemicalController extends Controller
{
    public function index()
    {
        $rtinchemical = Rtinchemical::orderBy('created_at', 'ASC')->get();

        return view('rtinchemical.index', compact('rtinchemical'));
    }
    public function create()
    {
        return view('rtinchemical.create');
    }
  

    public function store(Request $request)
    {
        Rtinchemical::create($request->all());
 
        return redirect()->route('rtinchemical')->with('success', 'Raw Mat Tin-Chemical added successfully');
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
