<?php

namespace App\Http\Livewire\Sys\PlannedPayment;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // Filter
    public $filterName = null;
    // Sort
    public $sortKey = null;
    public $sortType = null;

    // Load More Conf
    public $loadPerPage = 10;
    public $user_timezone = '';

    // List Data
    public $dataPlannedPayment;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'loadMore' => 'loadMore',
        'removeData' => 'removeData',
    ];
    
    public function mount()
    {
        $this->menuState = 'planned-payment';
        $this->submenuState = null;
    }

    public function render()
    {
        $this->dataPlannedPayment = \App\Models\PlannedPayment::with('category.parent', 'wallet.parent', 'walletTransferTarget.parent', 'plannedPaymentTags')
            ->where('user_id', \Auth::user()->id);
        // Apply Filter
        if(!empty($this->filterName)){
            $this->dataPlannedPayment->where('name', 'like', '%'.$this->filterName.'%');
        }
        // Applu Sort
        if(!empty($this->sortKey)){
            $sortType = 'asc';
            if(!empty($this->sortType)){
                $sortType = $this->sortType;
            }

            $this->dataPlannedPayment->orderBy($this->sortKey, $sortType);
        } else {
            $this->dataPlannedPayment->orderBy('next_date', 'asc');
        }
        $this->dataPlannedPayment = $this->dataPlannedPayment->paginate($this->loadPerPage);
        $paginate = $this->dataPlannedPayment;
        $this->dataPlannedPayment = collect($this->dataPlannedPayment->items());

        $this->dispatchBrowserEvent('plannedPaymentLoadData');

        return view('livewire.sys.planned-payment.index', [
            'paginate' => $paginate
        ])->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentPlannedPayment' => true
        ])->section('content');
    }

    public function loadMore()
    {
        $this->loadPerPage += $this->loadPerPage;
    }

    public function loadListData()
    {
        $this->dispatchBrowserEvent('plannedPaymentLoadData', []);
    }
}
