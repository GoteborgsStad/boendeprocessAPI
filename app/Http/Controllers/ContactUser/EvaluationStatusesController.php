<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationStatusesController extends Controller
{
    public function index()
    {
        $evaluationStatuses = \App\EvaluationStatus::get();

        return response()->json($evaluationStatuses, 200);
    }
}
