<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function me()
    {
        $user = User::whereId(auth()->user()->id)->withCount([
            'tickets',
            'replies'
        ])->get();

        return $this->success([
            'user' => $user
        ]);
    }
}
