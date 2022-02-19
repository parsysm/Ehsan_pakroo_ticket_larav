<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyCreateRequest;
use App\Models\Ticket;
use App\Services\ReplyService;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function create(ReplyCreateRequest $request,Ticket $ticket,ReplyService $replyService)
    {

        $data = $replyService->make($request, $ticket);

        //Error handling
        if(!$data['status'])
            return $this->error('reply creation error',500, [
                'code' => $data['code']
            ]);

        //Success response with ticket's data
        return $this->success(null,'Reply submitted');

    }
}
