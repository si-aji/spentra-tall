<?php

namespace App\Http\Livewire\Adm\Dashboard;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;
    public function mount()
    {
        $this->menuState = 'dashboard';
        $this->submenuState = null;
    }

    public function render()
    {
        return view('livewire.adm.dashboard.index')->extends('layouts.sneat-adm', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
        ]);
    }
}
