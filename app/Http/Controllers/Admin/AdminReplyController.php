<?php

namespace App\Http\Controllers\Admin;

use App\helper;
use App\Http\Controllers\Controller;
use App\Models\Reply;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AdminReplyController extends Controller
{
    public function reply(Request $request, $SID)
    {
        $user_id = Auth::id();

        $request->validate([ //validate the request
            'description' => 'required|string|min:3|max:255',
        ]);

        $ticket= Ticket::where('SID', $SID)->first(); //find the ticket with the SID


        $previous_reply = Reply::where('ticket_id', $ticket->id) //find the previous reply
            ->whereNull('next_reply_id')
            ->first();


        $reply = Reply::create([ //create a new reply
            'description' => $request->description,
            'ticket_id' => $ticket->id,
            'user_id' => $user_id,
            'SID' => app(helper::class)->generateReplySID(),
            'sender' => app(helper::class)->checkRole($user_id),
        ]);


        if($previous_reply){ //if there is a previous reply, set the next reply id of previous reply to the current reply
            $previous_reply->next_reply_id = $reply->id;
            $previous_reply->save();
        }

        $filesPath = app(helper::class)->saveFile($request,null ,$reply);

        if ($filesPath) {
            $reply->attached_files = $filesPath;
            $reply->save();
        }

        return Response::json($reply)->setStatusCode(201);

    }


}
