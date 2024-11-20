<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Finish;
class FinishController extends Controller
{
    public function index()
    {
        $finish = Finish::orderBy('created_at', 'ASC')->get();
  
        return view('finish.index', compact('finish'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('finish.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Finish::create($request->all());
 
        return redirect()->route('finish')->with('success', 'finish Good added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $finish = Finish::findOrFail($id);
  
        return view('finish.show', compact('finish'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $finish = Finish::findOrFail($id);
  
        return view('finish.edit', compact('finish'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $finish = Finish::findOrFail($id);
  
        $finish->update($request->all());
  
        return redirect()->route('finish')->with('success', 'Finish updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $finish = Finish::findOrFail($id);
  
        $finish->delete();
  
        return redirect()->route('finish')->with('success', 'Finish deleted successfully');
    }
}
