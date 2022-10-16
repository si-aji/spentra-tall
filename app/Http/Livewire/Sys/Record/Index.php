<?php

namespace App\Http\Livewire\Sys\Record;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // Load More Conf
    public $loadPerPage = 10;

    // List
    public $listWallet = null;
    public $listCategory = null;

    // List Data
    public $dataSelectedYear = '';
    public $dataSelectedMonth = '';
    public $dataRecord;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'loadMore' => 'loadMore',
        'localUpdate' => 'localUpdate',
        'removeData' => 'removeData'
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
    public function fetchMainCategory()
    {
        // Category
        $this->listCategory = \App\Models\Category::with('child', 'parent')
            ->where('user_id', \Auth::user()->id)
            ->whereNull('parent_id')
            ->orderBy('order_main', 'asc')
            ->get();
    }
    public function mount()
    {
        $this->dataSelectedYear = date("Y");
        $this->dataSelectedMonth = date("Y-m-01", strtotime($this->dataSelectedYear.'-'.($this->dataSelectedYear !== date("Y") ? '12' : date("m")).'-01'));
        
        $this->menuState = 'record';
        $this->submenuState = null;
    }

    public function render()
    {
        // Get Record Data
        $this->dataRecord = \App\Models\Record::with('wallet.parent', 'walletTransferTarget.parent', 'category.parent')
            ->where('user_id', \Auth::user()->id)
            ->where('status', 'complete')
            ->whereMonth('date', date('m', strtotime($this->dataSelectedMonth)))
            ->whereYear('date', date('Y', strtotime($this->dataSelectedMonth)))
            ->orderBy('datetime', 'desc')
            ->paginate($this->loadPerPage);
        $paginate = $this->dataRecord;
        $this->dataRecord = collect($this->dataRecord->items());

        $this->fetchMainCategory();
        $this->fetchMainWallet();
        $this->dispatchBrowserEvent('record_wire-init');
        return view('livewire.sys.record.index', [
            'paginate' => $paginate
        ])->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
        ]);
    }

    public function loadMore($limit = 10)
    {
        $this->loadPerPage += $limit;
    }

    // Update Model / Variable
    public function localUpdate($key, $value): void
    {
        switch($key){
            case 'dataSelectedMonth':
                $this->dataSelectedMonth = $value;
                break;
            case 'dataSelectedYear':
                $this->dataSelectedYear = $value;
                $this->dataSelectedMonth = date("Y-m-01", strtotime($this->dataSelectedYear.'-'.($this->dataSelectedYear != date("Y") ? '12' : date("m") ).'-01'));
                break;
        }
    }

    // Remove Data
    public function removeData($uuid)
    {
        $record = \App\Models\Record::where('user_id', \Auth::user()->id)
            ->where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();

        if(!empty($record->to_wallet_id)){
            \Log::debug("A");
            $record->getRelatedTransferRecord()->delete();
        }
        $record->delete();

        return $uuid;
    }
}
