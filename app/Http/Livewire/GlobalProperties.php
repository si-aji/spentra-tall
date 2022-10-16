<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GlobalProperties extends Component
{
    public $menuState = null;
    public $submenuState = null;

    public $user_timezone = '';
    public $user_timezone_offset = '';
    protected $listeners = [
        'setUserTimezone' => 'setUserTimezone',
    ];

    public function mount()
    {
        // 
    }

    public function render()
    {
        return view('livewire.global-properties');
    }

    public function setUserTimezone($tz, $offset)
    {
        \Log::debug("A");

        $this->user_timezone = $tz;
        $this->user_timezone_offset = $offset;
        \Session::put('SAUSER_TZ', $this->user_timezone);
        \Session::put('SAUSER_TZ_OFFSET', $this->user_timezone_offset);
    }
}
