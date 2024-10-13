<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
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
        $tickets = Ticket::all();
        return Response::json($tickets);

    }

    public function show(Ticket $ticket)
    {
        return Response::json($ticket)->setStatusCode(200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'category' => ['required', new Enum(CategoryEnum::class)],
            'receiver_id' => 'required | integer|',
        ]);

        $user_id = Auth::id();

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'status' => TicketStatusEnum::Open,
            'category' => $request->category,
            'user_id' => $user_id,
            'receiver_id' => $request->receiver_id,

        ]);
        return Response::json($ticket)->setStatusCode(201);
    }


}
