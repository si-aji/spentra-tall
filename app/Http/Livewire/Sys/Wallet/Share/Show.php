<?php

namespace App\Http\Livewire\Sys\Wallet\Share;

use Livewire\Component;

class Show extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // Data
    public $walletShareUuid = '';
    public $walletShareData;

    public function mount($uuid)
    {
        $this->menuState = 'wallet';
        $this->submenuState = 'share';

        $this->walletShareUuid = $uuid;
    }

    public function render()
    {
        $this->walletShareData = \App\Models\WalletShare::where('user_id', \Auth::user()->id)
            ->where(\DB::raw('BINARY `uuid`'), $this->walletShareUuid)
            ->firstOrFail();

        return view('livewire.sys.wallet.share.show')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentWalletShare' => true
        ]);
    }
}
