<?php

namespace App\Http\Livewire\Sys\Wallet\Group;

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
    public $walletGroup = null;
    public $walletGroupUuid = null;
    // Paginate
    public $loadPerPage = 10;
    // Record
    public $walletRecordData;
    // Wallet
    public $dataWallet;

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    /**
     * Livewire Mount
     */
    public function mount($uuid)
    {
        $this->menuState = 'wallet';
        $this->submenuState = 'group';

        $this->walletGroupUuid = $uuid;
        $this->walletGroup = \App\Models\WalletGroup::with('walletGroupList.parent')
            ->where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $recordLivewire = new \App\Http\Livewire\Sys\Record\Index();
        $recordLivewire->loadPerPage = $this->loadPerPage;
        $recordLivewire->fetchRecordData($this->walletGroup->walletGroupList()->pluck((new \App\Models\Wallet())->getTable().'.id')->toArray());
        $this->walletRecordData = $recordLivewire->dataRecord;

        // Fetch Wallet Data
        $this->dataWallet = \App\Models\Wallet::with('parent')
            ->where('user_id', \Auth::user()->id)
            ->whereIn('id', $this->walletGroup->walletGroupList()->pluck((new \App\Models\Wallet())->getTable().'.id')->toArray())
            ->orderBy('order_main', 'asc');
        $this->dataWallet = $this->dataWallet->paginate($this->loadPerPage);
        $paginateWallet = $this->dataWallet;
        $this->dataWallet = collect($this->dataWallet->items())->values()->map(function($data){
            $data->balance = $data->getBalance();
            $data->last_transaction = $data->getLastTransaction();
            return $data;
        });

        $this->dispatchBrowserEvent('walletListLoadData');
        $this->dispatchBrowserEvent('walletGroupShow-loadData');
        $this->dispatchBrowserEvent('walletGroupShowRecordLoadData');
        return view('livewire.sys.wallet.group.show', [
            'paginate' => $recordLivewire->getPaginate(),
            'paginateWallet' => $paginateWallet
        ])->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentWalletGroup' => true,
            'componentWallet' => true
        ]);
    }

    /**
     * Function
     */
    public function loadMore()
    {
        $this->loadPerPage += $this->loadPerPage;
    }
}
