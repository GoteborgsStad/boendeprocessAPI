<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoalsController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required|string|max:255',
            'description'       => 'string|max:65535',
            'start_at'          => 'date',
            'end_at'            => 'date',
            'finished_at'       => 'date',
            'color'             => 'string|max:255',
            'goal_category_id'  => 'required|integer',
            'user_id'           => 'required|integer'
        ]);

        $goalCategory   = \App\GoalCategory::findOrFail($request->input('goal_category_id'));
        $goalStatus     = \App\GoalStatus::where('name', 'Nytt')->firstOrFail();
        $user           = \App\User::findOrFail($request->input('user_id'));
        $plan           = $user->plan()->firstOrFail();

        $goal = \App\Goal::create([
            'name'              => $request->input('name'),
            'description'       => $request->input('description'),
            'start_at'          => $request->input('start_at'),
            'end_at'            => $request->input('end_at'),
            'finished_at'       => $request->input('finished_at'),
            'color'             => $request->input('color'),
            'goal_category_id'  => $goalCategory->id,
            'goal_status_id'    => $goalStatus->id,
            'plan_id'           => $plan->id
        ]);

        $goal = \App\Goal::with(['goalCategory', 'goalStatus', 'plan'])->findOrFail($goal->id);

        return response()->json($goal, 200);
    }

    public function show($id)
    {
        $goal         = \App\Goal::with(['goalCategory', 'goalStatus'])->findOrFail($id);
        $user         = $goal->plan()->firstOrFail()->user()->firstOrFail();
        $operandUser  = $user->operands()->firstOrFail();
        $operandMe    = \Auth::user()->operands()->firstOrFail();

        if ($operandMe->id !== $operandUser->id) {
            return response()->json('not_same_operand', 403);
        }

        return response()->json($goal, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'              => 'string|max:255',
            'description'       => 'string|max:65535',
            'start_at'          => 'date',
            'end_at'            => 'date',
            'finished_at'       => 'date',
            'color'             => 'string|max:255',
            'goal_category_id'  => 'integer',
            'goal_status_id'    => 'integer',
            'user_id'           => 'required|integer'
        ]);

        $goalCateogry   = \App\GoalCategory::findOrFail($request->input('goal_category_id'));
        $goalStatus     = \App\GoalStatus::findOrFail($request->input('goal_status_id'));
        $user           = \App\User::findOrFail($request->input('user_id'));
        $plan           = $user->plan()->firstOrFail();

        $goal = \App\Goal::findOrFail($id);

        $goal->update($request->all() + [
            'plan_id' => $plan->id
        ]);

        $goal = \App\Goal::with(['goalCategory', 'goalStatus', 'plan'])->findOrFail($goal->id);

        return response()->json($goal, 200);
    }

    public function destroy($id)
    {
        $goal = \App\Goal::with(['goalCategory', 'goalStatus'])->findOrFail($id);
        $goal->delete();

        return response()->json($goal, 200);
    }

    public function goalFinished($id)
    {
        $operand            = \App\User::findOrFail(\Auth::id())->operands()->firstOrFail();
        $goal               = \App\Goal::with('goalStatus')->findOrFail($id);
        $userOperand        = $goal->plan()->firstOrFail()->user()->firstOrFail()->operands()->firstOrFail();
        $goalStatus         = \App\GoalStatus::where('name', 'Avklarat')->firstOrFail();

        if ($operand->id !== $userOperand->id) {
            return response()->json('mathod_not_allowed', 405);
        }

        if ($goal->goalStatus->name === 'Avklarat') {
            return response()->json('already_finished', 405);
        }

        $goal->update([
            'finished_at'     => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'goal_status_id'  => $goalStatus->id
        ]);

        $goal = \App\Goal::with(['goalCategory', 'goalStatus'])->findOrFail($goal->id);

        return response()->json($goal, 200);
    }

    public function updateGoalEndDate(Request $request, $id)
    {
        $this->validate($request, [
            'end_at' => 'date',
        ]);

        $goal         = \App\Goal::with('goalStatus')->findOrFail($id);
        $operand      = \App\User::findOrFail(\Auth::id())->operands()->firstOrFail();
        $userOperand  = $goal->plan()->firstOrFail()->user()->firstOrFail()->operands()->firstOrFail();

        if ($operand->id !== $userOperand->id) {
            return response()->json('mathod_not_allowed', 405);
        }

        if ($goal->goalStatus->name === 'Avklarat') {
            return response()->json('already_finished', 405);
        }

        $endAt = (!is_null($request->input('end_at'))) ? \Carbon\Carbon::parse($request->input('end_at'))->timezone(env('APP_TIMEZONE')): null;

        $goal->update([
            'end_at' => $endAt,
        ]);

        $goal = \App\Goal::with(['goalCategory', 'goalStatus'])->findOrFail($goal->id);

        return response()->json($goal, 200);
    }
}
