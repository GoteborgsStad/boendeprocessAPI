<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Jobs\SendPush;

class AssignmentsController extends Controller
{
    public function show($id)
    {
        $assignment = \App\Assignment::with([
            'assignmentCategory',
            'assignmentForms',
            'assignmentStatus'
        ])->findOrFail($id);

        $me       = \Auth::user();
        $operand  = $me->operands()->firstOrFail();

        $user       = $assignment->user()->firstOrFail();
        $userOperand = $user->operands()->firstOrFail();

        if ($userOperand->id !== $operand->id) {
            return response()->json('not_same_operand', 403);
        }

        return response()->json($assignment, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'                      => 'required|string|max:255',
            'description'               => 'string|max:65535|nullable',
            'start_at'                  => 'string|max:255|nullable',
            'end_at'                    => 'string|max:255|nullable',
            'finished_at'               => 'string|max:255|nullable',
            'image_description_uuid'    => 'string|max:255|nullable',
            'color'                     => 'string|max:255|nullable',
            'user_id'                   => 'required|integer',
            'assignment_category_id'    => 'required|integer',
            'assignment_forms_id'       => 'required|string',
        ]);

        $user               = \App\User::with('userConfigurations')->findOrFail($request->input('user_id'));
        $assignmentCategory = \App\AssignmentCategory::findOrFail($request->input('assignment_category_id'));
        $assignmentStatus   = \App\AssignmentStatus::where('name', 'Nytt')->firstOrFail();

        $file = \App\File::where('uuid', $request->input('image_description_uuid'))->first();
        $fileName = null;

        if(!is_null($file)){
            $fileName = $file->name . '.' . $file->extension;
        }

        $assignment = \App\Assignment::create([
            'name'                      => $request->input('name'),
            'description'               => $request->input('description'),
            'start_at'                  => (!is_null($request->input('start_at'))) ? \Carbon\Carbon::parse($request->input('start_at')): null,
            'end_at'                    => (!is_null($request->input('end_at'))) ? \Carbon\Carbon::parse($request->input('end_at')): null,
            'finished_at'               => $request->input('finished_at'),
            'image_description_url'     => $fileName,
            'color'                     => $request->input('color'),
            'user_id'                   => $user->id,
            'assignment_category_id'    => $assignmentCategory->id,
            'assignment_status_id'      => $assignmentStatus->id
        ]);

        $assignmentFormsId = explode(',', $request->input('assignment_forms_id'));

        foreach ($assignmentFormsId as $key => $assignmentFormId) {
            $assignment->assignmentForms()->attach($assignmentFormId);
        }

        $adolescent = $user;
        $contact    = \Auth::user();

        $globalStatuses = \App\UserRelationship::globalStatuses($contact, $adolescent);
        $globalStatus   = $globalStatuses->where('key', 'new_assignment_amount_from_contact')->first();

        $globalStatus->update([
            'value' => strval((int)$globalStatus->value + 1),
        ]);

        if ($adolescent->userConfigurations()->where('key', 'notification_contact_new_assignment')->firstOrFail()->value === '1') {
            SendPush::dispatch(
                'Nytt Uppdrag',
                'Något 1',
                'Du har fått ett nytt uppdrag',
                true,
                1,
                collect([$adolescent]),
                ['Sambuh']
            )->onConnection('database')->onQueue('push');
        }

        $assignment = \App\Assignment::with(['user', 'assignmentCategory', 'assignmentForms', 'assignmentStatus'])->findOrFail($assignment->id);

