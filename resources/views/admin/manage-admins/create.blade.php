@extends('layouts.admin')

@section('title', 'Tambah Admin')

@section('content')
<div class="card">
    <div class="card-header border-0 pt-8">
        <div class="d-flex align-items-center">
            <h3 class="card-title fw-bold fs-2 mb-0">Tambah Admin Baru</h3>
        </div>
    </div>
    
    <div class="card-body pt-0">
        <form method="POST" action="{{ route('admin.manage-admins.store') }}">
            @csrf
            
            <div class="row mb-6">
                <div class="col-md-6">
                    <label class="form-label required">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label required">Username</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                           value="{{ old('username') }}" required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-6">
                <div class="col-md-6">
                    <label class="form-label required">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label class="form-label required">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-6">
                <div class="col-md-6">
                    <label class="form-label required">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            
            <div class="alert alert-info d-flex align-items-center mb-6">
                <i class="ki-outline ki-information fs-2 me-3"></i>
                <div>
                    Admin baru akan memiliki akses penuh ke dashboard admin.
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