<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CategoryEnum;
use App\Enums\TicketStatusEnum;
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
        $tickets = Ticket::orderBy('created_at', 'desc')->get();
        return Response::json($tickets)->setStatusCode(200);

//        return response()->json(['data'=>$tickets])
//            ->header('content_type','application/json');

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
