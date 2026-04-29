@extends('layouts.admin')

@section('title', 'Edit Admin')

@section('content')
<div class="card">
    <div class="card-header border-0 pt-8">
        <div class="d-flex align-items-center">
            <a href="{{ route('admin.manage-admins.index') }}" class="btn btn-sm btn-light me-4">
                <i class="ki-outline ki-left"></i> Kembali
            </a>
            <h3 class="card-title fw-bold fs-2 mb-0">Edit Admin</h3>
        </div>
    </div>
    
    <div class="card-body pt-0">
        <form method="POST" action="{{ route('admin.manage-admins.update', $admin->id) }}">
            @csrf
            @method('PUT')
            
            <div class="row mb-6">
                <div class="col-md-6">
                    <label class="form-label required">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name', $admin->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label required">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $admin->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-6">
                <div class="col-md-6">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                    <small class="text-muted">Kosongkan jika tidak ingin mengganti</small>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="ki-outline ki-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.manage-admins.index') }}" class="btn btn-light">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection