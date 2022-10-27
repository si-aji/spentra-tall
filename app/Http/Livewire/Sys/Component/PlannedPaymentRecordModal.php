<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\WithFileUploads;
use Livewire\Component;

class PlannedPaymentRecordModal extends Component
{
    use WithFileUploads;

    public $menuState = null;
    public $submenuState = null;

    // List
    public $listTemplate;
    public $listCategory;
    public $listWallet;

    public $plannedPaymentRecordResetField = [];
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'skipRecord' => 'skipRecord',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
        'editAction' => 'editAction'
    ];

    // Modal
    public $plannedPaymentRecordModalState = 'hide';
    public $plannedPaymentRecordTitle = 'Planned Payment: Approval';

    // Field
    public $user_timezone;
    public $plannedPaymentRecordUuid = '';
    public $plannedPaymentRecordType = 'income';
    public $plannedPaymentRecordCategory = '';
    public $plannedPaymentRecordWallet = '';
    public $plannedPaymentRecordWalletTransfer = '';
    public $plannedPaymentRecordAmount = '';
    public $plannedPaymentRecordExtraType = 'amount';
    public $plannedPaymentRecordExtraAmount = '';
    public $plannedPaymentRecordFinalAmount = '';
    public $plannedPaymentRecordPeriod = '';
    public $plannedPaymentRecordPeriodChanged = false;
    public $plannedPaymentRecordNote = '';
    public $plannedPaymentRecordReceipt = null;
    public $plannedPaymentRecordReceiptTemp = null;

    public function mount()
    {
        $this->plannedPaymentRecordResetField = [
            'plannedPaymentRecordType',
            'plannedPaymentRecordCategory',
            'plannedPaymentRecordWallet',
            'plannedPaymentRecordWalletTransfer',
            'plannedPaymentRecordAmount',
            'plannedPaymentRecordExtraType',
            'plannedPaymentRecordAmount',
            'plannedPaymentRecordExtraAmount',
            'plannedPaymentRecordFinalAmount',
            'plannedPaymentRecordPeriod',
            'plannedPaymentRecordPeriodChanged',
            'plannedPaymentRecordNote',
            'plannedPaymentRecordReceipt',
            'plannedPaymentRecordReceiptTemp'
        ];
    }

    // Fetch List
    public function fetchListCategory()
    {
        // Category
        $this->listCategory = \App\Models\Category::with('child', 'parent')
            ->where('user_id', \Auth::user()->id)
            ->whereNull('parent_id')
            ->orderBy('order_main', 'asc')
            ->get();
    }
    public function fetchListWallet()
    {
        // Wallet
        $this->listWallet = \App\Models\Wallet::with('child', 'parent')
            ->where('user_id', \Auth::user()->id)
            ->whereNull('parent_id')
            ->orderBy('order_main', 'asc')
            ->get();
    }

    public function render()
    {
        $this->fetchListCategory();
        $this->fetchListWallet();
        $this->dispatchBrowserEvent('plannedPaymentRecord_wire-init');

        return view('livewire.sys.component.planned-payment-record-modal');
    }

    // Handle Data
    public function updatedPlannedPaymentRecordReceipt()
    {
        if($this->plannedPaymentRecordReceipt){
            if(round($this->plannedPaymentRecordReceipt->getSize()) / 1024.4 > 100){
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'recordReceipt' => 'The record receipt must not be greater than 100 kilobytes.'
                ]);
            }
        }

        $this->validate([
            'plannedPaymentRecordReceipt' => 'mimes:jpg,jpeg,png,pdf|max:100',
        ]);
    }
    public function save()
    {
        $this->resetValidation();
        // Reset Field if Transfer
        if($this->plannedPaymentRecordType === 'transfer'){
            $this->reset([
                'plannedPaymentRecordCategory',
                'plannedPaymentRecordExtraType',
                'plannedPaymentRecordExtraAmount'
            ]);
        }

        $this->validate([
            'plannedPaymentRecordCategory' => ['nullable', 'string', 'exists:'.(new \App\Models\Category())->getTable().',uuid'],
            'plannedPaymentRecordWallet' => ['required', 'string', 'exists:'.(new \App\Models\Wallet())->getTable().',uuid'],
            'plannedPaymentRecordWalletTransfer' => [($this->plannedPaymentRecordType === 'transfer' ? 'required' : 'string'), 'string', 'exists:'.(new \App\Models\Wallet())->getTable().',uuid'],
            'plannedPaymentRecordAmount' => ['required'],
            'plannedPaymentRecordExtraAmount' => ['nullable'],
            'plannedPaymentRecordPeriod' => ['required'],
            'plannedPaymentRecordNote' => ['nullable'],
            'plannedPaymentRecordReceipt' => ['nullable', 'mimes:jpg,jpeg,png,pdf', 'max:1024']
        ]);

        \DB::transaction(function () {
            $plannedRecord = \App\Models\PlannedPaymentRecord::where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentRecordUuid)
                ->whereHas('plannedPayment', function($q){
                    return $q->where('user_id', \Auth::user()->id);
                })
                ->firstOrFail();
            
            $wallet = null;
            if($this->plannedPaymentRecordWallet){
                $walletData = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentRecordWallet)
                    ->firstOrFail();
                $wallet = $walletData->id;
            }
            $walletTransfer = null;
            if($this->plannedPaymentRecordWalletTransfer){
                $walletTransferData = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentRecordWalletTransfer)
                    ->firstOrFail();
                $walletTransfer = $walletTransferData->id;
            }
            $datetime = date("Y-m-d H:i", strtotime($this->plannedPaymentRecordPeriod));
            if($this->user_timezone){
                $raw = date('Y-m-d H:i:00', strtotime($this->plannedPaymentRecordPeriod));
                // Convert to UTC
                $utc = convertToUtc($raw, ($this->user_timezone));
                $datetime = date('Y-m-d H:i:00', strtotime($utc));
            }
            // Update Planned Record
            $plannedRecord->wallet_id = $wallet;
            $plannedRecord->to_wallet_id = $walletTransfer;
            // $plannedRecord->period = date("Y-m-d", strtotime($datetime));
            $plannedRecord->type = $this->plannedPaymentRecordType;
            $plannedRecord->amount = $this->plannedPaymentRecordAmount;
            $plannedRecord->extra_type = $this->plannedPaymentRecordExtraType;
            $plannedRecord->extra_percentage = $this->plannedPaymentRecordExtraType === 'percentage' ? ($this->plannedPaymentRecordExtraAmount != '' ? $this->plannedPaymentRecordExtraAmount : 0) : 0;
            $plannedRecord->extra_amount = $this->plannedPaymentRecordExtraType === 'amount' ? ($this->plannedPaymentRecordExtraAmount != '' ? $this->plannedPaymentRecordExtraAmount : 0) : ($this->plannedPaymentRecordAmount * ($this->plannedPaymentRecordExtraAmount / 100));
            $plannedRecord->status = 'complete';
            $plannedRecord->confirmed_at = date("Y-m-d H:i:s");
            $plannedRecord->save();

            // Record
            $recordLivewire = new \App\Http\Livewire\Sys\Component\RecordModal();
            $recordLivewire->user_timezone = $this->user_timezone;
            $recordLivewire->recordType = $this->plannedPaymentRecordType;
            $recordLivewire->recordCategory = $this->plannedPaymentRecordCategory;
            $recordLivewire->recordWallet = $this->plannedPaymentRecordWallet;
            $recordLivewire->recordWalletTransfer = $this->plannedPaymentRecordWalletTransfer;
            $recordLivewire->recordAmount = $this->plannedPaymentRecordAmount;
            $recordLivewire->recordExtraType = $this->plannedPaymentRecordExtraType;
            $recordLivewire->recordExtraAmount = $this->plannedPaymentRecordExtraAmount;
            $recordLivewire->recordFinalAmount = $this->plannedPaymentRecordFinalAmount;
            $recordLivewire->recordPeriod = $this->plannedPaymentRecordPeriod;
            $recordLivewire->recordNote = $this->plannedPaymentRecordNote;
            $recordLivewire->recordReceipt = $this->plannedPaymentRecordReceipt;
            $recordLivewire->save(true, $plannedRecord);
        });

        $this->dispatchBrowserEvent('close-modalPlannedPaymentRecord');
        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully approved Planned Payment Data'
        ]);
        $this->emit('refreshComponent');
        $this->reset($this->plannedPaymentRecordResetField);
        $this->dispatchBrowserEvent('trigger-eventPlannedPaymentRecord', [
            'plannedPaymentRecordType' => $this->plannedPaymentRecordType,
            'plannedPaymentRecordExtraType' => $this->plannedPaymentRecordExtraType,
            'plannedPaymentRecordAmount' => $this->plannedPaymentRecordAmount,
            'plannedPaymentRecordExtraAmount' => $this->plannedPaymentRecordExtraAmount,
            'plannedPaymentRecordCategory' => $this->plannedPaymentRecordCategory,
            'plannedPaymentRecordWallet' => $this->plannedPaymentRecordWallet,
            'plannedPaymentRecordWalletTransfer' => $this->plannedPaymentRecordWalletTransfer,
            'resetPeriod' => true
        ]);
    }
    public function editAction($uuid)
    {
        $plannedRecord = \App\Models\PlannedPaymentRecord::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->whereHas('plannedPayment', function($q){
                return $q->where('user_id', \Auth::user()->id);
            })
            ->firstOrFail();

        $this->plannedPaymentRecordUuid = $plannedRecord->uuid;
        $this->plannedPaymentRecordType = $plannedRecord->type;
        $this->plannedPaymentRecordCategory = $plannedRecord->plannedPayment->category()->exists() ? $plannedRecord->plannedPayment->category->uuid : '';
        $this->plannedPaymentRecordWallet = $plannedRecord->wallet->uuid;
        $this->plannedPaymentRecordWalletTransfer = $plannedRecord->type === 'transfer' ? $plannedRecord->walletTransferTarget->uuid : '';
        $this->plannedPaymentRecordAmount = $plannedRecord->amount;
        $this->plannedPaymentRecordExtraType = $plannedRecord->extra_type;
        $this->plannedPaymentRecordExtraAmount = $plannedRecord->extra_type === 'percentage' ? $plannedRecord->extra_percentage : $plannedRecord->extra_amount;
        $this->plannedPaymentRecordFinalAmount = $plannedRecord->amount + $plannedRecord->extra_amount;
        $this->plannedPaymentRecordNote = $plannedRecord->plannedPayment->note;
        
        $this->dispatchBrowserEvent('open-modalPlannedPaymentRecord');
        $this->dispatchBrowserEvent('trigger-eventPlannedPaymentRecord', [
            'plannedPaymentRecordType' => $this->plannedPaymentRecordType,
            'plannedPaymentRecordExtraType' => $this->plannedPaymentRecordExtraType,
            'plannedPaymentRecordAmount' => $this->plannedPaymentRecordAmount,
            'plannedPaymentRecordExtraAmount' => $this->plannedPaymentRecordExtraAmount,
            'plannedPaymentRecordCategory' => $this->plannedPaymentRecordCategory,
            'plannedPaymentRecordWallet' => $this->plannedPaymentRecordWallet,
            'plannedPaymentRecordWalletTransfer' => $this->plannedPaymentRecordWalletTransfer,
        ]);
    }
    public function skipRecord($uuid, $plannedPaymentUuid)
    {
        $plannedRecord = \App\Models\PlannedPaymentRecord::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->whereHas('plannedPayment', function($q) use ($plannedPaymentUuid){
                return $q->where('user_id', \Auth::user()->id)
                    ->where(\DB::raw('BINARY `uuid`'), $plannedPaymentUuid);
            })
            ->firstOrFail();
        
        $plannedRecord->status = 'skip';
        $plannedRecord->confirmed_at = date("Y-m-d H:i:s");
        if(\Session::has('SAUSER_TZ_OFFSET')){
            $plannedRecord->timezone_offset = \Session::get('SAUSER_TZ_OFFSET');
        }
        $plannedRecord->save();

        return [
            'data' => 'ok'
        ];
    }

    public function removeReceipt(): void
    {
        if($this->plannedPaymentRecordReceipt){
            if(\File::exists('livewire-tmp'.'/'.$this->plannedPaymentRecordReceipt->getFilename())){
                \Storage::delete('livewire-tmp'.'/'.$this->plannedPaymentRecordReceipt->getFilename());
            }

            $this->plannedPaymentRecordReceipt = null;
        }
    }

    // Handle Modal
    public function openModal()
    {
       $this->plannedPaymentRecordModalState = 'show';
    }
    public function closeModal()
    {
       $this->reset($this->plannedPaymentRecordResetField);
       $this->dispatchBrowserEvent('close-modalPlannedPaymentRecord');
       $this->dispatchBrowserEvent('trigger-eventPlannedPaymentRecord', [
            'plannedPaymentRecordType' => $this->plannedPaymentRecordType,
            'plannedPaymentRecordExtraType' => $this->plannedPaymentRecordExtraType,
            'plannedPaymentRecordAmount' => $this->plannedPaymentRecordAmount,
            'plannedPaymentRecordExtraAmount' => $this->plannedPaymentRecordExtraAmount
        ]);
        $this->resetValidation();
    }
}
