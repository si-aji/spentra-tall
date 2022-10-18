<?php

namespace App\Http\Livewire\Sys\Record\Template;

use Livewire\Component;

class Show extends Component
{
    public $recordTemplateData;
    public $recordTemplateUuid;

    public $menuState = null;
    public $submenuState = null;

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function mount($uuid)
    {
        $this->recordTemplateData = \App\Models\RecordTemplate::where('user_id', \Auth::user()->id)
            ->where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->recordTemplateUuid = $this->recordTemplateData->uuid;
        $this->menuState = 'record-template';
    }

    public function render()
    {
        return view('livewire.sys.record.template.show')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentRecordTemplate' => true
        ]);
    }
}
