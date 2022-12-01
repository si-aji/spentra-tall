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


        $this->dispatchBrowserEvent('walletGroupShow-loadData');
        $this->dispatchBrowserEvent('walletGroupShowRecordLoadData');
        return view('livewire.sys.wallet.group.show', [
            'paginate' => $recordLivewire->getPaginate()
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
