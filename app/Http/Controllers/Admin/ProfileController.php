<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function edit()
    {
        return view('admin.profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'address' => $request->address,
            'position' => $request->position,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.profile')
                        ->with('success', 'Profil berhasil diupdate!');
    }

    // Halaman lengkapi profil untuk admin baru
    public function completeForm()
    {
        return view('admin.profile.complete');
    }

    // Proses simpan lengkapi profil admin baru
    public function completeStore(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'position' => 'required|string|max:255', // DIUBAH: jadi required
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'phone' => $request->phone,
            'address' => $request->address,
            'position' => $request->position,
            'profile_completed' => 1,
        ]);

        Auth::setUser($user->fresh());

        return redirect()->route('admin.dashboard')
                        ->with('success', 'Profil berhasil dilengkapi! Selamat datang di dashboard admin.');
    }
}