<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        // Query dasar untuk mengambil semua tiket
        $query = Ticket::with('user')->orderBy('created_at', 'desc');
        
        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != 'all') {
            $status = $request->status;
            
            // Validasi status yang diizinkan
            if (in_array($status, ['open', 'in_progress', 'resolved', 'rejected'])) {
                $query->where('status', $status);
            }
        }
        
        // Ambil data dengan pagination (10 data per halaman)
        $tickets = $query->paginate(10);
        
        // Kirim ke view admin.tickets.index
        return view('admin.tickets.index', compact('tickets'));
    }
    
    public function show($id)
    {
        $ticket = Ticket::with(['user', 'responses.user'])->findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,rejected'
        ]);

        $ticket = Ticket::findOrFail($id);

        $ticket->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status berhasil diupdate');
    }

    public function sendResponse(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        if (in_array($ticket->status, ['resolved', 'rejected'])) {
            return back()->with('error', 'Tiket sudah ditutup, tidak bisa dibalas lagi.');
        }

        $request->validate([
            'message' => 'required|string'
        ]);

        Response::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
        ]);

        if ($ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }

        return back()->with('succes', 'Balasan berhasil dikirim');
    }
}