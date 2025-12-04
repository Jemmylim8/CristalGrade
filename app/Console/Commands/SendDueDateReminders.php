<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Score;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\ActivityDueDateReminder;
use Carbon\Carbon;

class SendDueDateReminders extends Command
{
    // Command signature
    protected $signature = 'send:duedate-reminders';

    // Command description
    protected $description = 'Send reminders to students for activities due today or past due and not yet scored';

    public function handle()
    {
        $now = Carbon::now();

        // Get all scores with null value, reminder not sent, and activity with due date <= now
        $scoresToRemind = Score::with(['student', 'activity.class'])
            ->whereNull('score')
            ->where('reminder_sent', false)
            ->whereHas('activity', function($q) use ($now) {
                $q->whereNotNull('due_date')
                  ->where('due_date', '<=', $now);
            })
            ->get();

        Log::info('SendDueDateReminders started. Scores to remind: ' . $scoresToRemind->count());

        foreach ($scoresToRemind as $score) {
            $studentEmail = $score->student->email ?? 'unknown';
            $activityName = $score->activity->name ?? 'unknown';

            // Log which emails would be sent
            Log::info("Preparing to send reminder to {$studentEmail} for activity {$activityName}");

            // Uncomment when mail config is ready
            foreach ($scoresToRemind as $score) {
                \Mail::to($score->student->email)
                    ->send(new \App\Mail\ActivityDueDateReminder(
                        $score->student,
                        $score->activity,
                        $score->activity->class
                    ));

                // Mark reminder as sent
                $score->reminder_sent = true;
                $score->save();
            }


            // Mark reminder as sent
            $score->reminder_sent = true;
            $score->save();
        }

        $this->info('Due-date reminders processed. Total: ' . $scoresToRemind->count());
        Log::info('SendDueDateReminders finished.');
    }
}
