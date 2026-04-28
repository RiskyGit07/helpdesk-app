<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function inbox()
    {
        return view('user.messages.inbox');
    }
}