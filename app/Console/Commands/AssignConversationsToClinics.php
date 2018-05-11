<?php

namespace App\Console\Commands;

use App\Clinic;
use App\Conversation;
use Illuminate\Console\Command;
use Illuminate\Foundation\Auth\User;

class AssignConversationsToClinics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conversations:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates existing conversations to point to their clinics.';

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
        $conversations = Conversation::all();
        foreach ($conversations as $conversation)
        {
            $clinic = Clinic::where("id", $conversation->clinic_id)->first();
            if($clinic == null)
            {
                $user_a = User::where("id", $conversation->user_a)->first();
                $user_b = User::where("id", $conversation->user_b)->first();
                $clinic = Clinic::where("id", $user_a->clinic_id)->first();
                if($clinic == null)
                {
                    $clinic = Clinic::where("id", $user_b->clinic_id)->first();
                }
                if($clinic != null)
                {
                    $conversation->clinic_id = $clinic->id;
                    $conversation->save();
                }
            }
        }
    }
}
