@extends('layouts.admin')

@section('title', 'Pesan Masuk - Admin')

@section('content')
<div class="card">
    <div class="card-header border-0 pt-8">
        <div class="d-flex justify-content-between align-items-center w-100">
            <div>
                <h3 class="card-title fw-bold fs-2 mb-1">Pesan Masuk</h3>
                <div class="text-muted fs-7">
                    <i class="ki-outline ki-message-text-2"></i> Semua percakapan dengan pengguna
                </div>
            </div>
            <div class="text-muted text-end fs-7">
                {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
            </div>
        </div>
    </div>
    
    <div class="card-body pt-0">
        @php
            // Ambil semua tiket yang memiliki balasan (respons)
            $tickets = App\Models\Ticket::whereHas('responses')
                ->with(['responses' => function($q) {
                    $q->latest();
                }, 'user'])
                ->orderBy('updated_at', 'desc')
                ->get();
            
            $totalConversations = $tickets->count();
            $lastUpdate = $tickets->first()?->updated_at;
        @endphp
        
        <div class="d-flex justify-content-between align-items-center mb-5 pb-2 border-bottom">
            <div class="fw-semibold text-gray-700">
                <i class="ki-outline ki-message-text-2 me-1"></i> Pesan Masuk
            </div>
            <div class="text-muted fs-7">
                Total: <span class="fw-bold">{{ $totalConversations }}</span> percakapan
                @if($lastUpdate)
                    • Terakhir update: {{ $lastUpdate->translatedFormat('d/m/Y H:i') }}
                @endif
            </div>
        </div>
        
        @forelse($tickets as $ticket)
            @php
                $lastResponse = $ticket->responses->first();
                $unreadCount = App\Models\Response::where('ticket_id', $ticket->id)
                    ->where('user_id', '!=', Auth::id())
                    ->where('is_read', false)
                    ->count();
                
                // Cek siapa pengirim pesan terakhir
                $lastSender = $lastResponse?->user;
                $isLastMessageFromUser = $lastSender && $lastSender->user_type != 'admin';
                
                // Tipe user
                $userTypeLabel = $ticket->user->user_type == 'mahasiswa' ? 'Mahasiswa' : 
                                ($ticket->user->user_type == 'pegawai_asn' ? 'Pegawai ASN' : 'Pegawai Non ASN');
            @endphp
            
            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="text-decoration-none">
                <div class="d-flex align-items-center py-4 border-bottom hover-bg-light rounded px-3 {{ $unreadCount > 0 ? 'bg-light-primary' : '' }}" style="transition: all 0.2s;">
                    <!-- Avatar -->
                    <div class="symbol symbol-50px me-4">
                        <div class="symbol-label bg-light-{{ $unreadCount > 0 ? 'primary' : 'secondary' }}">
                            <i class="ki-outline ki-user fs-2x text-{{ $unreadCount > 0 ? 'primary' : 'gray-500' }}"></i>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <div>
                                <span class="fw-bold fs-6 {{ $unreadCount > 0 ? 'text-dark' : '' }}">
                                    {{ $lastSender->name ?? $ticket->user->name }}
                                </span>
                                <span class="badge badge-{{ $isLastMessageFromUser ? 'secondary' : 'danger' }} ms-2" style="font-size: 10px;">
                                    {{ $isLastMessageFromUser ? $userTypeLabel : 'Admin' }}
                                </span>
                            </div>
                            <small class="text-muted">
                                {{ $lastResponse?->created_at->diffForHumans() ?? '-' }}
                            </small>
                        </div>
                        
                        <div>
                            <span class="text-muted fs-7">
                                <strong class="text-dark">{{ $ticket->ticket_number }}</strong> - 
                                {{ Str::limit($ticket->title, 40) }}
                            </span>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-1">
                            <span class="text-muted fs-7 {{ $unreadCount > 0 ? 'fw-bold text-dark' : '' }}">
                                {{ Str::limit($lastResponse?->message ?? 'Tidak ada pesan', 50) }}
                            </span>
                            @if($unreadCount > 0)
                                <span class="badge badge-primary rounded-pill">{{ $unreadCount }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center py-10">
                <div class="symbol symbol-100px mb-5">
                    <div class="symbol-label bg-light-primary">
                        <i class="ki-outline ki-message-text-2 fs-2x text-primary"></i>
                    </div>
                </div>
                <h5>Belum ada pesan</h5>
                <p class="text-muted">Belum ada percakapan dengan pengguna</p>
            </div>
        @endforelse
    </div>
</div>
@endsection