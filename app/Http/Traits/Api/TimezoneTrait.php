<?php

namespace App\Http\Traits\Api;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

trait TimezoneTrait
{
    public $basepath = 'https://worldtimeapi.org/api';

    /**
     * 
     */
    public function getTimezoneList()
    {
        $response = Http::withoutVerifying()
            ->withOptions(['verify'=>false])
            ->get($this->basepath.'/timezone');
        return $response->object();
    }

    public function getTimezoneDetail($tz, $result = 'object')
    {
        $response = Http::withoutVerifying()
            ->withOptions(['verify'=>false])
            ->get($this->basepath.'/timezone'.'/'.$tz);

        if($result === 'json'){
            return $response->json();
        }
        return $response->object();
    }
}