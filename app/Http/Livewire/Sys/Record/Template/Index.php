<?php

namespace App\Http\Livewire\Sys\Record\Template;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    // Load More Conf
    public $loadPerPage = 10;
    // List Data
    public $dataRecordTemplate;

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
    public function mount()
    {
        $this->menuState = 'record-template';
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->dataRecordTemplate = \App\Models\RecordTemplate::where('user_id', \Auth::user()->id);
        $paginate = $this->dataRecordTemplate->paginate($this->loadPerPage);
        $this->dataRecordTemplate = collect($this->dataRecordTemplate->paginate($this->loadPerPage)->items());

        $this->dispatchBrowserEvent('recordTemplateLoadData');

        return view('livewire.sys.record.template.index', [
            'paginate' => $paginate
        ])->extends('layouts.sneat', [
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
