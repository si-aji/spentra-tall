<?php

namespace App\Http\Livewire\Adm\LogViewer;

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
    // 

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    // protected $listeners = [];

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->menuState = 'log-viewer';
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        return view('livewire.adm.log-viewer.index')->extends('layouts.sneat-adm', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
        ]);
    }

    /**
     * Function
     */
}
