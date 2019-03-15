<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationAnswersController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'body'                            => 'required|string|max:65535',
            'rating'                          => 'required|integer|min:1|max:6',
            'evaluation_id'                   => 'required|integer',
            'evaluation_answer_category_type' => 'required|string|max:255'
        ]);

        $evaluationAnswerCategory = \App\EvaluationAnswerCategory::where('type', $request->input('evaluation_answer_category_type'))->firstOrFail();

        $evaluationAnswer = \App\EvaluationAnswer::create($request->all() + [
          'evaluation_answer_category_id' => $evaluationAnswerCategory->id,
        ]);

        $evaluation = \App\Evaluation::with('evaluationAnswers')->findOrFail($request->input('evaluation_id'));

        if ($evaluation->evaluationAnswers->count() === 3) {
          $evaluationStatus = \App\EvaluationStatus::where('name', 'Genomförda')->firstOrFail();

          $evaluation->evaluation_status_id = $evaluationStatus->id;
          $evaluation->save();
        }

        $evaluationAnswer = \App\EvaluationAnswer::with(['evaluation', 'evaluationAnswerCategory'])->findOrFail($evaluationAnswer->id);

        return response()->json($evaluationAnswer, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'body'                          => 'required|string|max:65535',
            'rating'                        => 'required|integer|min:1|max:6'
        ]);

        $evaluationAnswer = \App\EvaluationAnswer::findOrFail($id);

        $evaluationAnswer->update($request->all());

        $evaluationAnswer = \App\EvaluationAnswer::with(['evaluation', 'evaluationAnswerCategory'])->findOrFail($evaluationAnswer->id);

        return response()->json($evaluationAnswer, 200);
    }

    public function destroy($id)
    {
        $evaluationAnswer = \App\EvaluationAnswer::findOrFail($id);
        $evaluationAnswer->delete();

        return response()->json($evaluationAnswer, 200);
    }
}
