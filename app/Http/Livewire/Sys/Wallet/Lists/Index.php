<?php

namespace App\Http\Livewire\Sys\Wallet\Lists;

use Livewire\Component;

class Index extends Component
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
        $this->dispatchBrowserEvent('wallet_list-init');

        return view('livewire.sys.wallet.lists.index')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentWallet' => true
        ]);
    }
}
