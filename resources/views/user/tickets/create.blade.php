@extends('layouts.user')

@section('title', 'Buat Pengaduan Baru')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Buat Pengaduan Baru</h3>
        </div>
        <form action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <!-- Informasi Pelapor (Readonly dari data user) -->
                <div class="mb-10">
                    <h4 class="mb-5">Informasi Pelapor</h4>
                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <label class="form-label required">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly disabled>
                        </div>
                        
                        <div class="col-md-6 mb-5">
                            <label class="form-label required">Email</label>
                            <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly disabled>
                        </div>
                        
                        <div class="col-md-6 mb-5">
                            <label class="form-label required">Nomor Identifikasi</label>
                            <div class="input-group">
                                <span class="input-group-text">#</span>
                                <input type="text" class="form-control" 
                                    value="{{ Auth::user()->username }}" 
                                    readonly disabled>
                            </div>
                            <div class="form-text text-primary">
                                @if(Auth::user()->user_type == 'mahasiswa') (NIM) 
                                @elseif(Auth::user()->user_type == 'pegawai_asn') (NIP) 
                                @elseif(Auth::user()->user_type == 'pegawai_non_asn') (NIK) 
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-5">
                            <label class="form-label required">Fakultas</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->fakultas ?? '-' }}" readonly disabled>
                        </div>
                        
                        <div class="col-md-6 mb-5">
                            <label class="form-label required">Program Studi</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->prodi ?? '-' }}" readonly disabled>
                        </div>
                    </div>
                </div>

                <div class="separator my-5"></div>

                <!-- Detail Pengaduan -->
                <div class="mb-10">
                    <h4 class="mb-5">Detail Pengaduan</h4>

                    <div class="mb-5">
                        <label class="form-label required">Judul Pengaduan</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Masukkan judul pengaduan..." required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="form-label required">Deskripsi Lengkap</label>
                        <textarea name="description" rows="8" class="form-control @error('description') is-invalid @enderror" placeholder="Jelaskan secara lengkap dan detail tentang pengaduan Anda..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label class="form-label">Unggah Gambar/Bukti (Opsional)</label>
                        <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror" accept="image/*,.pdf,.doc,.docx">
                        <div class="form-text">
                            <small>Format yang didukung: JPG, PNG, PDF, DOC, DOCX. Maksimal 5MB</small>
                        </div>
                        @error('attachment')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
                <a href="{{ route('user.tickets.index') }}" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection