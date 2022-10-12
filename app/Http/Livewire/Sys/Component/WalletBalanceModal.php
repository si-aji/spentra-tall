<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class WalletBalanceModal extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // Modal
    public $walletBalanceModalState = 'hide';

    // Form Field
    public $walletBalance = null;

    public $walletResetField = [];
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
        'store' => 'store',
        // 'localUpdate' => 'localUpdate',
        'editAction' => 'editAction'
    ];

    public function mount()
    {
        $this->walletResetField = [
            'walletBalance',
            'walletBalanceModalState'
        ];
    }

    public function render()
    {
        $this->dispatchBrowserEvent('wallet_balance_wire-init');
        return view('livewire.sys.component.wallet-balance-modal');
    }

    /**
     * Handle edit request data
     */
    public function editAction($uuid)
    {
        $data = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->walletBalance = $data;

        $this->dispatchBrowserEvent('wallet_balance_wire-modalShow');
    }
    public function store()
    {
        
    }

    // Handle Modal
    public function openModal()
    {
        $this->walletBalanceModalState = 'show';
    }
    public function closeModal()
    {
        $this->walletBalanceModalState = 'hide';
    }
}
