<?php

namespace App\Http\Livewire\Sys\Record;

use Livewire\Component;

class Show extends Component
{
    public $recordData;
    public $recordUuid;

    public $menuState = null;
    public $submenuState = null;
    public function mount($uuid)
    {
        $this->recordData = \App\Models\Record::where('user_id', \Auth::user()->id)
            ->where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->recordUuid = $this->recordData->uuid;
        $this->menuState = 'record';
    }

    public function render()
    {
        return view('livewire.sys.record.show')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
        ]);
    }
}
