<?php

namespace App\Http\Livewire\Sys\Wallet\Group;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;
    public function mount()
    {
        $this->menuState = 'wallet';
        $this->submenuState = 'group';
    }

    public function render()
    {
        $this->dispatchBrowserEvent('wallet_group_wire-init');

        return view('livewire.sys.wallet.group.index')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentWalletGroup' => true
        ]);
    }
}
