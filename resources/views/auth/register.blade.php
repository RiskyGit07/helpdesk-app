<!DOCTYPE html>
<html lang="id">
<head>
    <base href="/"/>
    <title>Daftar - Helpdesk App</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.ico') }}" />
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    
    <!-- Stylesheets -->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="app-blank">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <div class="d-flex flex-column flex-center w-100 p-10">
                <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                    
                    <div class="py-20">
                        <form class="form w-100" method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            @if ($errors->any())
                                <div class="alert alert-danger mb-5">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            @if (session('success'))
                                <div class="alert alert-success mb-5">
                                    {{ session('success') }}
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <div class="text-center mb-10">
                                    <h1 class="text-dark mb-3 fs-3x">Daftar</h1>
                                    <div class="text-gray-400 fw-semibold fs-6">Buat akun helpdesk Anda</div>
                                </div>
                                
                                <!-- Pilih Role -->
                                <div class="fv-row mb-8">
                                    <label class="required fw-semibold fs-6 mb-2">Pendaftaran Sebagai</label>
                                    <select name="user_type" id="role_select" class="form-control form-control-solid @error('user_type') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Pilih Role --</option>
                                        <option value="mahasiswa">Mahasiswa</option>
                                        <option value="pegawai_asn">Pegawai ASN</option>
                                        <option value="pegawai_non_asn">Pegawai Non ASN</option>
                                    </select>
                                    @error('user_type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Username (tetap Username) -->
                                <div class="fv-row mb-8">
                                    <label class="required fw-semibold fs-6 mb-2">Username</label>
                                    <input type="text" placeholder=" Masukkan Username" name="username" id="username_input" value="{{ old('username') }}" 
                                        class="form-control form-control-solid @error('username') is-invalid @enderror" required />
                                    <div class="form-text" id="username_hint"></div>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Nama Lengkap -->
                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="Nama Lengkap" name="name" value="{{ old('name') }}" 
                                        class="form-control form-control-solid @error('name') is-invalid @enderror" required />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Email -->
                                <div class="fv-row mb-8">
                                    <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" 
                                        class="form-control form-control-solid @error('email') is-invalid @enderror" required />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Password -->
                                <div class="fv-row mb-8">
                                    <input type="password" placeholder="Password (minimal 6 karakter)" name="password" 
                                        class="form-control form-control-solid @error('password') is-invalid @enderror" required />
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Confirm Password -->
                                <div class="fv-row mb-8">
                                    <input type="password" placeholder="Konfirmasi Password" name="password_confirmation" 
                                        class="form-control form-control-solid" required />
                                </div>
                                
                                <div class="d-grid mb-5">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <span class="indicator-label">Daftar</span>
                                        <span class="indicator-progress">
                                            Tunggu sebentar...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                                
                                <div class="text-center">
                                    <span class="text-gray-400 fw-semibold fs-6">Sudah punya akun?</span>
                                    <a href="{{ route('login') }}" class="link-primary fw-semibold fs-6 ms-1">Masuk</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <div class="m-0">
                        <div class="text-center text-gray-500 fs-7">
                            &copy; {{ date('Y') }} Helpdesk App. All rights reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>var hostUrl = "{{ asset('assets') }}/";</script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role_select');
            const usernameHint = document.getElementById('username_hint');

            function updateFields() {
                const selectedRole = roleSelect.value;
                
                if (selectedRole === 'mahasiswa') {
                    usernameHint.innerHTML = 'Masukkan NIM (Nomor Induk Mahasiswa) sebagai Username';
                } else if (selectedRole === 'pegawai_asn') {
                    usernameHint.innerHTML = 'Masukkan NIP (Nomor Induk Pegawai ASN) sebagai Username';
                } else if (selectedRole === 'pegawai_non_asn') {
                    usernameHint.innerHTML = 'Masukkan NIK (Nomor Induk Kependudukan) sebagai Username';
                } else {
                    usernameHint.innerHTML = '';
                }
            }

            roleSelect.addEventListener('change', updateFields);
            updateFields();
        });
    </script>
</body>
</html>