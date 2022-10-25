<?php

namespace App\Http\Livewire\Sys\PlannedPayment;

use Livewire\Component;

class Show extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // Data
    public $plannedPaymentUuid;
    public $plannedPaymentData = '';
    public $plannedPaymentDataRecord;

    // Load More Conf
    public $loadPerPage = 10;

    public function mount($uuid)
    {
        $this->plannedPaymentUuid = $uuid;
    }

    public function render()
    {
        $this->plannedPaymentData = \App\Models\PlannedPayment::where('user_id', \Auth::user()->id)
            ->where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentUuid)
            ->firstOrFail();
        // Record List
        $this->plannedPaymentRecordData = \App\Models\PlannedPaymentRecord::whereHas('plannedPayment', function($q){
                return $q->where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentUuid);
            })
            ->with('plannedPayment.category.parent', 'wallet.parent', 'walletTransferTarget.parent', 'record.category.parent', 'recordTransferTarget')
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

    public function skipPeriod($uuid = null)
    {
        $plannedRecordModal = new \App\Http\Livewire\Sys\Component\PlannedPaymentRecordModal();
        return $plannedRecordModal->skipRecord($uuid, $this->plannedPaymentUuid);
    }

    public function loadMore($limit = 10)
    {
        $this->loadPerPage += $limit;
    }
}
