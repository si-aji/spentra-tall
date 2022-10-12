<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\WithFileUploads;
use Livewire\Component;

class RecordModal extends Component
{
    use WithFileUploads;

    public $menuState = null;
    public $submenuState = null;

    // List
    public $listTemplate;
    public $listCategory;
    public $listWallet;

    // Modal
    public $recordModalState = true;
    public $recordTitle = 'Add new Record';

    // Field
    public $user_timezone = null;
    public $recordTemplate = '';
    public $recordType = 'income';
    public $recordCategory = '';
    public $recordWallet = '';
    public $recordWalletTransfer = '';
    public $recordAmount = '';
    public $recordExtraType = 'amount';
    public $recordExtraAmount = '';
    public $recordFinalAmount = '';
    public $recordPeriod = '';
    public $recordNote = '';
    public $recordReceipt = null;
    public $recordMoreState = false;
    public $recordResetField = [];

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'closeModal' => 'closeModal',
        'localUpdate' => 'localUpdate',
    ];

    // Fetch List
    public function fetchListTemplate()
    {
        // Template
        $this->listTemplate = \App\Models\RecordTemplate::with('category')
            ->where('user_id', \Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();
    }
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

    public function mount()
    {
        $this->recordResetField = [
            'recordTemplate',
            'recordType',
            'recordCategory',
            'recordWallet',
            'recordWalletTransfer',
            'recordAmount',
            'recordExtraType',
            'recordExtraAmount',
            'recordFinalAmount',
            'recordPeriod',
            'recordNote',
            'recordReceipt',
        ];
    }

    public function render()
    {
        $this->fetchListTemplate();
        $this->fetchListCategory();
        $this->fetchListWallet();

        $this->dispatchBrowserEvent('record_wire-init');
        return view('livewire.sys.component.record-modal');
    }

    // Handle Data
    public function store()
    {
        \Log::debug("TZ: ".$this->user_timezone);

        $datetime = null;
        if($this->user_timezone){
            $raw = date('Y-m-d H:i:00', strtotime($this->recordPeriod));
            // Convert to UTC
            $utc = convertToUtc($raw, ($this->user_timezone));
            $datetime = date('Y-m-d H:i:00', strtotime($utc));
        }

        \Log::debug("Debug on Record Save", [
            'type' => $this->recordType,
            'category' => $this->recordCategory,
            'wallet' => [
                'from' => $this->recordWallet,
                'to' => $this->recordWalletTransfer
            ],
            'amount' => [
                'main' => $this->recordAmount,
                'type' => $this->recordExtraType,
                'extra' => $this->recordExtraAmount,
                'final' => $this->recordFinalAmount
            ],
            'period' => [
                'original' => $this->recordPeriod,
                'utc' => $datetime,
                'offset' => $this->user_timezone
            ],
            'note' => $this->recordNote
        ]);

        // Reset Field if Transfer
        if($this->recordType === 'transfer'){
            $this->reset([
                'recordCategory',
                'recordExtraType',
                'recordExtraAmount'
            ]);
        }

        $file = null;
        if($this->recordReceipt){
            $destinationPath = 'files/user'.'/'.\Auth::user()->uuid.'/receipt';
            // Check if directory exists
            if (! (\File::exists($destinationPath))) {
                \File::makeDirectory($destinationPath, 0777, true, true);
            }

            $file = $this->recordReceipt->store($destinationPath);
            // Empty file
            $this->recordReceipt = null;
        }
        // Handle store function

        if(!($this->recordMoreState)){
            $this->recordResetField[] = 'recordMoreState';
            $this->dispatchBrowserEvent('close-modal');
        } else {
            $key = array_search('recordMoreState', $this->recordResetField);
            if($key !== false){
                unset($this->recordResetField[$key]);
            }
        }
        $this->reset($this->recordResetField);
        $this->emit('refreshComponent');
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
        switch($key){
            case 'recordTemplate':
                $this->recordTemplate = $value;
                break;
            case 'recordType':
                $this->recordType = $value;
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
            case 'recordAmount':
                $this->recordAmount = $value;
                break;
            case 'recordExtraType':
                $this->recordExtraType = $value;
                break;
            case 'recordExtraAmount':
                $this->recordExtraAmount = $value;
                break;
            case 'recordFinalAmount':
                $this->recordFinalAmount = $value;
                break;
            case 'recordPeriod': 
                $this->recordPeriod = $value;
                break;
            case 'recordMoreState':
                $this->recordMoreState = $value;
                break;
            case 'user_timezone':
                $this->user_timezone = $value;
                break;
        }
    }
    public function removeReceipt(): void
    {
        // \Log::debug("Debug on Receipt remove", [
        //     'file' => $this->recordReceipt ? 'TRUE' : 'FALSE'
        // ]);

        if($this->recordReceipt){
            if(\File::exists('livewire-tmp'.'/'.$this->recordReceipt->getFilename())){
                \Storage::delete('livewire-tmp'.'/'.$this->recordReceipt->getFilename());
            }

            $this->recordReceipt = null;
        }
    }

    // Handle Modal
    public function openModal()
    {
        $this->emit($this->recordModalState ? 'show' : 'hide');
    }
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('trigger-event', [
            'recordType' => $this->recordType,
            'recordExtraType' => $this->recordExtraType,
            'recordAmount' => $this->recordAmount,
            'recordExtraAmount' => $this->recordExtraAmount
        ]);
    }
}
