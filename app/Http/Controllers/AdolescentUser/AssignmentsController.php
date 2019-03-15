<?php

namespace App\Http\Controllers\AdolescentUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Jobs\SendMail;

class AssignmentsController extends Controller
{
    public function index()
    {
        $assignments = \App\User::findOrFail(\Auth::id())->assignments()->with([
            'assignmentCategory',
            'assignmentStatus',
            'assignmentForms'
        ])->get();

        $globalStatuses = \Auth::user()->globalStatuses()->where('key', 'new_assignment_amount_from_contact')->get();

        foreach ($globalStatuses as $key => $globalStatus) {
            $globalStatus->update([
               'value' => 0,
            ]);
        }

        return response()->json($assignments, 200);
    }

    public function assignmentDone(Request $request, $id)
    {
        $this->validate($request, [
            'answer'        => 'string|max:65535|nullable',
            'image_uuid'    => 'string|max:255|nullable',
        ]);

        $assignment         = \App\Assignment::findOrFail($id);
        $assignmentStatus   = \App\AssignmentStatus::where('name', 'Inväntar godkännande')->firstOrFail();

        if ($assignment->user_id !== \Auth::id()) {
            return response()->json('not_mine', 405);
        }

        if (!is_null($assignment->finished_at)) {
            return response()->json('already_finished', 405);
        }

        $file = \App\File::where('uuid', $request->input('image_uuid'))->first();
        $fileName = null;

        if(!is_null($file)){
            $fileName = $file->name . '.' . $file->extension;
        }

        $assignment->update([
            'answer'                => $request->input('answer'),
            'accepted_at'           => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'image_url'             => $fileName,
            'assignment_status_id'  => $assignmentStatus->id
        ]);

        $assignment = \App\Assignment::with(['assignmentCategory', 'assignmentForms', 'assignmentStatus'])->findOrFail($assignment->id);

        $user = \App\User::with('userDetail')->findOrFail(\Auth::id());
        $parentRelationships = $user->with(['parentRelationships.parent.userConfigurations', 'parentRelationships.parent.userDetail'])->where('id', $user->id)->firstOrFail()->parentRelationships;

        foreach ($parentRelationships as $key => $parentRelationship) {
            $configuration = $parentRelationship->parent->userConfigurations->where('key', 'email_adolescents_finished_assignment')->first();

            if ($configuration->value === '1') {
                $args = [
                    'url'       => env('APP_URL_SERVICE_1'),
                    'firstName' => $parentRelationship->parent->userDetail->first_name,
                    'icon'      => env('APP_URL') . '/images/icon_book.png',
                ];

                SendMail::dispatch(
                    $parentRelationship->parent->userDetail->email,
                    $parentRelationship->parent->userDetail->full_name,
                    'Notifikation',
                    'assignmentmarkeddone',
                    $args
                )->onConnection('database')->onQueue('email');
            }
        }

        $adolescent = \Auth::user();
        $contact    = $parentRelationship->parent;

        $globalStatuses = \App\UserRelationship::globalStatuses($contact, $adolescent);
        $globalStatus   = $globalStatuses->where('key', 'done_assignment_amount_from_adolescent')->first();

        $globalStatus->update([
            'value' => strval((int)$globalStatus->value + 1),
        ]);

        return response()->json($assignment, 200);
    }
}
