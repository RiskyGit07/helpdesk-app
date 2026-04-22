@extends('layouts.admin')

@section('title', 'Detail Pengaduan - ' . $ticket->ticket_number)

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header border-0 pt-8">
            <div class="d-flex justify-content-between align-items-center w-100 flex-wrap gap-3">
                <div>
                    <h3 class="card-title fw-bold fs-2 mb-1">{{ $ticket->ticket_number }}</h3>
                    <div class="text-muted fs-7">
                        Dibuat pada {{ $ticket->created_at->format('d F Y H:i') }}
                    </div>
                </div>
                <div class="d-flex gap-2">
                    @php
                        $statusColors = [
                            'open' => 'primary',
                            'in_progress' => 'warning',
                            'resolved' => 'success',
                            'closed' => 'secondary'
                        ];
                        $statusTexts = [
                            'open' => 'Open',
                            'in_progress' => 'In Progress',
                            'resolved' => 'Resolved',
                            'closed' => 'Closed'
                        ];
                    @endphp
                    <span class="badge badge-{{ $statusColors[$ticket->status] }} fs-7 p-3">
                        {{ $statusTexts[$ticket->status] }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="card-body pt-0">

            {{-- INFORMASI PELAPOR --}}
            <div class="mb-10">
                <div class="separator separator-dashed my-6"></div>
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-40px me-5">
                        <div class="symbol-label bg-light-primary">
                            <i class="ki-outline ki-user-tick fs-2 text-primary"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-0">Informasi Pelapor</h5>
                        <div class="text-muted fs-7">Data pengirim pengaduan</div>
                    </div>
                </div>

                <div class="row g-5">
                    <div class="col-md-6">
                        <div class="bg-light rounded p-4 h-100">
                            <div class="text-muted fs-7 mb-1">Nama Lengkap</div>
                            <div class="fw-semibold fs-6">{{ $ticket->user->name }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light rounded p-4 h-100">
                            <div class="text-muted fs-7 mb-1">Email</div>
                            <div class="fw-semibold fs-6">{{ $ticket->user->email }}</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light rounded p-4 h-100">
                            <div class="text-muted fs-7 mb-1">Nomor Identifikasi</div>
                            <div class="fw-semibold fs-6">
                                {{ $ticket->user_identifier ?? $ticket->user->username }}
                                @if($ticket->user->user_type == 'mahasiswa')
                                    <span class="badge badge-light-primary ms-2">NIM</span>
                                @elseif($ticket->user->user_type == 'pegawai_asn')
                                    <span class="badge badge-light-primary ms-2">NIP</span>
                                @elseif($ticket->user->user_type == 'pegawai_non_asn')
                                    <span class="badge badge-light-primary ms-2">NIK</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="bg-light rounded p-4 h-100">
                            <div class="text-muted fs-7 mb-1">Fakultas / Program Studi</div>
                            <div class="fw-semibold fs-6">
                                {{ $ticket->user->fakultas ?? '-' }} 
                                @if($ticket->user->prodi)
                                    <span class="text-muted">-</span> {{ $ticket->user->prodi }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- DETAIL PENGADUAN --}}
            <div class="mb-10">
                <div class="separator separator-dashed my-6"></div>
                <div class="d-flex align-items-center mb-5">
                    <div class="symbol symbol-40px me-5">
                        <div class="symbol-label bg-light-warning">
                            <i class="ki-outline ki-message-text-2 fs-2 text-warning"></i>
                        </div>
                    </div>
                    <div>
                        <h5 class="mb-0">Detail Pengaduan</h5>
                        <div class="text-muted fs-7">Isi lengkap pengaduan</div>
                    </div>
                </div>

                <div class="bg-light rounded p-6 mb-5">
                    <h4 class="mb-4">{{ $ticket->title }}</h4>
                    <div class="text-muted mb-3 fs-7">
                        Dilaporkan pada {{ $ticket->created_at->format('d F Y H:i') }}
                    </div>
                    <div class="border-top pt-4 mt-2">
                        {!! nl2br(e($ticket->description)) !!}
                    </div>
                </div>

                @if($ticket->attachment)
                <div class="alert alert-light-primary d-flex align-items-center p-4 rounded border border-primary">
                    <div class="symbol symbol-40px me-4">
                        <div class="symbol-label bg-primary">
                            <i class="ki-outline ki-file fs-2 text-white"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold text-gray-800">Lampiran Bukti Pendukung</div>
                        <div class="text-muted fs-7">Klik untuk melihat file</div>
                    </div>
                    <a href="{{ asset('storage/' . $ticket->attachment) }}" target="_blank" class="btn btn-sm btn-primary">
                        Lihat Lampiran
                    </a>
                </div>
                @endif
            </div>

            {{-- ===== TAMBAHAN BALASAN DI SINI ===== --}}
            <div class="mb-10">
                <div class="separator separator-dashed my-6"></div>

                <h5 class="mb-4">Balasan</h5>

                @forelse($ticket->responses as $response)
                    <div class="mb-4 p-4 bg-light rounded">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <strong>{{ $response->user->name }}</strong>
                                
                                {{-- TAMPILKAN TIPE USER (ADMIN / USER) LANGSUNG DI SAMPING NAMA --}}
                                @if($response->user->user_type == 'admin')
                                    <span class="badge badge-danger" style="font-size: 11px;">Admin</span>
                                @else
                                    d<span class="badge badge-secondary" style="font-size: 11px;">User</span>
                                @endif
                            </div>

                            <small class="text-muted">
                                {{ $response->created_at->format('d M Y H:i') }}
                            </small>
                        </div>

                        <div class="mt-2">
                            {{ $response->message }}
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Belum ada balasan</p>
                @endforelse
            </div>

            {{-- FORM BALAS ADMIN --}}
            <div class="mb-10">
                <form action="{{ route('admin.tickets.response', $ticket->id) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Tulis Balasan</label>
                        <textarea name="message" class="form-control" rows="3" required></textarea>
                    </div>

                    <button class="btn btn-primary">
                        Kirim Balasan
                    </button>
                </form>
            </div>

            {{-- AKSI ADMIN --}}
            <div class="separator separator-dashed my-6"></div>

            <div class="d-flex justify-content-between flex-wrap gap-3">
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-light">
                    Kembali
                </a>

                {{-- Update Status --}}
                <form action="{{ route('admin.tickets.updateStatus', $ticket->id) }}" method="POST" class="d-flex gap-2">
                    @csrf
                    @method('PUT')

                    <select name="status" class="form-select form-select-sm">
                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>

                    <button type="submit" class="btn btn-primary btn-sm">
                        Update Status
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection