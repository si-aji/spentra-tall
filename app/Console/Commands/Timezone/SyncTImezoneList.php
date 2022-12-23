<?php

namespace App\Console\Commands\Timezone;

use Illuminate\Console\Command;
use App\Http\Traits\Api\TimezoneTrait;

class SyncTImezoneList extends Command
{
    use TimezoneTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timezone:sync-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync saved list with Open API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $lists = \App\Models\Timezone\Timezone::get();

        try {
            $availableList = $this->getTimezoneList();
            if(count($lists) !== count($availableList)){
                foreach($availableList as $tz){
                    \App\Models\Timezone\Timezone::create([
                        'timezone' => $tz
                    ]);
                }

                $lists = \App\Models\Timezone\Timezone::get();
            }
        } catch(\Exception $exception){
            \Log::alert('Exception on Sync Timezone List ~ \App\Console\Commands\Timezone\SyncTimezoneList::handle', [
                'message' => $exception->getMessage()
            ]);
        }

        // Get Detail
        $filter = \App\Models\Timezone\Timezone::whereDoesntHave('timezoneDetail')->pluck('id')->toArray();
        foreach($lists as $list){
            try {
                if((isset($filter) && count($filter) > 0 && in_array($list->id, $filter)) || (!isset($filter) || count($filter) <= 0)){
                    $detail = $this->getTimezoneDetail($list->timezone);
                    \App\Models\Timezone\TimezoneDetail::updateOrCreate([
                        'timezone_id' => $list->id
                    ], [
                        'abbreviation' => $detail->abbreviation,
                        'utc_offset' => $detail->utc_offset,
                    ]);
                }
            } catch(\Exception $exception){
                \Log::alert('Exception on Sync Timezone Detail ~ \App\Console\Commands\Timezone\SyncTimezoneList::handle', [
                    'timezone' => $list,
                    'message' => $exception->getMessage()
                ]);
            }
        }

        return 0;
    }
}
