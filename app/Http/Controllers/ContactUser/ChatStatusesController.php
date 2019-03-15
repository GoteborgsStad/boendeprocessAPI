<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatStatusesController extends Controller
{
    public function index()
    {
        $chatStatuses = \App\ChatStatus::get();

        return response()->json($chatStatuses, 200);
    }
}
