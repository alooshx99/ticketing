<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function DashboardData(){

        $currentMonthUsers = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $todayUsers = User::whereDate('created_at', Carbon::today())->count();


        $currentMonthTickets = Ticket::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $todayTickets = Ticket::whereDate('created_at', Carbon::today())->count();

        $tickets = Ticket::latest()->take(5)->get();

        $tickets->each(function ($ticket, $counter) {
            $ticket->number = $counter + 1;
            $ticket->sender = User::where('id', $ticket->user_id)->first()->full_name;;
        });


        return view('dashboard', [
            'tickets' => $tickets,
            'currentMonthUsers'=> $currentMonthUsers,
            'todayUsers' => $todayUsers,
            'currentMonthTickets' => $currentMonthTickets,
            'todayTickets' => $todayTickets,

        ]);
    }
}
