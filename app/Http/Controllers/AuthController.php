<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth/register');
    }

    public function registerSave(Request $request)
    {
        // Validasi data yang diterima dari formulir
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email', // Validasi email unik
            'password' => 'required|confirmed|min:8', // Pastikan password minimal 8 karakter
            'tgl_lahir' => 'required|date',
            'alamat' => 'required|string|max:255', // Validasi alamat
            'departement' => 'required|string|max:255', // Validasi departement
            'jabatan' => 'required|string|max:255', // Validasi jabatan
        ])->validate();

        // Buat pengguna baru dengan menyertakan tgl_lahir, alamat, departement, dan jabatan
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tgl_lahir' => $request->tgl_lahir, // Menyertakan tgl_lahir
            'alamat' => $request->alamat, // Menyertakan alamat
            'departement' => $request->departement, // Menyertakan departement
            'jabatan' => $request->jabatan, // Menyertakan jabatan
            'level' => 'Internal Costumer' // Pastikan ini sesuai dengan kebutuhan
        ]);

        return redirect()->route('login')->with('success', 'Registrasi Telah Berhasil !!!, Silahkan Login'); // Menambahkan pesan sukses
    }

    public function login()
    {
        return view('auth/login');
    }

    public function loginAction(Request $request)
    {
        // Validasi data yang diterima dari formulir login
        Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ])->validate();

        // Coba untuk login
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => trans('Email atau password yang Anda masukkan salah.')
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
  
        return redirect('/');
    }
 
    public function profile()
    {
        return view('profile');
    }

    
}
