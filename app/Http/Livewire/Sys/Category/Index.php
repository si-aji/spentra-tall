<?php

namespace App\Http\Livewire\Sys\Category;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;
    public function mount()
    {
        $this->menuState = 'category';
    }

    public function render()
    {
        return view('livewire.sys.category.index')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState
        ]);
    }
}
