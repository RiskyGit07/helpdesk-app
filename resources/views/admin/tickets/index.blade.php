@extends('layouts.admin')

@section('content')
<div class="container">
    <!-- Card Semua Pengaduan -->
    <div class="card card-flush shadow-sm">
        <div class="card-header py-5">
            <div class="d-flex justify-content-between align-items-center w-100">
                <h3 class="card-title fw-bold">
                    <i class="fas fa-ticket-alt me-2 text-primary"></i>
                    Semua Pengaduan
                </h3>
                
                <!-- Dropdown Filter Status -->
                <div class="dropdown">
                    <button class="btn btn-light-primary dropdown-toggle" type="button" id="statusDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-filter me-1"></i>
                        @php
                            $statusLabel = [
                                'all' => 'Semua',
                                'open' => 'Open',
                                'in_progress' => 'In Progress',
                                'resolved' => 'Resolved',
                                'closed' => 'Closed'
                            ];
                            $currentStatus = request('status', 'all');
                        @endphp
                        {{ $statusLabel[$currentStatus] ?? 'Semua' }}
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                        <li>
                            <a class="dropdown-item {{ request('status') == null || request('status') == 'all' ? 'active' : '' }}" 
                               href="{{ route('admin.tickets.index', ['status' => 'all']) }}">
                                <i class="fas fa-list me-2"></i> Semua
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('status') == 'open' ? 'active' : '' }}" 
                               href="{{ route('admin.tickets.index', ['status' => 'open']) }}">
                                <i class="fas fa-envelope-open-text me-2 text-primary"></i> Open
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('status') == 'in_progress' ? 'active' : '' }}" 
                               href="{{ route('admin.tickets.index', ['status' => 'in_progress']) }}">
                                <i class="fas fa-clock me-2 text-warning"></i> In Progress
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('status') == 'resolved' ? 'active' : '' }}" 
                               href="{{ route('admin.tickets.index', ['status' => 'resolved']) }}">
                                <i class="fas fa-check-circle me-2 text-success"></i> Resolved
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ request('status') == 'closed' ? 'active' : '' }}" 
                               href="{{ route('admin.tickets.index', ['status' => 'closed']) }}">
                                <i class="fas fa-archive me-2 text-secondary"></i> Closed
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="card-body pt-0">
            <!-- Tabel Pengaduan -->
            <div class="table-responsive">
                <table class="table align-middle gs-0 gy-4">
                    <thead>
                        <tr class="fw-bold text-gray-500 border-bottom fs-7">
                            <th>No. Tiket</th>
                            <th>User</th>
                            <th>Judul</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
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
                        
                        @forelse($tickets as $ticket)
                        <tr>
                            <td>
                                <span class="fw-bold">{{ $ticket->ticket_number ?? $ticket->ticket_id }}</span>
                            </td>
                            <td>{{ $ticket->user->name ?? 'User tidak ditemukan' }}</td>
                            <td>{{ $ticket->title ?? $ticket->subject }}</td>
                            <td>
                                <span class="badge badge-{{ $statusColors[$ticket->status] ?? 'secondary' }} px-3 py-2">
                                    {{ $statusTexts[$ticket->status] ?? ucfirst(str_replace('_',' ', $ticket->status)) }}
                                </span>
                            </td>
                            <td>{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-sm btn-light-primary">
                                    <i class="fas fa-eye me-1"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-center">
                                    <i class="fas fa-inbox fa-3x text-gray-400 mb-3"></i>
                                    <p class="text-gray-500">Belum ada data pengaduan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection