<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use aapi\Jobs\SendMail;
use aapi\Jobs\SendPush;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**
         * 1.
         * Created mounthly evaluations for each adolescent.
         * Runs every month on the 1th 00:00.
         */
        $schedule->call(function () {
            $adolescents        = \App\User::adolescents()->with('userConfigurations')->get();
            $evaluationStatus   = \App\EvaluationStatus::where('name', 'Dags för utvärdering')->firstOrFail();
            $month              = Carbon::now()->format('M');

            foreach ($adolescents as $key => $adolescent) {
                $evaluation = \App\Evaluation::create([
                    'name'                  => $month,
                    'description'           => 'Monthly evaluation for ' . $month,
                    'color'                 => null,
                    'user_id'               => $adolescent->id,
                    'evaluation_status_id'  => $evaluationStatus->id,
                ]);

                if ($adolescent->userConfigurations->where('key', 'notification_contact_new_evaluation')->first()->value === '1') {
                    SendPush::dispatch(
                        'Månadskollen',
                        'En ny månadskoll finns nu tillgänglig',
                        'En ny månadskoll finns nu tillgänglig',
                        true,
                        1,
                        collect([$adolescent]),
                        ['Sambuh']
                    )->onConnection('database')->onQueue('push');
                }
            }

        })->monthlyOn(1, '00:00');

        /**
         * 2.
         * Sends email to each contact user and tells them that there's a monthly evaluation.
         * Runs every month on the 1th 00:00.
         */
        $schedule->call(function () {
            $contacts = \App\User::contacts()->with(['userDetail', 'userConfigurations'])->get();

            foreach ($contacts as $key => $contact) {
                $configurations = $contact->userConfigurations->where('key', 'email_reminder_for_monthly_evaluation');

                foreach ($configurations as $key2 => $configuration) {
                    $userDetail = $configuration->user()->firstOrFail()->userDetail()->firstOrFail();

                    if ($configuration->value) {
                        $args = [
                            'url'       => env('APP_URL_SERVICE_1'),
                            'firstName' => $userDetail->first_name,
                            'icon'      => env('APP_URL') . '/images/icon_calendar.png',
                        ];

                        SendMail::dispatch(
                            $userDetail->email,
                            $userDetail->full_name,
                            'Notifikation',
                            'newevaluationready',
                            $args
                        )->onConnection('database')->onQueue('email');
                    }
                }
            }
        })->monthlyOn(1, '00:10');

        /**
         * 3.
         * Checks and changes (if needed) the status of assignments.
         * Runs every day at 00:00.
         */
        $schedule->call(function () {
            $assignments = \App\Assignment::with('assignmentStatus')->get();

            foreach ($assignments as $key => $assignment) {
                $daysUntilDeadline = Carbon::now()->diffInDays(Carbon::parse($assignment->end_at), false);

                if ($assignment->assignmentStatus->name !== 'Avslutat uppdrag') {
                    if ($assignment->assignmentStatus->name === 'I fas' && $daysUntilDeadline <= 2) {
                        $assignment->update([
                            'assignment_status_id' => \App\AssignmentStatus::where('name', 'Strax deadline')->firstOrFail()->id,
                        ]);

                        $adolescent = \App\Adolescent::with('userConfigurations')->findOrFail($assignment->id);

                        if ($adolescent->userConfigurations->where('key', 'notification_assignment_end_date_near')->first()->value) {
                            SendPush::dispatch(
                                'Slutdatum närmar sig',
                                'Slutdatumet för ett uppdrag närmar sig',
                                'Slutdatumet för ett uppdrag närmar sig',
                                true,
                                1,
                                collect([$adolescent]),
                                ['Sambuh']
                            )->onConnection('database')->onQueue('push');
                        }
                    } else if ($daysUntilDeadline === 0) {
                        $assignment->update([
                            'assignment_status_id' => \App\AssignmentStatus::where('name', 'Deadline')->firstOrFail()->id,
                        ]);
                    } else if ($assignment->assignmentStatus->name === 'Deadline' && $daysUntilDeadline !== 0) {
                        $assignment->update([
                            'assignment_status_id' => \App\AssignmentStatus::where('name', 'Passerad deadline')->firstOrFail()->id,
                        ]);
                    } else if ($assignment->assignmentStatus->name === 'Nytt') {
                        if ($daysUntilDeadline > 2) {
                            $assignment->update([
                                'assignment_status_id' => \App\AssignmentStatus::where('name', 'I fas')->firstOrFail()->id,
                            ]);
                        } else if ($daysUntilDeadline <= 2 && $daysUntilDeadline >= 1) {
                            $assignment->update([
                                'assignment_status_id' => \App\AssignmentStatus::where('name', 'Strax deadline')->firstOrFail()->id,
                            ]);
                        } else if ($daysUntilDeadline === 0) {
                            $assignment->update([
                                'assignment_status_id' => \App\AssignmentStatus::where('name', 'Deadline')->firstOrFail()->id,
                            ]);
                        } else {
                            $assignment->update([
                                'assignment_status_id' => \App\AssignmentStatus::where('name', 'Passerad deadline')->firstOrFail()->id,
                            ]);
                        }
                    }
                }
            }
        })->dailyAt('00:00');

        /**
         * 4.
         * Checks and changes (if needed) the status of goals.
         * Runs every day at 00:00.
         */
        $schedule->call(function () {
            $goals = \App\Goal::with('goalStatus')->get();

            foreach ($goals as $key => $goal) {
                $daysUntilDeadline = Carbon::now()->diffInDays(Carbon::parse($goal->end_at), false);

                if ($goal->goalStatus->name !== 'Avklarat') {
                    if ($goal->goalStatus->name === 'I fas' && $daysUntilDeadline <= 2) {
                        $goal->update([
                            'goal_status_id' => \App\GoalStatus::where('name', 'Strax deadline')->firstOrFail()->id,
                        ]);
                    } else if ($daysUntilDeadline === 0) {
                        $goal->update([
                            'goal_status_id' => \App\GoalStatus::where('name', 'Deadline')->firstOrFail()->id,
                        ]);
                    } else if ($goal->goalStatus->name === 'Deadline' && $daysUntilDeadline !== 0) {
                        $goal->update([
                            'goal_status_id' => \App\GoalStatus::where('name', 'Passerad deadline')->firstOrFail()->id,
                        ]);
                    } else if ($goal->goalStatus->name === 'Nytt') {
                        if ($daysUntilDeadline > 2) {
                            $goal->update([
                                'goal_status_id' => \App\GoalStatus::where('name', 'I fas')->firstOrFail()->id,
                            ]);
                        } else if ($daysUntilDeadline <= 2 && $daysUntilDeadline >= 1) {
                            $goal->update([
                                'goal_status_id' => \App\GoalStatus::where('name', 'Strax deadline')->firstOrFail()->id,
                            ]);
                        } else if ($daysUntilDeadline === 0) {
                            $goal->update([
                                'goal_status_id' => \App\GoalStatus::where('name', 'Deadline')->firstOrFail()->id,
                            ]);
                        } else {
                            $goal->update([
                                'goal_status_id' => \App\GoalStatus::where('name', 'Passerad deadline')->firstOrFail()->id,
                            ]);
                        }
                    }
                }
            }
        })->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
