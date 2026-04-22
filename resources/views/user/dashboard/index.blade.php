@extends('layouts.user')

@section('title', 'Dashboard')

@section('content')
<!-- Stats Cards -->
<div class="row g-5 g-xl-8 mb-8">
    <!-- Total Tiket -->
    <div class="col-md-3">
        <div class="card card-flush shadow-sm">
            <div class="card-body d-flex align-items-center py-6">
                <div class="symbol symbol-50px me-4">
                    <div class="symbol-label bg-light-info">
                        <i class="fas fa-ticket-alt fs-2x text-info"></i>
                    </div>
                </div>
                <div>
                    <span class="text-gray-600 fw-semibold fs-7">Total Tiket</span>
                    <h2 class="text-info fs-1 fw-bold mb-0">{{ $totalTickets ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Open -->
    <div class="col-md-3">
        <div class="card card-flush shadow-sm">
            <div class="card-body d-flex align-items-center py-6">
                <div class="symbol symbol-50px me-4">
                    <div class="symbol-label bg-light-primary">
                        <i class="fas fa-envelope-open-text fs-2x text-primary"></i>
                    </div>
                </div>
                <div>
                    <span class="text-gray-600 fw-semibold fs-7">Open</span>
                    <h2 class="text-primary fs-1 fw-bold mb-0">{{ $openTickets ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <!-- In Progress -->
    <div class="col-md-3">
        <div class="card card-flush shadow-sm">
            <div class="card-body d-flex align-items-center py-6">
                <div class="symbol symbol-50px me-4">
                    <div class="symbol-label bg-light-warning">
                        <i class="fas fa-clock fs-2x text-warning"></i>
                    </div>
                </div>
                <div>
                    <span class="text-gray-600 fw-semibold fs-7">In Progress</span>
                    <h2 class="text-warning fs-1 fw-bold mb-0">{{ $inProgressTickets ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Resolved -->
    <div class="col-md-3">
        <div class="card card-flush shadow-sm">
            <div class="card-body d-flex align-items-center py-6">
                <div class="symbol symbol-50px me-4">
                    <div class="symbol-label bg-light-success">
                        <i class="fas fa-check-circle fs-2x text-success"></i>
                    </div>
                </div>
                <div>
                    <span class="text-gray-600 fw-semibold fs-7">Resolved</span>
                    <h2 class="text-success fs-1 fw-bold mb-0">{{ $resolvedTickets ?? 0 }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tiket Terbaru -->
<div class="card card-flush shadow-sm">
    <div class="card-header py-5">
        <h3 class="card-title fw-bold">
            <i class="fas fa-list me-2 text-primary"></i>
            Tiket Terbaru
        </h3>
        <a href="{{ route('user.tickets.index') }}" class="btn btn-primary">
            Lihat Semua
            <i class="fas fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body pt-0">
        <div class="table-responsive">
            <table class="table align-middle gs-0 gy-4">
                <thead>
                    <tr class="fw-bold text-gray-500 border-bottom fs-7">
                        <th>No. Tiket</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTickets ?? [] as $ticket)
                    <tr>
                        <td>
                            <span class="fw-bold">{{ $ticket->ticket_number }}</span>
                        </td>
                        <td>{{ $ticket->title }}</td>
                        <td>
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
                            <span class="badge badge-{{ $statusColors[$ticket->status] }} px-3 py-2">
                                {{ $statusTexts[$ticket->status] }}
                            </span>
                        </td>
                        <td>{{ $ticket->created_at->format('d/m/a') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            Belum ada tiket
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection