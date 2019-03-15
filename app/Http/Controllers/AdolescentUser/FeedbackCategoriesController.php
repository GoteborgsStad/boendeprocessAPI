<?php

namespace App\Http\Controllers\AdolescentUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackCategoriesController extends Controller
{
    public function index()
    {
        $feedbackCategories = \App\FeedbackCategory::get();

        return response()->json($feedbackCategories, 200);
    }
}
