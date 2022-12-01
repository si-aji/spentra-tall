<?php

namespace App\Http\Livewire\Sys\Record\Template;

use Livewire\Component;

class Show extends Component
{
    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    public $recordTemplateData,
        $recordTemplateUuid;

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    /**
     * Livewire Mount
     */
    public function mount($uuid)
    {
        $this->recordTemplateData = \App\Models\RecordTemplate::where('user_id', \Auth::user()->id)
            ->where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->recordTemplateUuid = $this->recordTemplateData->uuid;
        $this->menuState = 'record-template';
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        return view('livewire.sys.record.template.show')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentRecordTemplate' => true
        ]);
    }

    /**
     * Function
     */
    // 
}
