<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Constructor - Apply middleware
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of complaints/tickets.
     */
    public function index(Request $request)
    {
        $query = Ticket::with('user');
        
        // Filter berdasarkan role
        if (Auth::user()->role === 'admin' || Auth::user()->role === 'agent') {
            // Admin/agent bisa lihat semua
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }
            
            if ($request->has('priority') && $request->priority != '') {
                $query->where('priority', $request->priority);
            }
            
            $tickets = $query->orderBy('created_at', 'desc')->paginate(10);
        } else {
            // User biasa hanya lihat tiket mereka sendiri
            $tickets = $query->where('user_id', Auth::id())
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);
        }
        
        return view('complaints.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new complaint.
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Store a newly created complaint in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx'
        ]);

        // Generate unique ticket ID
        $ticketId = 'TKT-' . strtoupper(uniqid());
        
        $ticket = new Ticket();
        $ticket->user_id = Auth::id();
        $ticket->ticket_id = $ticketId;
        $ticket->subject = $request->subject;
        $ticket->message = $request->message;
        $ticket->priority = $request->priority;
        $ticket->status = 'open';
        
        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('complaints/' . $ticketId, $filename, 'public');
            $ticket->attachment = $path;
        }
        
        $ticket->save();
        
        return redirect()->route('complaints.show', $ticket->id)
                        ->with('success', 'Complaint submitted successfully. Your ticket ID: ' . $ticketId);
    }

    /**
     * Display the specified complaint.
     */
    public function show($id)
    {
        $ticket = Ticket::with(['user', 'replies.user'])->findOrFail($id);
        
        // Check authorization
        if (Auth::user()->role === 'user' && $ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        
        return view('complaints.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified complaint.
     */
    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Only admin/agent can edit
        if (Auth::user()->role === 'user') {
            abort(403, 'Only admin can edit complaints.');
        }
        
        return view('complaints.edit', compact('ticket'));
    }

    /**
     * Update the specified complaint in storage.
     */
    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Only admin/agent can update
        if (Auth::user()->role === 'user') {
            abort(403, 'Only admin can update complaints.');
        }
        
        $request->validate([
            'status' => 'required|in:open,in_progress,closed',
            'priority' => 'required|in:low,medium,high',
            'admin_note' => 'nullable|string'
        ]);
        
        $ticket->status = $request->status;
        $ticket->priority = $request->priority;
        
        if ($request->has('admin_note')) {
            $ticket->admin_note = $request->admin_note;
        }
        
        $ticket->save();
        
        return redirect()->route('complaints.show', $id)
                        ->with('success', 'Complaint updated successfully.');
    }

    /**
     * Remove the specified complaint from storage.
     */
    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Only admin can delete
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can delete complaints.');
        }
        
        // Delete attachment if exists
        if ($ticket->attachment) {
            Storage::disk('public')->delete($ticket->attachment);
        }
        
        // Delete all replies
        foreach ($ticket->replies as $reply) {
            if ($reply->attachment) {
                Storage::disk('public')->delete($reply->attachment);
            }
            $reply->delete();
        }
        
        $ticket->delete();
        
        return redirect()->route('complaints.index')
                        ->with('success', 'Complaint deleted successfully.');
    }

    /**
     * Add reply to complaint.
     */
    public function reply(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Check authorization
        if (Auth::user()->role === 'user' && $ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        
        $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx'
        ]);
        
        $reply = new TicketReply();
        $reply->ticket_id = $ticket->id;
        $reply->user_id = Auth::id();
        $reply->message = $request->message;
        
        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('replies/' . $ticket->ticket_id, $filename, 'public');
            $reply->attachment = $path;
        }
        
        $reply->save();
        
        // Update ticket status jika user membalas
        if (Auth::user()->role === 'user' && $ticket->status !== 'closed') {
            $ticket->status = 'open';
            $ticket->save();
        }
        
        // Jika admin/agent membalas, ubah status jadi in_progress
        if (Auth::user()->role !== 'user' && $ticket->status !== 'closed') {
            $ticket->status = 'in_progress';
            $ticket->save();
        }
        
        return redirect()->route('complaints.show', $id)
                        ->with('success', 'Reply added successfully.');
    }

    /**
     * Close complaint.
     */
    public function close($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Admin/agent can close any ticket, user can only close their own
        if (Auth::user()->role === 'user' && $ticket->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }
        
        $ticket->status = 'closed';
        $ticket->save();
        
        return redirect()->route('complaints.show', $id)
                        ->with('success', 'Complaint closed successfully.');
    }

    /**
     * Reopen complaint.
     */
    public function reopen($id)
    {
        $ticket = Ticket::findOrFail($id);
        
        // Only admin/agent can reopen closed tickets
        if (Auth::user()->role === 'user') {
            abort(403, 'Only admin can reopen complaints.');
        }
        
        $ticket->status = 'open';
        $ticket->save();
        
        return redirect()->route('complaints.show', $id)
                        ->with('success', 'Complaint reopened successfully.');
    }

    /**
     * Export complaints to CSV.
     */
    public function export(Request $request)
    {
        // Only admin can export
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Only admin can export data.');
        }
        
        $query = Ticket::with('user');
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $tickets = $query->get();
        
        $filename = 'complaints_' . date('Y-m-d_His') . '.csv';
        $handle = fopen('php://temp', 'w');
        
        // Add CSV headers
        fputcsv($handle, ['Ticket ID', 'Subject', 'User', 'Priority', 'Status', 'Created At', 'Updated At']);
        
        // Add data rows
        foreach ($tickets as $ticket) {
            fputcsv($handle, [
                $ticket->ticket_id,
                $ticket->subject,
                $ticket->user->name,
                $ticket->priority,
                $ticket->status,
                $ticket->created_at,
                $ticket->updated_at
            ]);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    /**
     * Get statistics for dashboard.
     */
    public function statistics()
    {
        // Only admin/agent can view statistics
        if (Auth::user()->role === 'user') {
            abort(403, 'Unauthorized access.');
        }
        
        $stats = [
            'total' => Ticket::count(),
            'open' => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'closed' => Ticket::where('status', 'closed')->count(),
            'high_priority' => Ticket::where('priority', 'high')->count(),
            'medium_priority' => Ticket::where('priority', 'medium')->count(),
            'low_priority' => Ticket::where('priority', 'low')->count(),
        ];
        
        return view('complaints.statistics', compact('stats'));
    }
}