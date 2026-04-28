<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    public function inbox()
    {
        return view('admin.messages.inbox');
    }
}