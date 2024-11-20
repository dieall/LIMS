<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::orderBy('created_at', 'DESC')->get();
  
        return view('user.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create($request->all());
 
        return redirect()->route('user')->with('success', 'User added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
  
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       
    }

   
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
  
        $user->delete();
  
        return redirect()->route('user')->with('success', 'User deleted successfully');
    }

    public function countPegawai()
    {
        $jumlahPegawai = User::count();
        return response()->json(['jumlahPegawai' => $jumlahPegawai]);
    }
}
