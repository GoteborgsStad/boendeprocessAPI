<?php

namespace App\Http\Controllers\AdolescentUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationsController extends Controller
{
    public function index()
    {
        $evaluations = \App\User::findOrFail(\Auth::id())->evaluations()->with([
            'evaluationStatus',
            'evaluationAnswers',
            'evaluationAnswers.evaluationAnswerCategory',
            'evaluationGoals',
            'evaluationGoals.evaluationGoalCategory'
        ])->orderBy('created_at', 'desc')->get();

        return response()->json($evaluations, 200);
    }
}
