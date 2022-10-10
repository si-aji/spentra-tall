<?php

namespace App\Http\Livewire\Sys\Wallet\Lists;

use Livewire\Component;

class ReOrder extends Component
{
    public $menuState = null;
    public $submenuState = null;
    public function mount()
    {
        $this->menuState = 'wallet';
        $this->submenuState = 'list';
    }

    public function render()
    {
        return view('livewire.sys.wallet.lists.re-order')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentWallet' => true
        ]);
    }
}
