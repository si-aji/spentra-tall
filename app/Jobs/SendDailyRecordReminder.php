<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendDailyRecordReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'title' => 'Daily Reminder',
            'message' => 'How\'s your day, don\'t forget to add your daily record',
            'actions' => [
                [
                    'title' => 'Open App',
                    'route' => route('sys.index')
                ]
            ],
            'data' => [
                'id' => 'record-reminder',
                'url' => route('sys.record.index')
            ]
        ];

        \Log::debug("Debug on SendDailyRecordReminder Jobs ~ ".(date('Y-m-d H:i:s')), [
            'data' => $data
        ]);

        // Sample Notification
        $notification = new \App\Notifications\Push\WebPushNotification($data);
        \Illuminate\Support\Facades\Notification::send($this->user, $notification);
    }
}
