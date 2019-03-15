<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationAnswerCategoriesController extends Controller
{
    public function index()
    {
        $evaluationAnswerCategories = \App\EvaluationAnswerCategory::get();

        return response()->json($evaluationAnswerCategories, 200);
    }
}
