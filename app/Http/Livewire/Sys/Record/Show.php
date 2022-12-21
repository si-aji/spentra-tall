<?php

namespace App\Http\Livewire\Sys\Record;

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
    public $recordData,
        $recordUuid;

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'removeData' => 'removeData'
    ];

    /**
     * Livewire Mount
     */
    public function mount($uuid)
    {
        $this->recordData = \App\Models\Record::with('wallet.parent', 'walletTransferTarget.parent', 'category.parent', 'recordTags')
            ->where('user_id', \Auth::user()->id)
            ->where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->recordUuid = $this->recordData->uuid;
        $this->menuState = 'record';
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        return view('livewire.sys.record.show')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
        ]);
    }

    /**
     * Function
     */
    // Remove Data
    public function removeData($uuid)
    {
        return (new \App\Http\Livewire\Sys\Record\Index())->removeData($uuid);
    }
}
