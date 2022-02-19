<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCreateRequest;
use App\Http\Requests\TicketSearchRequest;
use App\Models\Ticket;
use App\Services\TicketService;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function create(TicketCreateRequest $request,TicketService $ticketService)
    {
        $data = $ticketService->make($request);

        //Error handling
        if(!$data['status'])
            return $this->error('ticket creation error',500, [
                'code' => $data['code']
            ]);

        //Success response with ticket's data
        return $this->success([
            $data['data'],
        ],'Ticket submitted');

    }

    public function show(Ticket $ticket)
    {

        return $this->success([
            'ticket' => $ticket,
            'replies' => $ticket->replies()->orderByDesc('created_at')->get()
        ]);
    }

    public function search(TicketSearchRequest $request, TicketService $ticketService)
    {
        $data = $ticketService->search($request);
        return $this->success([
            $data['data'],
        ]);
    }

}
