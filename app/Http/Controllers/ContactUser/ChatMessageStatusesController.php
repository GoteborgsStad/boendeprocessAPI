<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatMessageStatusesController extends Controller
{
    public function index()
    {
        $chatMessageStatuses = \App\ChatMessageStatus::get();

        return response()->json($chatMessageStatuses, 200);
    }
}
