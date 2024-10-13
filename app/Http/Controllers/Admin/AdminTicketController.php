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
    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|string',
            'category' => ['required', new Enum(CategoryEnum::class)],
//test
        ]);


        $ticket->update([
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $request->image_url,
            'status' => TicketStatusEnum::Open,
            'category' => $request->category,
        ]);
        return Response::json($ticket->load('user'))->setStatusCode(201);
    }
}
