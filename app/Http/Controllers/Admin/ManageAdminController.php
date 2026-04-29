<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageAdminController extends Controller
{
    // Halaman daftar admin (SEMUA ADMIN BISA AKSES)
    public function index()
    {
        $admins = User::where('user_type', 'admin')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.manage-admins.index', compact('admins'));
    }
    
    // Halaman tambah admin (HANYA ADMIN UTAMA)
    public function create()
    {
        return view('admin.manage-admins.create');
    }
    
    // Simpan admin baru (HANYA ADMIN UTAMA)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'user_type' => 'admin',
        ]);

        return redirect()->route('admin.manage-admins.index')
            ->with('success', 'Admin baru berhasil ditambahkan');
    }
    
    // Halaman edit admin (HANYA ADMIN UTAMA)
    public function edit($id)
    {
        // Admin utama tidak bisa diedit
        if ($id == 1) {
            return redirect()->route('admin.manage-admins.index')
                ->with('warning', 'Admin utama tidak dapat diedit.');
        }
        
        // Tidak bisa edit diri sendiri
        if (auth()->id() == $id) {
            return redirect()->route('admin.manage-admins.index')
                ->with('warning', 'Anda tidak dapat mengedit akun sendiri.');
        }
        
        $admin = User::findOrFail($id);
        return view('admin.manage-admins.edit', compact('admin'));
    }
    
    // Update admin (HANYA ADMIN UTAMA)
    public function update(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|confirmed',
        ]);
        
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $admin->update($data);
        
        return redirect()->route('admin.manage-admins.index')
            ->with('success', 'Data admin berhasil diupdate');
    }   
    
    // Hapus admin (HANYA ADMIN UTAMA)
    public function destroy($id)
    {
        // Admin utama tidak bisa dihapus
        if ($id == 1) {
            return redirect()->back()
                ->with('warning', 'Admin utama tidak dapat dihapus.');
        }
        
        // Tidak bisa hapus diri sendiri
        if (auth()->id() == $id) {
            return redirect()->back()
                ->with('warning', 'Anda tidak dapat menghapus akun sendiri.');
        }
        
        $admin = User::findOrFail($id);
        $admin->delete();
        
        return redirect()->route('admin.manage-admins.index')
            ->with('success', 'Admin berhasil dihapus');
    }
}