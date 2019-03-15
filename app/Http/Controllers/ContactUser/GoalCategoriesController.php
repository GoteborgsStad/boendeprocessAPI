<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoalCategoriesController extends Controller
{
    public function index()
    {
        $goalCategories = \App\GoalCategory::get();

        return response()->json($goalCategories, 200);
    }
}
