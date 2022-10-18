<?php

namespace App\Http\Livewire\Sys\Record\Template;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;
    public function mount()
    {
        $this->menuState = 'record-template';
    }

    public function render()
    {
        return view('livewire.sys.record.template.index')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentRecordTemplate' => true
        ]);
    }
}
