<?php

namespace App\Http\Livewire\Sys\Budget;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;
    public function mount()
    {
        $this->menuState = 'budget';
        $this->submenuState = null;
    }

    public function render()
    {
        return view('livewire.sys.budget.index')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
        ]);
    }
}
