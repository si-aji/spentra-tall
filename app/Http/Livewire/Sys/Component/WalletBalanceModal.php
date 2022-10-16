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
    public $walletBalanceData = null;
    public $walletBalance = null;
    public $walletActualBalance = null;
    public $user_timezone = null;
    public $recordPeriod = '';

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
            'walletBalanceModalState',
            'walletBalanceData',
            'walletBalance',
            'walletActualBalance',
            'user_timezone',
            'recordPeriod'
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
        $this->walletBalanceData = $data;
        $this->walletBalance = $data->getBalance();
        $this->walletActualBalance = $data->getBalance();

        $this->dispatchBrowserEvent('wallet_balance_wire-modalShow');
    }
    public function store()
    {
        // if($this->walletBalance == $this->walletActualBalance){
        //     throw \Illuminate\Validation\ValidationException::withMessages([
        //         'walletActualBalance' => 'Nothing changed'
        //     ]);
        // }

        if($this->walletBalance != $this->walletActualBalance){
            \DB::transaction(function () {
                $record = new \App\Http\Livewire\Sys\Component\RecordModal();
                $record->recordWallet = $this->walletBalanceData->uuid;
                $record->recordType = $this->walletActualBalance > $this->walletBalance ? 'income' : 'expense';
                $record->recordAmount = $this->walletActualBalance > $this->walletBalance ? ($this->walletActualBalance - $this->walletBalance) : ($this->walletBalance - $this->walletActualBalance);
                $record->user_timezone = $this->user_timezone;
                $record->recordPeriod = $this->recordPeriod;
                $record->recordNote = 'Wallet Balance adjustment';
                $record->store();
            });
        }

        $this->reset($this->walletResetField);
        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully update Wallet Balance'
        ]);
        $this->dispatchBrowserEvent('wallet_balance_wire-modalHide');
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
