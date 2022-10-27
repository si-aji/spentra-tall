<?php

namespace App\Http\Livewire\Sys\Record;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // Load More Conf
    public $loadPerPage = 10;
    public $user_timezone = '';

    // List
    public $listWallet = null;
    public $listCategory = null;

    // List Data
    public $dataSelectedYear = '';
    public $dataSelectedMonth = '';
    public $dataSelectedType = '';
    public $dataSelectedNote = '';
    public $dataRecord;
    protected $recordPaginate;

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
    public function fetchRecordData($selectedWallet = null) : void
    {
        $this->dataRecord = \App\Models\Record::with('wallet.parent', 'walletTransferTarget.parent', 'category.parent')
            ->where('user_id', \Auth::user()->id)
            ->where('status', 'complete');

        // Apply Selected Wallet (from Wallet Show or Wallet Group Show)
        if(!empty($selectedWallet)){
            if(is_array($selectedWallet)){
                // Is array, from wallet group
                // $this->dataRecord->where(function($q) use ($selectedWallet){
                //     return $q->whereIn('wallet_id', $selectedWallet)
                //         ->orWhereIn('to_wallet_id', $selectedWallet);
                // });
                $this->dataRecord->whereIn('wallet_id', $selectedWallet);
            } else {
                // $this->dataRecord->where(function($q) use ($selectedWallet){
                //     return $q->where('wallet_id', $selectedWallet)
                //         ->orWhere('to_wallet_id', $selectedWallet);
                // });
                $this->dataRecord->where('wallet_id', $selectedWallet);
            }
        }

        // Apply Filter
        if($this->dataSelectedType !== ''){
            if($this->dataSelectedType === 'transfer'){
                $this->dataRecord->whereNotNull('to_wallet_id');
            } else {
                $this->dataRecord->where('type', $this->dataSelectedType);
            }
        }
        if($this->dataSelectedNote !== ''){
            $this->dataRecord->where('note', 'like', '%'.$this->dataSelectedNote.'%');
        }

        $this->dataRecord = $this->dataRecord->orderBy('datetime', 'desc')
            ->orderBy('type', 'desc')
            ->get();
        $this->dataRecord = collect($this->dataRecord);
        if($this->dataSelectedMonth){
            $this->dataRecord = $this->dataRecord->filter(function($record){
                // Compromize can't use convert_tz on shared hosting
                $recordDateTime = new \DateTime(date("Y-m-d H:i:s", strtotime($record->datetime)));
                if(\Session::has('SAUSER_TZ')){
                    $recordDateTime = $recordDateTime->setTimezone(new \DateTimeZone(\Session::get('SAUSER_TZ')))->format('Y-m-d H:i:s');
                    // $recordDateTime = (new \DateTime($recordDateTime, new \DateTimeZone(\Session::get('SAUSER_TZ'))))->format('Y-m-d H:i:s');
                } else {
                    $recordDateTime = $recordDateTime->format('Y-m-d H:i:s');
                }

                // \Log::debug("Debug on Filter", [
                //     'raw' => $record->datetime,
                //     'formated' => $recordDateTime,
                //     'session' => [
                //         'has_tz' => \Session::has('SAUSER_TZ'),
                //         'tz' => \Session::get('SAUSER_TZ')
                //     ],
                //     'validate' => [
                //         'date' => [
                //             'month' => date("m", strtotime($recordDateTime)),
                //             'year' => date("Y", strtotime($recordDateTime))
                //         ],
                //         'filter' => [
                //             'month' => date("m", strtotime($this->dataSelectedMonth)),
                //             'year' => date("Y", strtotime($this->dataSelectedMonth))
                //         ]
                //     ]
                // ]);
                
                return (date("m", strtotime($recordDateTime)) === date("m", strtotime($this->dataSelectedMonth))) && date("Y", strtotime($recordDateTime)) === date("Y", strtotime($this->dataSelectedMonth));
            });
        }
        $this->recordPaginate = $this->dataRecord->paginate($this->loadPerPage);
        $this->dataRecord = $this->dataRecord->values()->take($this->loadPerPage);
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
        $this->fetchRecordData();
        
        $this->fetchMainCategory();
        $this->fetchMainWallet();
        $this->dispatchBrowserEvent('recordPluginsInit');
        $this->dispatchBrowserEvent('recordLoadData');
        return view('livewire.sys.record.index', [
            'paginate' => $this->recordPaginate
        ])->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
        ]);
    }

    public function loadMore($limit = 10)
    {
        $this->loadPerPage += $limit;
    }
    public function monthChanged()
    {
        $this->reset([
            'loadPerPage'
        ]);
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
            case 'dataSelectedType':
                $this->dataSelectedType = $value;
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
            $record->getRelatedTransferRecord()->delete();
        }
        $record->delete();

        return $uuid;
    }

    public function getPaginate()
    {
        return $this->recordPaginate;
    }
}
