<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationsController extends Controller
{
    public function getEvaluationAnswers($id)
    {
        $evaluation = \App\Evaluation::findOrFail($id);

        $operandUser  = $evaluation->user()->firstOrFail()->operands()->firstOrFail();
        $operandMe    = \Auth::user()->operands()->firstOrFail();

        if ($operandUser->id !== $operandMe->id) {
            return response()->json('not_same_operand', 403);
        }

        $evaluationAnswers = $evaluation->evaluationAnswers()->with(['evaluationAnswerCategory'])->get();

        return response()->json($evaluationAnswers, 200);
    }

    public function storeEvaluationAnswers(Request $request, $id)
    {
        $this->validate($request, [
            'body'                          => 'required|string|max:65535',
            'rating'                        => 'required|integer|min:1|max:6',
            'evaluation_answer_category_id' => 'required|integer'
        ]);

        $evaluation                 = \App\Evaluation::findOrFail($id);
        $evaluationAnswerCategory   = \App\EvaluationAnswerCategory::findOrFail($request->input('evaluation_answer_category_id'));

        $evaluationAnswer = \App\EvaluationAnswer::create([
            'body'                          => $request->input('body'),
            'rating'                        => $request->input('rating'),
            'evaluation_id'                 => $request->input('evaluation_id'),
            'evaluation_answer_category_id' => $request->input('evaluation_answer_category_id')
        ]);

        $evaluationAnswer = \App\EvaluationAnswer::with(['evaluation', 'evaluation.evaluationStatus', 'evaluationAnswerCategory'])->findOrFail($evaluationAnswer->id);

        return response()->json($evaluationAnswer, 200);
    }
}
