@extends('layouts.metronic')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between w-100">
                <h3 class="card-title">Ticket: {{ $ticket->ticket_id }}</h3>
                <div>
                    {!! $ticket->priority_badge !!}
                    {!! $ticket->status_badge !!}
                </div>
            </div>
        </div>
        <div class="card-body">
            <h4>{{ $ticket->subject }}</h4>
            <div class="text-muted mb-5">
                Created by {{ $ticket->user->name }} on {{ $ticket->created_at->format('d M Y H:i') }}
            </div>
            <div class="p-5 bg-light rounded mb-10">
                {!! nl2br(e($ticket->message)) !!}
            </div>

            @if($ticket->attachment)
                <div class="mb-10">
                    <strong>Attachment:</strong>
                    <a href="{{ Storage::url($ticket->attachment) }}" target="_blank" class="btn btn-sm btn-light">
                        <i class="ki-outline ki-file"></i> Download
                    </a>
                </div>
            @endif

            <h4 class="mb-5">Replies</h4>
            <div class="timeline">
                @foreach($ticket->replies as $reply)
                <div class="timeline-item">
                    <div class="timeline-line"></div>
                    <div class="timeline-icon">
                        <div class="symbol symbol-circle symbol-40px">
                            <div class="symbol-label bg-light">
                                <i class="ki-outline ki-message-text-2 fs-2"></i>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-content">
                        <div class="mb-5">
                            <div class="fs-5 fw-semibold mb-2">
                                {{ $reply->user->name }}
                                @if($reply->user->is_admin)
                                    <span class="badge badge-primary">Support Team</span>
                                @endif
                            </div>
                            <div class="text-muted fs-7">{{ $reply->created_at->diffForHumans() }}</div>
                        </div>
                        <div class="p-5 bg-light rounded">
                            {!! nl2br(e($reply->message)) !!}
                        </div>
                        @if($reply->attachment)
                            <div class="mt-3">
                                <a href="{{ Storage::url($reply->attachment) }}" target="_blank" class="btn btn-sm btn-light">
                                    <i class="ki-outline ki-file"></i> Download Attachment
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            @if($ticket->status !== 'closed')
            <div class="mt-10">
                <h4 class="mb-5">Add Reply</h4>
                <div class="d-flex gap-3">
                    <!-- FORM REPLY -->
                    <form action="{{ route('tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-5">
                            <textarea name="message" rows="4" class="form-control" required placeholder="Type your reply here..."></textarea>
                        </div>
                        <div class="mb-5">
                            <input type="file" name="attachment" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                    </form>
                </div>

                    <div class="mt-5">
                        <form id="closeForm" action="{{ route('tickets.close', $ticket->id) }}" method="POST">
                            @csrf
                            <button type="button" class="btn btn-danger"
                                onclick="if(confirm('Close this ticket?')) document.getElementById('closeForm').submit();">
                                Close Ticket
                            </button>
                        </form>
                    </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection