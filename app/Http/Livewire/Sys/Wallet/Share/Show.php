<?php

namespace App\Http\Livewire\Sys\Wallet\Share;

use Livewire\Component;

class Show extends Component
{
    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    // Data
    public $walletShareUuid = '';
    public $walletShareData;

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    // 

    /**
     * Livewire Mount
     */
    public function mount($uuid)
    {
        $this->menuState = 'wallet';
        $this->submenuState = 'share';

        $this->walletShareUuid = $uuid;
    }

    /**
     * Livewire Component Render
     */
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

    /**
     * Function
     */
    // 
}
