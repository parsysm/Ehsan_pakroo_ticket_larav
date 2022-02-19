<?php

namespace App\Services;

use App\Http\Requests\TicketCreateRequest;
use App\Http\Requests\TicketSearchRequest;
use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketService
{

    public function make(TicketCreateRequest $request)
    {

        try {
            DB::beginTransaction();
            $ticket = auth()->user()->tickets()->create($request->merge([
                'latest_status' => 1
            ])->all());

            $ticket->statuses()->sync([
                'status_id' => 1,
            ]);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();

            $errorCode = mt_rand(1267,99999);
            Log::error('Error Number : ' . $errorCode . ' | Ticket creation error : ' . $e->getMessage());
            return [
                'status' => false,
                'code' => $errorCode
            ];
        }

        return [
            'status' => true,
            'data' => [
                'ticket' => $ticket,
            ]
        ];
    }

    public function search(TicketSearchRequest $request)
    {

        $offset = $request->has('offset') ? $request->get('offset') : 0;
        $limit = $request->has('limit') ? $request->get('limit') : 20;
        $tickets = Ticket::query();

        if(auth()->user()->isCustomer())
            $tickets->where('user_id',auth()->user()->id);


        if($request->has('status')) {
            $tickets->whereHas('statuses', function($subQuery) use($request){
                $subQuery->where('status_ticket.status_id', $request->get('status'));
            });
        }

        if($request->has('customer_name') AND !auth()->user()->isCustomer())
            $tickets->whereHas('user', function($subQuery) use($request) {
                $subQuery->where('name','LIKE', "%{$request->get('customer_name')}%");
            });

        return [
            'status' => true,
            'data' => [
                'tickets' => $tickets->offset($offset)->limit($limit)->withCount('replies')->get(),
                'offset' => $offset,
                'limit' => $limit
            ]
        ];
    }
}
