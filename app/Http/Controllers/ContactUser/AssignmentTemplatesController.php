<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignmentTemplatesController extends Controller
{
    public function index()
    {
        $assignmentTemplates = \App\AssignmentTemplate::with(['assignmentCategory', 'assignmentForms', 'assignmentStatus'])->get();

        return response()->json($assignmentTemplates, 200);
    }
}
