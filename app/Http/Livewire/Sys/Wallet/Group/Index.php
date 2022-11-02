<?php

namespace App\Http\Livewire\Sys\Wallet\Group;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $menuState = null;
    public $submenuState = null;

    // Load More Conf
    public $loadPerPage = 10;

    // List Data
    public $dataWalletGroup;
    protected $paginateWalletGroup;

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function mount()
    {
        $this->menuState = 'wallet';
        $this->submenuState = 'group';
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

    /**
     * Render component livewire view
     * 
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

    public function loadMore()
    {
        $this->loadPerPage += $this->loadPerPage;
    }
}
