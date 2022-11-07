<?php

namespace App\Http\Livewire\Share\Wallet;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // Load More Conf
    public $loadPerPage = 10;
    protected $recordPaginate;

    public $shareData;
    public $recordData = [];
    public $passphrase = '';
    public $selectedWallet = [];
    // Filter
    public $filterShare = [];
    public $filterYear;
    public $filterMonth;

    public function mount($token)
    {
        $this->shareData = \App\Models\WalletShare::where(\DB::raw('BINARY `token`'), $token)
            ->firstOrFail();
        // Apply filter
        $this->filterYear = date("Y");
        $this->filterMonth = date("Y-m-01", strtotime($this->filterYear.'-'.($this->filterYear !== date("Y") ? '12' : date("m")).'-01'));
    }

    public function fetchRecordData()
    {
        \Log::debug("Debug on selected wallet", [
            'selectedWallet' => $this->selectedWallet,
            'filterShare' => $this->filterShare
        ]);

        $recordLivewire = (new \App\Http\Livewire\Sys\Record\Index());
        $recordLivewire->dataSelectedYear = $this->filterYear;
        $recordLivewire->dataSelectedMonth = $this->filterMonth;
        $recordLivewire->fetchRecordData($this->selectedWallet);
        $this->recordData = $recordLivewire->dataRecord;
        $this->recordPaginate = $recordLivewire->getPaginate();

        // \Log::debug("Debug on Wallet Share fetch Record", [
        //     'recordLivewire' => [
        //         'filter' => [
        //             'year' => $recordLivewire->dataSelectedYear,
        //             'month' => $recordLivewire->dataSelectedMonth
        //         ],
        //         'data' => [
        //             'count' => count($recordLivewire->dataRecord)
        //         ]
        //     ],
        //     'this' => [
        //         'filter' => [
        //             'year' => $this->filterYear,
        //             'month' => $this->filterMonth,
        //             'wallet' => $this->filterShare
        //         ],
        //         // 'wallet' => $this->shareData->walletShareDetail()->pluck((new \App\Models\Wallet())->getTable().'.id')->toArray(),
        //     ]
        // ]);
    }
    public function render()
    {
        $view = 'livewire.share.wallet.index';
        if(!empty($this->shareData->passphrase) && !(\Session::has('wallet_share-'.$this->shareData->token))){
            $view = 'livewire.share.wallet.passphrase';
        }

        $this->selectedWallet = $this->shareData
            ->walletShareDetail()
            ->pluck((new \App\Models\Wallet())->getTable().'.id')
            ->toArray();
        if(count($this->filterShare) > 0){
            $this->selectedWallet = \App\Models\Wallet::whereIn(\DB::raw('BINARY `uuid`'), $this->filterShare)
                ->pluck('id')
                ->toArray();
        }

        // Fetch Record
        $this->fetchRecordData();
        $this->dispatchBrowserEvent('recordLoadData');

        return view($view, [
            'paginate' => $this->recordPaginate
        ])->extends('layouts.sneat-shr', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
        ]);
    }

    /**
     * Validate Passphrase
     * 
     */
    public function authenticate()
    {
        $this->validate([
            'passphrase' => ['required', 'string']
        ]);

        if($this->passphrase !== siacryption($this->shareData->passphrase)){
            throw \Illuminate\Validation\ValidationException::withMessages([
                'passphrase' => 'Passphrase did not match'
            ]);
        }

        \Session::put('wallet_share-'.$this->shareData->token, true);
    }

    /**
     * 
     */
    public function loadMore()
    {
        $this->loadPerPage += $this->loadPerPage;
    }
    public function monthChanged()
    {
        $this->reset([
            'loadPerPage'
        ]);
    }
}
