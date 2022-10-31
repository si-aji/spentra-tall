<?php

namespace App\Http\Livewire\Sys\Wallet\Share;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;

    public function mount()
    {
        $this->menuState = 'wallet';
        $this->submenuState = 'share';
    }

    public function render()
    {
        return view('livewire.sys.wallet.share.index')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentWalletShare' => true
        ]);
    }
}
