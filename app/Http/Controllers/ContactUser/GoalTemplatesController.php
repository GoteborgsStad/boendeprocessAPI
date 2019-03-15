<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoalTemplatesController extends Controller
{
    public function index()
    {
        $goalTemplates = \App\GoalTemplate::with(['goalCategory'])->get();

        return response()->json($goalTemplates, 200);
    }
}