        return response()->json($assignment, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'                      => 'required|string|max:255',
            'description'               => 'string|max:65535',
            'start_at'                  => 'string|max:255|nullable',
            'end_at'                    => 'string|max:255',
            'finished_at'               => 'string|max:255',
            'image_description_uuid'    => 'string|max:255',
            'color'                     => 'string|max:255',
            'user_id'                   => 'required|integer',
            'assignment_category_id'    => 'required|integer',
            'assignment_forms_id'       => 'required|string',
        ]);

        $user               = \App\User::findOrFail($request->input('user_id'));
        $assignmentCategory = \App\AssignmentCategory::findOrFail($request->input('assignment_category_id'));

        $assignment = \App\Assignment::findOrFail($id);

        $file = \App\File::where('uuid', $request->input('image_description_uuid'))->first();
        $fileName = null;

        if(!is_null($file)){
            $fileName = $file->name . '.' . $file->extension;
        }

        if ($request->input('image_description_uuid') === 'remove') {
            $assignment->image_description_url = null;
            $assignment->save();
        }

        $assignment->update($request->except(['start_at', 'end_at', 'assignment_form_id']));

        $assignment->assignmentForms()->detach();

        $assignmentFormsId = explode(',', $request->input('assignment_forms_id'));

        foreach ($assignmentFormsId as $key => $assignmentFormId) {
            $assignment->assignmentForms()->attach($assignmentFormId);
        }

        $startAt  = (!is_null($request->input('start_at'))) ? \Carbon\Carbon::parse($request->input('start_at'))->timezone(env('APP_TIMEZONE')): null;
        $endAt    = (!is_null($request->input('end_at'))) ? \Carbon\Carbon::parse($request->input('end_at'))->timezone(env('APP_TIMEZONE')): null;

        $assignment->update([
            'start_at'              => (!is_null($startAt)) ? $startAt->format('Y-m-d H:i:s') : null,
            'end_at'                => $endAt->format('Y-m-d H:i:s'),
            'image_description_url' => $fileName,
        ]);

        $assignment = \App\Assignment::with(['user', 'assignmentCategory', 'assignmentForms', 'assignmentStatus'])->findOrFail($assignment->id);

        return response()->json($assignment, 200);
    }

    public function destroy($id)
    {
        $operandMe    = \Auth::user()->operands()->firstOrFail();

        $assignment   = \App\Assignment::findOrFail($id);

        $operandUser  = $assignment->user()->firstOrFail()->operands()->firstOrFail();

        if ($operandMe->id !== $operandUser->id) {
            return response()->json('not_same_operand', 403);
        }

        $assignment->delete();

        return response()->json($assignment, 200);
    }

    public function assignmentFinished(Request $request, $id)
    {
        $operand            = \App\User::findOrFail(\Auth::id())->operands()->firstOrFail();
        $assignment         = \App\Assignment::findOrFail($id);
        $userOperand        = $assignment->user()->firstOrFail()->operands()->firstOrFail();
        $assignmentStatus   = \App\AssignmentStatus::where('name', 'Avslutat uppdrag')->firstOrFail();

        if (!is_null($assignment->finished_at)) {
            return response()->json('already_finished', 405);
        }

        if ($operand->id !== $userOperand->id) {
            return response()->json('mathod_not_allowed', 405);
        }

        $assignment->update([
            'finished_at'           => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'assignment_status_id'  => $assignmentStatus->id
        ]);

        $adolescent = \App\User::with('userConfigurations')->findOrFail($assignment->user_id);

        if ($adolescent->userConfigurations()->where('key', 'notification_contact_finished_assignment')->firstOrFail()->value === '1') {
            SendPush::dispatch(
                'Uppdrag avklarat',
                'Något 1',
                'Ett uppdrag har markerats som avklarat!',
                true,
                1,
                collect([$adolescent]),
                ['Sambuh']
            )->onConnection('database')->onQueue('push');    
        }

        $globalStatuses = \App\UserRelationship::globalStatuses(\Auth::user(), $adolescent);
        $globalStatus   = $globalStatuses->where('key', 'done_assignment_amount_from_adolescent')->first();

        $globalStatus->update([
            'value' => ($globalStatus->value > "0") ? strval((int)$globalStatus->value - 1): "0",
        ]);

        $assignment = \App\Assignment::with(['assignmentCategory', 'assignmentForms', 'assignmentStatus'])->findOrFail($assignment->id);

        return response()->json($assignment, 200);
    }

    public function assignmentDeclined(Request $request, $id)
    {
        $operand            = \App\User::findOrFail(\Auth::id())->operands()->firstOrFail();
        $assignment         = \App\Assignment::with('assignmentStatus')->findOrFail($id);
        $userOperand        = $assignment->user()->firstOrFail()->operands()->firstOrFail();

        if (!is_null($assignment->finished_at)) {
            return response()->json('already_finished', 405);
        }

        if ($operand->id !== $userOperand->id) {
            return response()->json('mathod_not_allowed', 405);
        }

        $assignment->update([
            'accepted_at' => null
        ]);

        $now                = \Carbon\Carbon::now()->startOfDay();
        $endAt              = \Carbon\Carbon::parse($assignment->end_at);
        $daysUntilDeadline  = $now->diffInDays($endAt);

        if ($assignment->assignmentStatus->name !== 'Avslutat uppdrag') {
            if ($daysUntilDeadline === 0) {
                $assignment->update([
                    'assignment_status_id' => \App\AssignmentStatus::where('name', 'Deadline')->firstOrFail()->id,
                ]);
            } else if ($now > $endAt) {
                $assignment->update([
                    'assignment_status_id' => \App\AssignmentStatus::where('name', 'Passerad deadline')->firstOrFail()->id,
                ]);
            } else if ($daysUntilDeadline < 2) {
                $assignment->update([
                    'assignment_status_id' => \App\AssignmentStatus::where('name', 'Strax deadline')->firstOrFail()->id,
                ]);
            } else {
                $assignment->update([
                    'assignment_status_id' => \App\AssignmentStatus::where('name', 'I fas')->firstOrFail()->id,
                ]);
            }
        }

        $adolescent = \App\User::with('userConfigurations')->findOrFail($assignment->user_id);

        $globalStatuses = \App\UserRelationship::globalStatuses(\Auth::user(), $adolescent);
        $globalStatus   = $globalStatuses->where('key', 'done_assignment_amount_from_adolescent')->first();

        $globalStatus->update([
            'value' => ($globalStatus->value > "0") ? strval((int)$globalStatus->value - 1): "0",
        ]);

        $assignment = \App\Assignment::with(['assignmentCategory', 'assignmentForms', 'assignmentStatus'])->findOrFail($assignment->id);

        return response()->json($assignment, 200);
    }
}
