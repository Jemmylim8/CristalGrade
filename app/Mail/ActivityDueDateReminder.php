<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivityDueDateReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $activity;
    public $class;

    public function __construct($student, $activity, $class)
    {
        $this->student = $student;
        $this->activity = $activity;
        $this->class = $class;
    }

    public function build()
    {
        return $this->subject('Reminder: Activity Due Date Approaching')
                    ->view('emails.activity_due_date_reminder');
    }
}
