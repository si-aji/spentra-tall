<?php

namespace App\Http\Livewire\Sys\Wallet\Group;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    // Load More Conf
    public $loadPerPage = 10;
    // List Data
    public $dataWalletGroup;
    protected $paginateWalletGroup;

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
    public function mount()
    {
        $this->menuState = 'wallet';
        $this->submenuState = 'group';
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->fetchWalletGroupData();
        $this->dispatchBrowserEvent('wallet_group_index_wire-init');

        return view('livewire.sys.wallet.group.index', [
            'paginate' => $this->paginateWalletGroup
        ])->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentWalletGroup' => true
        ]);
    }

    /**
     * Function
     */
    public function loadMore()
    {
        $this->loadPerPage += $this->loadPerPage;
    }
    public function hydrate()
    {
        $this->dispatchBrowserEvent('loadDataSkeleton');
    }
    public function fetchWalletGroupData() : void
    {
        $this->dataWalletGroup = \App\Models\WalletGroup::with('walletGroupList.parent')
            ->where('user_id', \Auth::user()->id);

        // Apply Filter

        $this->dataWalletGroup = $this->dataWalletGroup->get();
        // Fetch data and paginate
        $this->paginateWalletGroup = $this->dataWalletGroup->paginate($this->loadPerPage);
        $this->dataWalletGroup = (collect($this->dataWalletGroup->paginate($this->loadPerPage)->items())->map(function($data){
            $data->balance = $data->getBalance();
            return $data;
        }))->values();
    }
}
