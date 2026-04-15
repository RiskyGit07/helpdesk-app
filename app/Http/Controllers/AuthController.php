<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form login
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    // Proses login (menggunakan username yang berisi NIM/NIK/NIP)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }
        
        return back()->withErrors([
            'username' => 'NIM/NIK/NIP atau password salah.',
        ])->onlyInput('username');
    }
    
    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    
    // Tampilkan form register
    public function showRegisterForm()
    {
        return view('auth.register');
    }
    
    // Proses register - redirect ke login (TIDAK LANGSUNG LOGIN)
    public function register(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:mahasiswa,pegawai,asn',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            
            // Validasi berdasarkan role
            'nim' => 'required_if:role,mahasiswa|string|unique:users,nim|nullable',
            'nik' => 'required_if:role,pegawai|string|unique:users,nik|nullable',
            'nip' => 'required_if:role,asn|string|unique:users,nip|nullable',
        ]);
        
        // Tentukan username berdasarkan role (gunakan NIM/NIK/NIP)
        $username = '';
        if ($validated['role'] == 'mahasiswa') {
            $username = $request->nim;
        } elseif ($validated['role'] == 'pegawai') {
            $username = $request->nik;
        } elseif ($validated['role'] == 'asn') {
            $username = $request->nip;
        }
        
        // Siapkan data untuk disimpan
        $userData = [
            'username' => $username,  // Username diisi NIM/NIK/NIP
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'user_type' => 'user',
            'role' => $validated['role'],
        ];
        
        // Tambahkan NIM/NIK/NIP sesuai role (untuk kolom tersendiri)
        if ($validated['role'] == 'mahasiswa') {
            $userData['nim'] = $request->nim;
        } elseif ($validated['role'] == 'pegawai') {
            $userData['nik'] = $request->nik;
        } elseif ($validated['role'] == 'asn') {
            $userData['nip'] = $request->nip;
        }
        
        // Set default value untuk field yang wajib di database
        $userData['gender'] = 'male';
        $userData['birth_date'] = now();
        $userData['phone'] = '-';
        $userData['faculty'] = '-';
        $userData['address'] = '-';
        
        // Simpan user ke database
        User::create($userData);
        
        // Redirect ke halaman login dengan pesan sukses
        return redirect('/login')->with('success', 'Akun berhasil dibuat! Silakan login dengan NIM/NIK/NIP dan password Anda.');
    }
}