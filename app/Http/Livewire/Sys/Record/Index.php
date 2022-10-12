<?php

namespace App\Http\Livewire\Sys\Record;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // List
    public $listWallet = null;
    public $listCategory = null;

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
        $this->menuState = 'record';
        $this->submenuState = null;
    }

    public function render()
    {
        $this->fetchMainCategory();
        $this->fetchMainWallet();
        $this->dispatchBrowserEvent('record_wire-init');
        return view('livewire.sys.record.index')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState
        ]);
    }
}
