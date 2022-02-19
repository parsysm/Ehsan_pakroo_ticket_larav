<?php

namespace App\Services;

use App\Http\Requests\ReplyCreateRequest;
use App\Mail\TicketUpdated;
use App\Models\Ticket;
use App\Notifications\TicketAnswered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ReplyService
{

    public function make(ReplyCreateRequest $request,Ticket $ticket)
    {

        try {
            DB::beginTransaction();
            $user_id = auth()->user()->id;

            $reply = $ticket->replies()->create([
                'user_id' => $user_id,
                'body' => $request->get('body')
            ]);

            if(auth()->user()->id == $ticket->user_id) {
                $status['1'] = [
                    'reply_id' => $reply->id,
                    'user_id' => $user_id,
                ];
                $statusUpdate = 1;
            } else {
                $status['3'] = [
                    'reply_id' => $reply->id,
                    'user_id' => $user_id,
                ];
                $statusUpdate = 3;
            }
            $ticket->statuses()->attach($status);
            $ticket->updateLatestStatus($statusUpdate);

            if($request->has('change_status') && in_array($request->get('change_status'),[1,2,3,4]) && !auth()->user()->isCustomer()) {
                $ticket->updateLatestStatus($request->has('change_status'));
                $ticket->statuses()->attach([
                    $request->has('change_status') => [
                        'reply_id' => $reply->id,
                        'user_id' => $user_id
                    ]
                ]);
            }

            Notification::send($ticket->user,new TicketAnswered($ticket));

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();

            $errorCode = mt_rand(1267,99999);
            Log::error('Error Number : ' . $errorCode . ' | Ticket reply error : ' . $e->getMessage());
            return [
                'status' => false,
                'code' => $errorCode
            ];
        }

        return [
            'status' => true,
        ];
    }
}
