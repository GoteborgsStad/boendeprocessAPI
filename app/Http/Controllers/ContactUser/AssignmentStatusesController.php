<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignmentStatusesController extends Controller
{
    public function index()
    {
        $assignmentStatuses = \App\AssignmentStatus::get();

        return response()->json($assignmentStatuses, 200);
    }
}
