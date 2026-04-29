@extends('layouts.admin')

@section('title', 'Kelola Admin')

@section('content')
<div class="card">
    <div class="card-header border-0 pt-8">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div>
                <h3 class="card-title fw-bold fs-2 mb-1">Kelola Admin</h3>
                <div class="text-muted fs-7">
                    <i class="ki-outline ki-user-tick"></i> Daftar semua admin helpdesk
                </div>
            </div>
            
            {{-- TOMBOL TAMBAH ADMIN HANYA UNTUK ADMIN UTAMA (ID=1) --}}
            @if(auth()->user()->id == 1)
                <a href="{{ route('admin.manage-admins.create') }}" class="btn btn-primary">
                    <i class="ki-outline ki-add-files"></i> Tambah Admin
                </a>
            @endif
        </div>
    </div>
    
    <div class="card-body pt-0">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
        
        <div class="table-responsive">
            <table class="table table-row-bordered gy-5">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $index => $admin)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ $admin->name }}
                            @if($admin->id == 1)
                                <span class="badge badge-danger ms-2">Admin Utama</span>
                            @endif
                            @if($admin->id == auth()->id())
                                <span class="badge badge-primary ms-2">Anda</span>
                            @endif
                        </td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->created_at->format('d/m/Y') }}</td>
                        <td>
                            {{-- TAMPILKAN EDIT & HAPUS HANYA UNTUK ADMIN UTAMA (ID=1) --}}
                            @if(auth()->user()->id == 1)
                                @if($admin->id != 1 && $admin->id != auth()->id())
                                    <a href="{{ route('admin.manage-admins.edit', $admin->id) }}" 
                                       class="btn btn-sm btn-light-primary">
                                        <i class="ki-outline ki-pencil"></i> Edit
                                    </a>
                                    
                                    <button type="button" 
                                            class="btn btn-sm btn-light-danger" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $admin->id }}">
                                        <i class="ki-outline ki-trash"></i> Hapus
                                    </button>
                                    
                                    <!-- Modal Hapus -->
                                    <div class="modal fade" id="deleteModal{{ $admin->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menghapus admin <strong>{{ $admin->name }}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('admin.manage-admins.destroy', $admin->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">Belum ada admin</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection