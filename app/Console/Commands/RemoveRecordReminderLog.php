<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RemoveRecordReminderLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:remove-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove record reminder log';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $maxDay = 0;
        $now = \Carbon\Carbon::now();
        // Get Limit
        $limit = $now->subDays($maxDay);
        // Get Data
        $data = \App\Models\RecordReminderLog::whereDate('sent_at', '<=', $limit)
            ->delete();

        return 0;
    }
}
