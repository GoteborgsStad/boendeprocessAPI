<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoalStatusesController extends Controller
{
    public function index()
    {
        $goalStatuses = \App\GoalStatus::get();

        return response()->json($goalStatuses, 200);
    }
}
