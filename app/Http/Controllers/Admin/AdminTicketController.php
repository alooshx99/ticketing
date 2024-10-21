<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryEnum;
use App\Enums\TicketStatusEnum;
use App\helper;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Auth;



class AdminTicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tickets = Ticket::orderBy('created_at', 'desc')->get();

        return Response::json([
            ["user full name" => $user->full_name,
                'Total Tickets'=> app(helper::class)->countTotalTickets(),
                'Pending Tickets'=> app(helper::class)->countPendingTickets(),
                'Closed Tickets'=> app(helper::class)->countClosedTickets(),
            ],
            $tickets])->setStatusCode(200);


    }

    public function show($SID)
    {

        $ticket = Ticket::where('SID', $SID)->first();

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->load(['replies' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }]);

        $ticket->replies->each(function ($reply, $counter) {
            $reply->number = $counter + 1;
        });

        return response()->json($ticket)->setStatusCode(200);
    }


    public function update(Request $request, $SID)
    {
        $request->validate([
            'status' => ['required', new Enum(TicketStatusEnum::class)],
            'category' => ['required', new Enum(CategoryEnum::class)],

        ]);

        $ticket = Ticket::where('SID', $SID)->first();

        $ticket->update([
            'status' => $request->status,
            'category' => $request->category,
        ]);
        return Response::json($ticket->load('user'))->setStatusCode(201);
    }
}
