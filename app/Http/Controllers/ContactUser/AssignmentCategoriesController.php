<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AssignmentCategoriesController extends Controller
{
    public function index()
    {
        $assignmentCategories = \App\AssignmentCategory::get();

        return response()->json($assignmentCategories, 200);
    }
}
