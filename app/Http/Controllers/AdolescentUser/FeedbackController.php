<?php

namespace App\Http\Controllers\AdolescentUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'body'                  => 'required|string|max:65535',
            'rating'                => 'integer|min:0|max:10',
            'color'                 => 'string|max:255',
            'feedback_category_id'  => 'integer'
        ]);

        $feedback = \App\Feedback::create([
            'body'                  => $request->input('body'),
        ]);

        return response()->json($feedback, 200);
    }
}
