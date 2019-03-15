<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignmentFormsController extends Controller
{
    public function index()
    {
        $assignmentForms = \App\AssignmentForm::get();

        return response()->json($assignmentForms, 200);
    }
}
