<?php

namespace App\Http\Livewire\Sys\Wallet\Lists;

use Livewire\Component;

class Show extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // Paginate
    public $loadPerPage = 10;

    // Data
    public $walletUuid = '';
    public $walletData;
    public $walletRecordData;

    public function mount($uuid)
    {
        $this->menuState = 'wallet';
        $this->submenuState = 'list';

        $this->walletUuid = $uuid;
    }

    public function render()
    {
        $this->walletData = \App\Models\Wallet::where('user_id', \Auth::user()->id)
            ->where(\DB::raw('BINARY `uuid`'), $this->walletUuid)
            ->firstOrFail();

        $recordLivewire = new \App\Http\Livewire\Sys\Record\Index();
        $recordLivewire->loadPerPage = $this->loadPerPage;
        $recordLivewire->fetchRecordData($this->walletData->id);
        $this->walletRecordData = $recordLivewire->dataRecord;

        $this->dispatchBrowserEvent('walletRecordLoadData');
        return view('livewire.sys.wallet.lists.show', [
            'paginate' => $recordLivewire->getPaginate()
        ])->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentWallet' => true
        ]);
    }

    public function loadMore()
    {
        $this->loadPerPage += $this->loadPerPage;
    }
}
