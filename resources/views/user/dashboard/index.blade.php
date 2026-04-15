@extends('layouts.metronic')

@section('title', 'Dashboard')

@section('content')
<div class="row g-5 g-xl-8">
    <!-- Total Tiket -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h1 class="text-primary fs-1 fw-bold">{{ $totalTickets ?? 0 }}</h1>
                <span class="text-gray-600">Total Tiket</span>
            </div>
        </div>
    </div>
    
    <!-- Open -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h1 class="text-warning fs-1 fw-bold">{{ $openTickets ?? 0 }}</h1>
                <span class="text-gray-600">Open</span>
            </div>
        </div>
    </div>
    
    <!-- In Progress -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h1 class="text-info fs-1 fw-bold">{{ $inProgressTickets ?? 0 }}</h1>
                <span class="text-gray-600">In Progress</span>
            </div>
        </div>
    </div>
    
    <!-- Resolved -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h1 class="text-success fs-1 fw-bold">{{ $resolvedTickets ?? 0 }}</h1>
                <span class="text-gray-600">Resolved</span>
            </div>
        </div>
    </div>
</div>

<!-- Tiket Terbaru -->
<div class="card mt-5">
    <div class="card-header">
        <h3 class="card-title">Tiket Terbaru</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No. Tiket</th>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTickets ?? [] as $ticket)
                    <tr>
                        <td>{{ $ticket->ticket_number }}</td>
                        <td>{{ Str::limit($ticket->title, 50) }}</td>
                        <td>
                            @php
                                $statusClass = [
                                    'open' => 'warning',
                                    'in_progress' => 'info',
                                    'resolved' => 'success',
                                ][$ticket->status] ?? 'secondary';
                            @endphp
                            <span class="badge badge-light-{{ $statusClass }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>
                        <td>{{ $ticket->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-primary">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada tiket</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection