<!DOCTYPE html>
<html lang="id">
<head>
    <base href="/"/>
    <title>Login - Helpdesk App</title>
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
            <!-- Form Login di Tengah -->
            <div class="d-flex flex-column flex-center w-100 p-10">
                <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                    
                    <!-- Form -->
                    <div class="py-20">
                        <form class="form w-100" method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <!-- TAMPILKAN PESAN SUKSES (dari register) -->
                            @if(session('success'))
                                <div class="alert alert-success mb-5">
                                    {{ session('success') }}
                                </div>
                            @endif
                            
                            <!-- TAMPILKAN PESAN ERROR (dari login gagal) -->
                            @if($errors->any())
                                <div class="alert alert-danger mb-5">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <div class="card-body">
                                <div class="text-center mb-10">
                                    <h1 class="text-dark mb-3 fs-3x">Masuk</h1>
                                    <div class="text-gray-400 fw-semibold fs-6">Akses dashboard helpdesk Anda</div>
                                </div>
                                
                                <!-- Username (NIM/NIK/NIP) -->
                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="NIM / NIK / NIP" name="username" value="{{ old('username') }}" 
                                        class="form-control form-control-solid @error('username') is-invalid @enderror" required />
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Password -->
                                <div class="fv-row mb-7">
                                    <input type="password" placeholder="Password" name="password" 
                                           class="form-control form-control-solid @error('password') is-invalid @enderror" required />
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <!-- Tombol Login (FULL WIDTH) -->
                                <div class="d-grid mb-5">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <span class="indicator-label">Masuk</span>
                                        <span class="indicator-progress">
                                            Tunggu sebentar...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>
                                </div>
                                
                                <!-- Link ke Register (DI BAWAH TOMBOL) -->
                                <div class="text-center">
                                    <span class="text-gray-400 fw-semibold fs-6">Belum punya akun?</span>
                                    <a href="{{ route('register') }}" class="link-primary fw-semibold fs-6 ms-1">Daftar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Footer -->
                    <div class="m-0">
                        <div class="text-center text-gray-500 fs-7">
                            &copy; {{ date('Y') }} Helpdesk App. All rights reserved.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script>var hostUrl = "{{ asset('assets') }}/";</script>
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>
</html>