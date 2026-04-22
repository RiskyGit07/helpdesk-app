@extends('layouts.user')

@section('title', 'Lengkapi Profil')

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title text-white">Lengkapi Data Profil</h3>
        </div>
        <div class="card-body">
            @if(session('warning'))
                <div class="alert alert-warning">{{ session('warning') }}</div>
            @endif
            
            <div class="alert alert-info mb-5">
                <i class="fas fa-info-circle me-2"></i>
                Silakan lengkapi data profil Anda terlebih dahulu sebelum mengakses halaman lainnya.
            </div>

            <form method="POST" action="{{ route('user.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label required">Jenis Kelamin</label>
                        <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="male" {{ old('gender', Auth::user()->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="female" {{ old('gender', Auth::user()->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" 
                               value="{{ old('birth_date', Auth::user()->birth_date) }}">
                        @error('birth_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label required">Nomor HP</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               placeholder="Contoh: 081234567890" value="{{ old('phone', Auth::user()->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label required">Alamat</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                  rows="2" placeholder="Masukkan alamat lengkap" required>{{ old('address', Auth::user()->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Simpan Profil
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection