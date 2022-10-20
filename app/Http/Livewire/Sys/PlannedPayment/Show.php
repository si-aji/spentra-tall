<?php

namespace App\Http\Livewire\Sys\PlannedPayment;

use Livewire\Component;

class Show extends Component
{
    public $plannedPaymentUuid;
    public $plannedPaymentData = '';
    public $plannedPaymentRecordData = '';

    public $menuState = null;
    public $submenuState = null;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'skipPeriod' => 'skipPeriod'
    ];

    public function mount($uuid)
    {
        $this->plannedPaymentUuid = $uuid;
        $this->menuState = 'planned-payment';
    }

    public function render()
    {
        $this->plannedPaymentData = \App\Models\PlannedPayment::where('user_id', \Auth::user()->id)
            ->where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentUuid)
            ->firstOrFail();
        $this->plannedPaymentRecordData = $this->plannedPaymentData
            ->plannedPaymentRecord()
            ->with('plannedPayment.category.parent', 'wallet.parent', 'walletTransferTarget.parent', 'record.category.parent', 'recordTransferTarget')
            ->orderBy('period', 'desc')
            ->get();
        $this->dispatchBrowserEvent('plannedPayment_wire-init');
        return view('livewire.sys.planned-payment.show')->extends('layouts.sneat', [
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
}
