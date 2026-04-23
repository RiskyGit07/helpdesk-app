@extends('layouts.user')

@section('title', 'Profil Saya')

@section('content')
<div class="card mb-5 mb-xl-10">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap">
            <!--begin: Pic-->
            <div class="me-7 mb-4">
                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                    <img src="{{ asset('assets/media/avatars/300-1.jpg') }}" alt="image" />
                    <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                </div>
            </div>
            <!--end::Pic-->
            
            <!--begin::Info-->
            <div class="flex-grow-1">
                <!--begin::Title-->
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-2">
                            <h1 class="text-gray-900 fs-2 fw-bold me-1">{{ Auth::user()->name }}</h1>
                        </div>
                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                <i class="ki-outline ki-profile-circle fs-4 me-1"></i>{{ Auth::user()->user_type ?? 'Member' }}
                            </a>
                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                <i class="ki-outline ki-geolocation fs-4 me-1"></i>{{ Auth::user()->address ?? 'Alamat tidak diisi' }}
                            </a>
                            <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                <i class="ki-outline ki-sms fs-4"></i>{{ Auth::user()->email }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="d-flex my-4">
                        <a href="{{ route('user.profile.edit') }}" class="btn btn-primary">
                            <i class="ki-outline ki-pencil fs-3"></i> Edit Profil
                        </a>
                    </div>
                </div>
                <!--end::Title-->
                
                <!--begin::Stats-->
                <div class="d-flex flex-wrap flex-stack">
                    <div class="d-flex flex-column flex-grow-1 pe-8">
                        <div class="d-flex flex-wrap">
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="ki-outline ki-message-text-2 fs-3 text-primary me-2"></i>
                                    <div class="fs-2 fw-bold text-primary">{{ $totalTickets ?? 0 }}</div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-400">Total Pengaduan</div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <i class="ki-outline ki-check-circle fs-3 text-success me-2"></i>
                                    <div class="fs-2 fw-bold text-success">{{ $completedTickets ?? 0 }}</div>
                                </div>
                                <div class="fw-semibold fs-6 text-gray-400">Pengaduan Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Stats-->
            </div>
            <!--end::Info-->
        </div>
        <!--end::Details-->
        
        <!--begin::Navs-->
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mt-5">
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5 active" data-bs-toggle="tab" href="#kt_tab_overview">Overview</a>
            </li>
            <li class="nav-item mt-2">
                <a class="nav-link text-active-primary ms-0 me-10 py-5" data-bs-toggle="tab" href="#kt_tab_settings">Pengaturan</a>
            </li>
        </ul>
        <!--end::Navs-->
    </div>
</div>

<!--begin::Tab Content-->
<div class="tab-content">
    <!--begin::Tab Overview-->
    <div class="tab-pane fade show active" id="kt_tab_overview">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Detail Profil</h3>
                </div>
            </div>
            <div class="card-body p-9">
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Nama Lengkap</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->name }}</span>
                    </div>
                </div>
                
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Username</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->username }}</span>
                    </div>
                </div>
                
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Email</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->email }}</span>
                    </div>
                </div>
                
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Jenis Kelamin</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->gender == 'male' ? 'Laki-laki' : 'Perempuan' }}</span>
                    </div>
                </div>
                
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Tanggal Lahir</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->birth_date ? date('d/m/Y', strtotime(Auth::user()->birth_date)) : '-' }}</span>
                    </div>
                </div>
                
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Nomor HP</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->phone ?? '-' }}</span>
                    </div>
                </div>
                
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Fakultas</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->fakultas ?? '-' }}</span>
                    </div>
                </div>
                
                <div class="row mb-7">
                    <label class="col-lg-4 fw-semibold text-muted">Program Studi</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->prodi ?? '-' }}</span>
                    </div>
                </div>
                @if(Auth::user()->user_type != 'mahasiswa')
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Jabatan</label>
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->position ?? '-' }}</span>
                        </div>
                    </div>
                @endif

                <div class="row mb-10">
                    <label class="col-lg-4 fw-semibold text-muted">Alamat</label>
                    <div class="col-lg-8">
                        <span class="fw-bold fs-6 text-gray-800">{{ Auth::user()->address ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Tab Overview-->
    
    <!--begin::Tab Settings (Edit Profile)-->
    <div class="tab-pane fade" id="kt_tab_settings">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header cursor-pointer">
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Pengaturan Akun</h3>
                </div>
            </div>
            <div class="card-body p-9">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Klik tombol <strong>Edit Profil</strong> di atas untuk mengubah data profil Anda.
                </div>
            </div>
        </div>
    </div>
    <!--end::Tab Settings-->
</div>
@endsection