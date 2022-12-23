<?php

namespace App\Http\Livewire\Sys\Profile\Preference;

use Livewire\Component;

class Index extends Component
{
    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    public $extraMenu = [];
    public $timezone_list = null;
    public $timezone_selected = null;
    public $timezone_detail = null;
    public $reminder = null;
    // Reset Field
    public $preferenceResetField = [];
    // Field
    public $preferenceKey = null;
    public $preferenceValue = null;

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'timezoneDetail' => 'timezoneDetail',
    ];

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->menuState = 'profile';
        $this->submenuState = 'preference';

        $this->tagResetField = [
            'preferenceKey',
            'preferenceValue',
        ];

        // Extra Menu
        $extraMenu = collect(config('siaji.sys.sidebar'))
            ->where('name', 'Profile')
            ->first();

        // Get Timezone List
        $this->timezone_list = \App\Models\Timezone\Timezone::get();

        if(!empty($extraMenu) && count($extraMenu['sub']) > 0){
            foreach($extraMenu['sub'] as $menu){
                $this->extraMenu[] = $menu;
            }
        }
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        if(\Auth::check() && get_class(\Auth::user()) === get_class((new \App\Models\User()))){
            // Get Default Timezone
            if(!empty(\Auth::user()->getSpecificUserPreference('timezone'))){
                $this->timezone_selected = \Auth::user()->getSpecificUserPreference('timezone')->value;
                $this->timezone_detail = \App\Models\Timezone\TimezoneDetail::with('timezone')->whereHas('timezone', function($q){
                    return $q->where('timezone', $this->timezone_selected);
                })->first();
                $this->timezone_detail = collect($this->timezone_detail);
                $this->dispatchBrowserEvent('getTimezoneDetail');
            }

            // Get Default Reminder Time
            if(!empty(\Auth::user()->getSpecificUserPreference('record-reminder'))){
                $this->reminder = \Auth::user()->getSpecificUserPreference('record-reminder')->value;
            }
        }

        return view('livewire.sys.profile.preference.index')
            ->extends('layouts.sneat', [
                'menuState' => $this->menuState,
                'submenuState' => $this->submenuState
            ]);
    }

    /**
     * Function
     */
    public function save()
    {
        $this->validate([
            'preferenceKey' => ['required', 'string'],
            'preferenceValue' => ['nullable', 'string']
        ]);

        \DB::transaction(function () {
            $data = \App\Models\UserPreference::updateOrCreate([
                'user_id' => \Auth::user()->id,
                'key' => $this->preferenceKey
            ], [
                'value' => $this->preferenceValue
            ]);
        });

        $this->reset($this->tagResetField);
        $this->emit('refreshComponent');
    }
    public function timezoneList()
    {
        return \App\Models\Timezone\Timezone::get();
    }
}
