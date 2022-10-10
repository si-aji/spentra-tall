<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\WithFileUploads;
use Livewire\Component;

class RecordModal extends Component
{
    use WithFileUploads;

    public $menuState = null;
    public $submenuState = null;

    public $listCategory;
    public $listTemplate;
    public $listWallet;

    public $recordModalState = true;
    public $recordTemplate = '';
    public $recordCategory = '';
    public $recordWallet = '';
    public $recordWalletTransfer = '';
    public $recordTitle = 'Add new Record';
    public $recordType = 'income';
    public $recordExtraType = 'amount';
    public $recordAmount = '';
    public $recordExtraAmount = '';
    public $recordFinalAmount = '';
    public $recordNote = null;
    public $recordReceipt;
    public $recordPeriod = null;
    public $recordMoreState = false;

    public $recordResetField = [];
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'localUpdate' => 'localUpdate',
        'closeModal' => 'closeModal',
        'store' => 'store',
        'fetchTemplate' => 'fetchTemplate'
    ];

    public function mount()
    {
        $this->recordResetField = [
            'recordTitle',
            'recordTemplate',
            'recordCategory',
            'recordWallet',
            'recordWalletTransfer',
            'recordType',
            'recordExtraType',
            'recordAmount',
            'recordExtraAmount',
            'recordFinalAmount',
            'recordReceipt',
            'recordPeriod',
            'recordNote', 
        ];

        /**
         * Handle List
         */
        // Template
        $this->listTemplate = \App\Models\RecordTemplate::with('category')
            ->where('user_id', \Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();
        // Category
        $this->listCategory = \App\Models\Category::with('child', 'parent')
            ->where('user_id', \Auth::user()->id)
            ->whereNull('parent_id')
            ->orderBy('order_main', 'asc')
            ->get();
        // Wallet
        $this->listWallet = \App\Models\Wallet::with('child', 'parent')
            ->where('user_id', \Auth::user()->id)
            ->whereNull('parent_id')
            ->orderBy('order_main', 'asc')
            ->get();
    }

    public function render()
    {
        $this->dispatchBrowserEvent('record_wire-init');
        return view('livewire.sys.component.record-modal');
    }

    // Handle Modal
    public function openModal()
    {
        $this->emit($this->recordModalState ? 'show' : 'hide');
    }
    public function closeModal()
    {
        $this->recordTemplate = '';
        $this->recordResetField[] = 'recordMoreState';
        $this->reset($this->recordResetField);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('trigger-event', [
            'recordType' => $this->recordType,
            'recordExtraType' => $this->recordExtraType,
            'recordAmount' => $this->recordAmount,
            'recordExtraAmount' => $this->recordExtraAmount
        ]);
    }
    // Update Model / Variable
    public function localUpdate($key, $value): void
    {
        // \Log::debug("Debug on Local Update function", [
        //     'key' => $key,
        //     'value' => $value
        // ]);
        switch($key){
            case 'recordTemplate':
                $this->recordTemplate = $value;
                break;
            case 'recordCategory':
                $this->recordCategory = $value;
                break;
            case 'recordWallet':
                $this->recordWallet = $value;
                break;
            case 'recordWalletTransfer':
                $this->recordWalletTransfer = $value;
                break;
            case 'recordType':
                $this->recordType = $value;
                break;
            case 'recordExtraType':
                $this->recordExtraType = $value;
                break;
            case 'recordFinalAmount':
                $this->recordFinalAmount = $value;
                break;
            case 'recordAmount':
                $this->recordAmount = $value;
                break;
            case 'recordExtraAmount':
                $this->recordExtraAmount = $value;
                break;
            case 'recordMoreState':
                $this->recordMoreState = $value;
                break;
        }
    }

    public function store()
    {
        if(!($this->recordResetField)){
            $this->recordResetField[] = 'recordMoreState';
        } else {
            $key = array_search('recordMoreState', $this->recordResetField);
            if($key !== false){
                unset($this->recordResetField[$key]);
            }
        }
        $this->reset($this->recordResetField);
    }
    // Fetch Template Data
    public function fetchTemplate($uuid)
    {
        if($uuid == ''){
            $this->recordTemplate = '';
            $this->reset($this->recordResetField);
            return false;
        }

        $data = \App\Models\RecordTemplate::with('category', 'wallet', 'walletTransferTarget')
            ->where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();

        $key = array_search('recordTemplate', $this->recordResetField);
        if($key !== false){
            unset($this->recordResetField[$key]);
        }
        $this->reset($this->recordResetField);

        $this->recordType = $data->type;
        $this->recordCategory = $data->category()->exists() ? $data->category->uuid : '';
        $this->recordWallet = $data->wallet->uuid;
        if($data->type === 'transfer'){
            $this->recordWalletTransfer = $data->walletTransferTarget->uuid;
        }
        $this->recordAmount = $data->amount;
        $this->recordExtraAmount = $data->extra_type === 'amount' ? $data->extra_amount : $data->extra_percentage;
        $this->recordExtraType = $data->extra_type;

        $calculateFinal = $data->amount + $data->extra_amount;
        $this->recordFinalAmount = $calculateFinal;
        $this->recordNote = $data->note;

        $this->dispatchBrowserEvent('trigger-event', [
            'recordType' => $this->recordType,
            'recordExtraType' => $this->recordExtraType,
            'recordAmount' => $this->recordAmount,
            'recordExtraAmount' => $this->recordExtraAmount
        ]);
    }
}
