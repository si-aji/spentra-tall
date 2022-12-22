<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UserRecordReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:user-record';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remind related user to create daily record';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::debug("User Record Reminder successfully running at ".(date('Y-m-d H:i:s')));
        // Date Now
        $now = \Carbon\Carbon::now();

        \App\Models\User::whereDoesntHave('recordReminderLog', function($q) use ($now){
                return $q->whereDate('sent_at', (clone $now)->format('Y-m-d'));
            })
            ->whereHas('userPreference', function($q){
                return $q->where('key', 'record-reminder');
            })->chunk(50, function($users) use ($now){
                foreach($users as $user){
                    // Get Timezone
                    $tz = 'UTC';
                    if(!empty($user->getSpecificUserPreference('timezone'))){
                        $tz = $user->getSpecificUserPreference('timezone')->value;
                    }
                    // Convert to related timezone
                    $convertedNow = (clone $now)->setTimezone($tz);

                    // Get Reminder Time
                    $reminder = date("H:i");
                    if(!empty($user->getSpecificUserPreference('record-reminder'))){
                        $reminder = date('H:i', strtotime($user->getSpecificUserPreference('record-reminder')->value));
                    }
                    $reminder = \Carbon\Carbon::createFromFormat('H:i', $reminder)
                        ->shiftTimezone($tz);
                    // Reminder in UTC
                    $reminderInUtc = (clone $reminder)->setTimezone('UTC');

                    $diff = $convertedNow->diffInSeconds($reminder);
                    if($reminder > $convertedNow && $diff <= 60){
                        // Add related data to Reminder Log
                        \App\Models\RecordReminderLog::create([
                            'user_id' => $user->id,
                            'sent_at' => $now
                        ]);
                        // Register queue
                        dispatch(new \App\Jobs\SendDailyRecordReminder($user))->delay($reminderInUtc);
                    }
                }
            });

        return 0;
    }
}
