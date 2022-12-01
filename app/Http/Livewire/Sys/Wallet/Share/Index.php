<?php

namespace App\Http\Livewire\Sys\Wallet\Share;

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
    public $dataWalletShare;
    protected $paginateWalletShare;
    // Filter Data
    public $filterWalletShareNote = '';
    // Sort Data
    public $sortKeyWalletShare = 'created_at';
    public $sortTypeWalletShare = 'desc';

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
        $this->submenuState = 'share';
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->fetchWalletShareData();
        $this->dispatchBrowserEvent('wallet_share_index_wire-init');

        return view('livewire.sys.wallet.share.index', [
            'paginate' => $this->paginateWalletShare
        ])->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentWalletShare' => true
        ]);
    }

    /**
     * Function
     */
    public function fetchWalletShareData() : void
    {
        $this->dataWalletShare = \App\Models\WalletShare::with('walletShareDetail.parent')
            ->where('user_id', \Auth::user()->id);

        // Apply Filter
        if(!empty($this->filterWalletShareNote)){
            $this->dataWalletShare->where('note', 'like', '%'.$this->filterWalletShareNote.'%')
                ->orWhere('token', 'like', '%'.$this->filterWalletShareNote.'%');
        }

        // Apply Order
        if(!empty($this->sortKeyWalletShare)){
            $this->dataWalletShare->orderBy($this->sortKeyWalletShare, ($this->sortTypeWalletShare ?? 'asc'));
        }

        $this->dataWalletShare = $this->dataWalletShare->get();
        // Fetch data and paginate
        $this->paginateWalletShare = $this->dataWalletShare->paginate($this->loadPerPage);
        $this->dataWalletShare = (collect($this->dataWalletShare->paginate($this->loadPerPage)->items()))->map(function($data){
            return $data;
        })->values();
    }
}
