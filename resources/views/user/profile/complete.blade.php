@extends('layouts.user')

@section('title', 'Lengkapi Profil Admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h3 class="card-title text-white mb-0">Lengkapi Data Profil</h3>
                    <p class="text-white-50 mt-2 mb-0">Silakan isi data diri Anda dengan lengkap</p>
                </div>
                <div class="card-body p-5">
                    @if(session('warning'))
                        <div class="alert alert-warning">{{ session('warning') }}</div>
                    @endif

                    <div class="alert alert-info mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        Harap lengkapi data profil Anda terlebih dahulu untuk dapat mengakses dashboard admin.
                    </div>

                    <form method="POST" action="{{ route('user.profile.complete.store') }}">
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label required">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">Fakultas</label>
                                <input type="text" name="fakultas" id="fakultas"
                                    class="form-control @error('fakultas') is-invalid @enderror"
                                    value="{{ old('fakultas', Auth::user()->fakultas) }}">
                                @error('fakultas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" id="prodi_label">Program Studi</label>
                                <input type="text" name="prodi" id="prodi"
                                    class="form-control @error('prodi') is-invalid @enderror"
                                    value="{{ old('prodi', Auth::user()->prodi) }}">
                                @error('prodi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4" id="jabatan_field">
                            <div class="col-md-6">
                                <label class="form-label" id="jabatan_label">Jabatan</label>
                                <input type="text" name="position" id="position"
                                    class="form-control @error('position') is-invalid @enderror"
                                    value="{{ old('position', Auth::user()->position) }}">
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

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
                                <label class="form-label required">Tanggal Lahir</label>
                                <input type="date" name="birth_date" class="form-control @error('birth_date') is-invalid @enderror" 
                                       value="{{ old('birth_date', Auth::user()->birth_date) }}" required>
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">Nomor Telepon</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', Auth::user()->phone) }}" placeholder="Contoh: 081234567890" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label required">Alamat Rumah</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                          rows="3" placeholder="Masukkan alamat lengkap" required>{{ old('address', Auth::user()->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg py-3">
                                <i class="fas fa-save me-2"></i> Simpan & Lanjutkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const userType = "{{ Auth::user()->user_type }}";

    const fakultas = document.getElementById('fakultas');
    const prodi = document.getElementById('prodi');
    const position = document.getElementById('position');

    const jabatanField = document.getElementById('jabatan_field');
    const jabatanLabel = document.getElementById('jabatan_label');
    const prodiLabel = document.getElementById('prodi_label');

    if (userType === 'mahasiswa') {
        // Mahasiswa
        fakultas.required = true;
        prodi.required = true;

        jabatanField.style.display = 'none';
        position.required = false;

        prodiLabel.classList.add('required');

    } else {
        // Pegawai ASN / Non ASN
        fakultas.required = true;
        prodi.required = false;

        jabatanField.style.display = 'block';
        position.required = true;

        jabatanLabel.classList.add('required');
    }
});
</script>
@endsection