<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Reminder;

class ReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks into database every 5 mins and sends reminder email to user.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $reminders = Reminder::where("status",0)
                               ->where("reminder_time","<=",time())
                               ->get();
     
       if($reminders){
        foreach($reminders as $reminder){
          $trial = \App\Trial::find($reminder->trial_id);
         
          $link = url('user/trial/'.$trial->id);
          $message = 'This is a reminder for you to apply for a trial.<br/>';
          $message .= 'You are receiving this email because you asked us to remind you later. Please click on the link below to apply for the study.<br/>';
          $message .= '<a href="'.$link.'">'.$trial->title.'</a>';
         
          send_notification($reminder->user_id,$message);
          delete_reminder($reminder->id);
        }
       }
    }
}
