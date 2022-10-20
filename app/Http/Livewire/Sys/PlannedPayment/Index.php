<?php

namespace App\Http\Livewire\Sys\PlannedPayment;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // Load More Conf
    public $loadPerPage = 10;
    public $user_timezone = '';

    // List Data
    public $dataPlannedPayment;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'loadMore' => 'loadMore',
        'removeData' => 'removeData'
    ];
    
    public function mount()
    {
        $this->menuState = 'planned-payment';
        $this->submenuState = null;
    }

    public function render()
    {
        $this->dataPlannedPayment = \App\Models\PlannedPayment::with('category.parent', 'wallet.parent', 'walletTransferTarget.parent')
            ->where('user_id', \Auth::user()->id);
        $this->dataPlannedPayment = $this->dataPlannedPayment->paginate($this->loadPerPage);
        $paginate = $this->dataPlannedPayment;
        $this->dataPlannedPayment = collect($this->dataPlannedPayment->items());
        $this->dispatchBrowserEvent('plannedPayment_wire-init');

        return view('livewire.sys.planned-payment.index', [
            'paginate' => $paginate
        ])->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentPlannedPayment' => true
        ]);
    }

    public function loadMore($limit = 10)
    {
        $this->loadPerPage += $limit;
    }
}
