<?php

namespace App\Http\Livewire\Sys\Wallet\Group;

use Livewire\Component;

class Show extends Component
{
    public $menuState = null;
    public $submenuState = null;
    public $walletGroup = null;

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function mount($uuid)
    {
        $this->menuState = 'wallet';
        $this->submenuState = 'group';

        $this->walletGroup = \App\Models\WalletGroup::with('walletGroupList.parent')
            ->where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.sys.wallet.group.show')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentWalletGroup' => true,
            'componentWallet' => true
        ]);
    }
}
