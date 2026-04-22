<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        

        $userId = Auth::id();
        
        $totalTickets = Ticket::where('user_id', $userId)->count();
        $openTickets = Ticket::where('user_id', $userId)->where('status', 'open')->count();
        $inProgressTickets = Ticket::where('user_id', $userId)->where('status', 'in_progress')->count();
        $resolvedTickets = Ticket::where('user_id', $userId)->where('status', 'resolved')->count();
        $recentTickets = Ticket::where('user_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->limit(5)
                            ->get();
        
        return view('user.dashboard.index', compact(
            'totalTickets',
            'openTickets',
            'inProgressTickets',
            'resolvedTickets',
            'recentTickets'
        ));
    }
}