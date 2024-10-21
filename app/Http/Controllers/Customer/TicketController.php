<?php

namespace App\Http\Controllers\Customer;

use App\helper;
use App\Http\Controllers\Controller;
use App\Models\Reply;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Enums\TicketStatusEnum;
use App\Enums\CategoryEnum;
use Illuminate\Validation\Rules\Enum;

class TicketController extends Controller
{


    public function index()
    {

        $user = Auth::user();
        $tickets = Ticket::where('user_id', $user->id)->orderBy('created_at', 'desc')->get()->makeHidden('id');

        //$tickets = Ticket::all();
        return Response::json([
            ["data" =>
                ["user full name" => $user->full_name,
                 'Total Tickets'=> app(helper::class)->countTotalTickets($user->id),
                'Pending Tickets'=> app(helper::class)->countPendingTickets($user->id),
                'Closed Tickets'=> app(helper::class)->countClosedTickets($user->id),
                    ],
            'tickets' => $tickets]])->setStatusCode(200);

    }

    public function show($SID)
    {

        $user_id = Auth::id();

        $ticket = Ticket::where('user_id', $user_id)->where('SID', $SID)->first()->makeHidden('id');

        if (!$ticket) {
            return response()->json(['message' => 'Ticket not found'], 404);
        }

        $ticket->load(['replies' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }]);

        $ticket->replies->each(function ($reply, $counter) {
            $reply->number = $counter + 1;
        });

        return Response::json($ticket)->setStatusCode(200);
    }

    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string',
            'category' => ['required', new Enum(CategoryEnum::class)],
            'receiver_id' => 'required | integer',
        ]);

        $user_id = Auth::id();

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => TicketStatusEnum::Open,
            'category' => $request->category,
            'user_id' => $user_id,
            'receiver_id' => $request->receiver_id,
            'SID' => app(helper::class)->generateTicketSID(),

        ]);

        $filesPath = app(helper::class)->saveFile($request, $ticket);

        if ($filesPath) {
            $ticket->attached_files = $filesPath;
            $ticket->save();
        }

        return Response::json($ticket)->setStatusCode(201);
    }

    public function TicketFiles($SID){

        $ticket = Ticket::where('SID', $SID)->first();

        $urlsArray = json_decode($ticket->attached_files, true);

        $urls = app(helper::class)->returnFiles($SID, $urlsArray);

        return Response::json($urls)->setStatusCode(200);
    }


}
