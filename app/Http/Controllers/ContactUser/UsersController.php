<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function index()
    {
        $users = \Auth::user()->operands()->firstOrFail()->users()->with([
            'userDetail',
            'userRole',
            'parentRelationships.parent',
            'childRelationships.child',
            'plan',
            'evaluations',
            'evaluations.evaluationStatus'
            ]
        )->get();

        return response()->json($users, 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'personal_identity_number'  => 'required|string|max:255',
            'first_name'                => 'required|string|max:255',
            'last_name'                 => 'required|string|max:255',
            'email'                     => 'required|string|max:255',
            'cell_phone_number'         => 'string|max:255|nullable',
            'user_role_id'              => 'required|integer'
        ]);

        $operand = \App\User::findOrFail(\Auth::id())->operands()->firstOrFail();
        $userRole = \App\UserRole::where('id', $request->input('user_role_id'))->firstOrFail();

        $user = \App\User::create([
            'personal_identity_number'  => $request->input('personal_identity_number'),
            'password'                  => bcrypt('secret'),
            'user_role_id'              => $userRole->id
        ]);

        \App\UserDetail::create([
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'email'             => $request->input('email'),
            'cell_phone_number' => $request->input('cell_phone_number'),
            'user_id'           => $user->id
        ]);

        if($userRole->name === 'CU'){
          \App\UserRelationship::create([
              'user_id' => $user->id
          ]);
        }

        // Adding configurations to user.
        $keys = [
            'email_adolescents_finished_assignment',
            'email_adolescents_sent_message',
            'email_reminder_for_monthly_evaluation',
            'notification_contact_new_assignment',
            'notification_contact_finished_assignment',
            'notification_contact_new_chat_message',
            'notification_contact_new_evaluation',
            'notification_assignment_end_date_near',
        ];

        foreach ($keys as $key) {
            \App\UserConfiguration::create([
                'key'       => $key,
                'value'     => false,
                'user_id'   => $user->id
            ]);
        }

        // Adding user to correct operand.
        $user->operands()->attach($operand->id);

        // Adding user to its own plan.
        $plan = \App\Plan::create([
            'name'          => 'Plan',
            'description'   => 'Alla ungdomar har en plan innehållande mål.',
            'user_id'       => $user->id,
        ]);

        $user = \App\User::with(['userDetail', 'userConfigurations'])->findOrFail($user->id);

        return response()->json($user, 200);
    }

    public function show($id)
    {
        $operand    = \Auth::user()->operands()->firstOrFail();
        $user       = $operand->users()->with([
            'operands',
            'plan',
            'assignments.assignmentStatus',
            'userConfigurations',
            'userDetail',
            'parentRelationships.parent.userDetail',
            'childRelationships.child.userDetail',
            'userRole'
        ])->findOrFail($id);

        return response()->json($user, 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'personal_identity_number'  => 'string|max:255',
            'first_name'                => 'string|max:255',
            'last_name'                 => 'string|max:255',
            'email'                     => 'string|max:255',
            'phone_number'              => 'string|max:255',
            'street_address'            => 'string|max:255',
            'zip_code'                  => 'string|max:255',
            'city'                      => 'string|max:255',
        ]);

        $user = \App\User::findOrFail($id);

        $user->update([
            'personal_identity_number' => $request->input('personal_identity_number')
        ]);

        \App\UserDetail::where('user_id', $id)->firstOrFail()->update($request->except('personal_identity_number'));

        $user = \App\User::with(['userDetail', 'userConfigurations'])->findOrFail($user->id);

        return response()->json($user, 200);
    }

    public function updateMe(Request $request)
    {
        $this->validate($request, [
            'personal_identity_number'              => 'string|max:255',
            'first_name'                            => 'string|max:255',
            'last_name'                             => 'string|max:255',
            'email'                                 => 'string|max:255',
            'cell_phone_number'                     => 'string|max:255|nullable',
            'street_address'                        => 'string|max:255',
            'zip_code'                              => 'string|max:255',
            'city'                                  => 'string|max:255',
            'image_uuid'                            => 'string|max:255',
            'email_adolescents_finished_assignment' => 'string|max:255',
            'email_adolescents_sent_message'        => 'string|max:255',
            'email_reminder_for_monthly_evaluation' => 'string|max:255'
        ]);

        $user = \App\User::findOrFail(\Auth::id());
        $fileObj = \App\File::where('uuid', $request->input('image_uuid'))->first();
        $file = [];

        if(!is_null($fileObj)){
            $file = [
                'image_url' => $fileObj->name . '.' . $fileObj->extension,
            ];
        } elseif ($request->input('image_uuid') === 'remove') {
            $file = [
                'image_url' => null,
            ];
        }

        $user->update($request->except(['first_name','last_name','email','cell_phone_number','street_address','zip_code','city']));

        \App\UserDetail::where('user_id', $user->id)->firstOrFail()->update($request->all() + $file);

        $userConfigurations = $user->userConfigurations()->get();

        foreach ($userConfigurations as $key => $userConfig) {
            $requested = $request->input($userConfig->key);

            if(!is_null($requested)){
                $userConfig->value = $requested;
                $userConfig->save();
            }
        }

        $user = $user->with(['userDetail', 'userConfigurations'])->findOrFail($user->id);

        return response()->json($user, 200);
    }

    public function destroy($id)
    {
        $operand        = \Auth::user()->operands()->firstOrFail();
        $user           = $operand->users()->where('id', $id)->firstOrFail();
        $user->delete();

        return response()->json($user, 200);
    }

    public function destroyMe()
    {
        $operand        = \Auth::user()->operands()->firstOrFail();
        $user           = $operand->users()->where('id', \Auth::id())->firstOrFail();
        $user->delete();

        return response()->json($user, 200);
    }

    public function assignments($user_id)
    {
        $operand        = \Auth::user()->operands()->firstOrFail();
        $user           = $operand->users()->where('id', $user_id)->firstOrFail();
        $assignments    = $user->assignments()->with(['assignmentCategory', 'assignmentStatus', 'assignmentForms'])->orderBy('created_at', 'desc')->get();

        return response()->json($assignments, 200);
    }

    public function plans($user_id)
    {
        $operand        = \Auth::user()->operands()->firstOrFail();
        $user           = $operand->users()->where('id', $user_id)->firstOrFail();
        $plan           = $user->plan()->with(['goals' => function($query) {
          return $query->orderBy('created_at', 'desc');
        }, 'goals.goalCategory', 'goals.goalStatus'])->firstOrFail();

        return response()->json($plan, 200);
    }

    public function goals($user_id)
    {
        $operand        = \Auth::user()->operands()->firstOrFail();
        $user           = $operand->users()->where('id', $user_id)->firstOrFail();
        $plan           = $user->plan()->firstOrFail();
        $goals          = $plan->goals()->with(['goalCategory', 'goalStatus'])->get();

        return response()->json($goals, 200);
    }

    public function evaluations($user_id)
    {
        $operand        = \Auth::user()->operands()->firstOrFail();
        $user           = $operand->users()->where('id', $user_id)->firstOrFail();
        $evaluations    = $user->evaluations()->with(['evaluationStatus', 'evaluationAnswers', 'evaluationAnswers.evaluationAnswerCategory', 'evaluationGoals', 'evaluationGoals.goal', 'evaluationGoals.goal.goalCategory', 'evaluationGoals.goal.goalStatus'])->orderBy('created_at', 'desc')->get();

        return response()->json($evaluations, 200);
    }

    public function chats($user_id)
    {
        $operand        = \Auth::user()->operands()->firstOrFail();
        $user           = $operand->users()->where('id', $user_id)->firstOrFail();
        $chat           = $user->chats()->with(['chatMessages', 'chatMessages.user.userDetail', 'chatMessages.user.userRole'])->firstOrFail();
        $users          = $chat->users()->with(['userDetail', 'userRole'])->get();
        $chat['users']  = $users;

        $adolescent = $user;
        $contact    = \Auth::user();

        $globalStatuses = \App\UserRelationship::globalStatuses($contact, $adolescent);
        $globalStatus   = $globalStatuses->where('key', 'new_message_amount_from_adolescent')->first();

        $globalStatus->update([
           'value' => 0,
        ]);

        return response()->json($chat, 200);
    }

    public function updateUserConfigurations()
    {
        $this->validate($request, [
            'key'   => 'required|string|max:255',
            'value' => 'required|string|max:255'
        ]);

        $userConfiguration = \App\User::findOrFail(\Auth::id())->userConfigurations()->where('key', $request->input('key'))->with('user')->firstOrFail();

        $userConfiguration->update($request->all());

        return response()->json($userConfiguration, 200);
    }

    public function finishedGoals($user_id, $goal_id)
    {
        $user       = \App\User::findOrFail($user_id);
        $evaluation = \App\Evaluation::where('user_id', $user->id)->latest()->firstOrFail();
        $goal       = \App\Goal::findOrFail($goal_id);

        if (!is_null($goal->finished_at)) {
            return response()->json('already_finished', 200);
        }

        $goal->update([
            'finished_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
        ]);

        $evaluationGoal = \App\EvaluationGoal::create([
            'goal_id'       => $goal->id,
            'evaluation_id' => $evaluation->id
        ]);

        return response()->json($goal, 200);
    }

    public function me()
    {
        $me = \App\User::with([
            'operands',
            'userConfigurations',
            'userDetail',
            'userRelationships',
            'userRelationships.parent',
            'userRole'
        ])->findOrFail(\Auth::id());

        return response()->json($me, 200);
    }

    public function globalStatuses()
    {
        $adolescents = \App\User::adolescents()->ofOperand(\Auth::user()->operands()->firstOrFail());

        return response()->json($adolescents, 200);
    }
}
