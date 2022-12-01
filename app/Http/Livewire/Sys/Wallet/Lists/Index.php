<?php

namespace App\Http\Livewire\Sys\Wallet\Lists;

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
        'removeData' => 'removeData'
    ];

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->menuState = 'wallet';
        $this->submenuState = 'list';
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->dataWallet = \App\Models\Wallet::with('parent')
            ->where('user_id', \Auth::user()->id)
            ->orderBy('order_main', 'asc');
        $this->dataWallet = $this->dataWallet->paginate($this->loadPerPage);
        $paginate = $this->dataWallet;
        $this->dataWallet = collect($this->dataWallet->items())->values()->map(function($data){
            $data->balance = $data->getBalance();
            $data->last_transaction = $data->getLastTransaction();
            return $data;
        });

        $this->dispatchBrowserEvent('walletListLoadData');
        $this->dispatchBrowserEvent('wallet_list-init');

        return view('livewire.sys.wallet.lists.index', [
            'paginate' => $paginate
        ])->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentWallet' => true
        ]);
    }

    /**
     * Function
     */
    public function archiveData($uuid)
    {
        $data = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        // Adjust Child (Remove parent_id)
        $data->child()->update([
            'parent_id' => null
        ]);
        // Archive
        $data->delete();

        // Re-Order
        (new \App\Http\Livewire\Sys\Wallet\Lists\ReOrder())->reOrder();

        return $uuid;
    }
}
