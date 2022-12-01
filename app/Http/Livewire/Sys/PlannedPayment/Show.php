<?php

namespace App\Http\Livewire\Sys\PlannedPayment;

use Livewire\Component;

class Show extends Component
{
    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    // Data
    public $plannedPaymentUuid;
    public $plannedPaymentData = '';
    public $plannedPaymentDataRecord;
    // Load More Conf
    public $loadPerPage = 10;

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
    public function mount($uuid)
    {
        $this->menuState = 'planned-payment';
        $this->plannedPaymentUuid = $uuid;
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->plannedPaymentData = \App\Models\PlannedPayment::with('category.parent', 'wallet.parent', 'walletTransferTarget.parent', 'plannedPaymentTags')
            ->where('user_id', \Auth::user()->id)
            ->where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentUuid)
            ->firstOrFail();
        // Record List
        $this->plannedPaymentRecordData = \App\Models\PlannedPaymentRecord::whereHas('plannedPayment', function($q){
                return $q->where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentUuid);
            })
            ->with('plannedPayment.category.parent', 'wallet.parent', 'walletTransferTarget.parent', 'record.category.parent', 'record.recordTags', 'recordTransferTarget')
            ->orderBy('period', 'desc');
        $this->plannedPaymentRecordData = $this->plannedPaymentRecordData->paginate($this->loadPerPage);
        $paginate = $this->plannedPaymentRecordData;
        $this->plannedPaymentRecordData = collect($this->plannedPaymentRecordData->items());

        $this->dispatchBrowserEvent('plannedPaymentShowLoadData');
        return view('livewire.sys.planned-payment.show', [
            'paginate' => $paginate
        ])->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentPlannedPayment' => true
        ]);
    }

    /**
     * Function
     */
    public function skipPeriod($uuid = null)
    {
        $plannedRecordModal = new \App\Http\Livewire\Sys\Component\PlannedPaymentRecordModal();
        return $plannedRecordModal->skipRecord($uuid, $this->plannedPaymentUuid);
    }
    public function loadMore()
    {
        $this->loadPerPage += $this->loadPerPage;
    }
}
