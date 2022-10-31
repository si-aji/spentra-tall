<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class WalletShareModal extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // List / Select
    public $listWallet;

    // Modal
    public $walletShareModalState = 'hide';
    public $walletShareTitle = 'Add new';

    public $walleShareResetField = [];
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
    ];

    public function fetchMainWallet()
    {
        // Wallet
        $this->listWallet = \App\Models\Wallet::with('child', 'parent')
            ->where('user_id', \Auth::user()->id)
            ->whereNull('parent_id')
            ->orderBy('order_main', 'asc')
            ->get();
    }
    public function mount()
    {
        // 
    }

    public function render()
    {
        $this->fetchMainWallet();
        $this->dispatchBrowserEvent('wallet_share_wire-init');

        return view('livewire.sys.component.wallet-share-modal');
    }

    // Handle Modal
    public function openModal()
    {
        $this->walletShareModalState = 'show';
    }
    public function closeModal()
    {
        $this->walletShareModalState = 'hide';
        $this->reset($this->walleShareResetField);
    }
}
