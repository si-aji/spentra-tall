<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class PlannedPaymentModal extends Component
{
    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    // List
    public $listTemplate;
    public $listCategory;
    public $listWallet;
    public $listTag;
    // Modal
    public $plannedPaymentModalState = 'hide';
    public $plannedPaymentTitle = 'Add new';
    // Form Field
    public $user_timezone = null;
    public $plannedPaymentUuid = '';
    public $plannedPaymentName = '';
    public $plannedPaymentType = 'income';
    public $plannedPaymentCategory = '';
    public $plannedPaymentWallet = '';
    public $plannedPaymentWalletTransfer = '';
    public $plannedPaymentAmount = '';
    public $plannedPaymentExtraType = 'amount';
    public $plannedPaymentExtraAmount = '';
    public $plannedPaymentFinalAmount = '';
    public $plannedPaymentPeriod = '';
    public $plannedPaymentPeriodChanged = '';
    public $plannedPaymentNote = '';
    public $plannedPaymentRepeat = '';
    public $plannedPaymentRepeatType = '';
    public $plannedPaymentTag;
    public $plannedPaymentMoreState = '';
    // Reset Field
    public $plannedPaymentResetField = [];

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
        'editAction' => 'editAction'
    ];

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->plannedPaymentResetField = [
            'plannedPaymentName',
            'plannedPaymentType',
            'plannedPaymentCategory',
            'plannedPaymentWallet',
            'plannedPaymentWalletTransfer',
            'plannedPaymentAmount',
            'plannedPaymentExtraType',
            'plannedPaymentAmount',
            'plannedPaymentExtraAmount',
            'plannedPaymentFinalAmount',
            'plannedPaymentPeriod',
            'plannedPaymentPeriodChanged',
            'plannedPaymentNote',
            'plannedPaymentRepeat',
            'plannedPaymentRepeatType',
            'plannedPaymentTag'
        ];
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->fetchListCategory();
        $this->fetchListWallet();
        $this->fetchListTag();

        $this->dispatchBrowserEvent('plannedPaymentModal_wire-init');
        return view('livewire.sys.component.planned-payment-modal');
    }

    /**
     * Function
     */
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
    public function fetchListTag()
    {
        // Tag
        $this->listTag = \App\Models\Tag::where('user_id', \Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();
    }
    // Handle Data
    public function save()
    {
        // Reset Field if Transfer
        if($this->plannedPaymentType === 'transfer'){
            $this->reset([
                'plannedPaymentCategory',
                // 'plannedPaymentExtraType',
                // 'plannedPaymentExtraAmount'
            ]);
        }

        $this->validate([
            'plannedPaymentName' => ['required', 'string'],
            'plannedPaymentCategory' => ['nullable', 'string', 'exists:'.(new \App\Models\Category())->getTable().',uuid'],
            'plannedPaymentWallet' => ['required', 'string', 'exists:'.(new \App\Models\Wallet())->getTable().',uuid'],
            'plannedPaymentWalletTransfer' => [($this->plannedPaymentType === 'transfer' ? 'required' : 'string'), 'string', 'exists:'.(new \App\Models\Wallet())->getTable().',uuid'],
            'plannedPaymentAmount' => ['required'],
            'plannedPaymentExtraAmount' => ['nullable'],
            'plannedPaymentPeriod' => ['required'],
            'plannedPaymentRepeat' => ['required'],
            'plannedPaymentRepeatType' => ['required', 'in:daily,weekly,monthly,yearly'],
            'plannedPaymentNote' => ['nullable'],
        ]);

        // $datetime = date("Y-m-d H:i", strtotime($this->plannedPaymentPeriod));
        $datetime = date("Y-m-d", strtotime($this->plannedPaymentPeriod));
        // Tag, get selected tag
        $selectedTags = [];
        if(!empty($this->plannedPaymentTag)){
            $selectedTags = \App\Models\Tag::where('user_id', \Auth::user()->id)
                ->whereIn(\DB::raw('BINARY `uuid`'), $this->plannedPaymentTag)
                ->pluck('id')
                ->toArray();
        }
        // if($this->user_timezone){
        //     $raw = date('Y-m-d H:i:00', strtotime($this->plannedPaymentPeriod));
        //     // Convert to UTC
        //     $utc = convertToUtc($raw, ($this->user_timezone));
        //     $datetime = date('Y-m-d H:i:00', strtotime($utc));
        // }

        // \Log::debug("Debug on Planned Payment Modal Store action", [
        //     'uuid' => $this->plannedPaymentUuid,
        //     'name' => $this->plannedPaymentName,
        //     'type' => $this->plannedPaymentType,
        //     'category' => $this->plannedPaymentCategory,
        //     'wallet' => [
        //         'from' => $this->plannedPaymentWallet,
        //         'to' => $this->plannedPaymentWalletTransfer
        //     ],
        //     'amount' => [
        //         'base' => $this->plannedPaymentAmount,
        //         'extra' => [
        //             'type' => $this->plannedPaymentExtraType,
        //             'amount' => $this->plannedPaymentExtraAmount
        //         ]
        //     ],
        //     'start' => $this->plannedPaymentPeriod,
        //     'repeat' => [
        //         'value' => $this->plannedPaymentRepeat,
        //         'type' => $this->plannedPaymentRepeatType
        //     ],
        //     'note' => $this->plannedPaymentNote
        // ]);

        \DB::transaction(function () use ($datetime, $selectedTags) {
            // Category
            $category = null;
            if($this->plannedPaymentCategory){
                $categoryData = \App\Models\Category::where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentCategory)
                    ->firstOrFail();
                $category = $categoryData->id;
            }
            // Main Wallet
            $wallet = null;
            if($this->plannedPaymentWallet){
                $walletData = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentWallet)
                    ->firstOrFail();
                $wallet = $walletData->id;
            }
            // Transfer Wallet
            $walletTransfer = null;
            if($this->plannedPaymentType === 'transfer'){
                // To
                $walletTransferData = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentWalletTransfer)
                    ->firstOrFail();
                $walletTransfer = $walletTransferData->id;
            }

            $plannedPayment = new \App\Models\PlannedPayment();
            if($this->plannedPaymentUuid){
                // Update Data
                $plannedPayment = \App\Models\PlannedPayment::where('user_id', \Auth::user()->id)
                    ->where(\DB::raw('BINARY `uuid`'), $this->plannedPaymentUuid)
                    ->firstOrFail();
            }
            $plannedPayment->name = $this->plannedPaymentName;
            $plannedPayment->user_id = \Auth::user()->id;
            $plannedPayment->category_id = $category;
            $plannedPayment->type = $this->plannedPaymentType;
            $plannedPayment->wallet_id = $wallet;
            $plannedPayment->to_wallet_id = $walletTransfer;
            $plannedPayment->amount = $this->plannedPaymentAmount != '' ? $this->plannedPaymentAmount : 0;
            $plannedPayment->extra_type = $this->plannedPaymentExtraType;
            $plannedPayment->extra_percentage = $this->plannedPaymentExtraType === 'percentage' ? $this->plannedPaymentExtraAmount : null;
            $plannedPayment->extra_amount = $this->plannedPaymentExtraType === 'percentage' ? ($this->plannedPaymentAmount * ($this->plannedPaymentExtraAmount / 100)) : ($this->plannedPaymentExtraAmount != '' ? $this->plannedPaymentExtraAmount : 0);
            $plannedPayment->start_date = $datetime;
            if(empty($this->plannedPaymentUuid)){
                $plannedPayment->next_date = $datetime;
            }
            $plannedPayment->repeat_type = $this->plannedPaymentRepeatType;
            $plannedPayment->repeat_every = $this->plannedPaymentRepeat;
            $plannedPayment->until_type = 'forever';
            $plannedPayment->until_number = null;
            $plannedPayment->note = $this->plannedPaymentNote;
            $plannedPayment->save();
            // Planned Payment Tags
            $plannedPayment->plannedPaymentTags()->sync($selectedTags);
        });

        if(!($this->plannedPaymentMoreState)){
            $this->plannedPaymentResetField[] = 'plannedPaymentMoreState';
            $this->dispatchBrowserEvent('close-modalPlannedPayment');
        } else {
            $key = array_search('plannedPaymentMoreState', $this->plannedPaymentResetField);
            if($key !== false){
                unset($this->plannedPaymentResetField[$key]);
            }
        }

        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully '.(empty($this->plannedPaymentUuid) ? 'store new' : 'update').' Planned Payment Data'
        ]);
        $this->emit('refreshComponent');
        $this->reset($this->plannedPaymentResetField);
        $this->dispatchBrowserEvent('trigger-eventPlannedPayment', [
            'plannedPaymentType' => $this->plannedPaymentType,
            'plannedPaymentExtraType' => $this->plannedPaymentExtraType,
            'plannedPaymentAmount' => $this->plannedPaymentAmount,
            'plannedPaymentExtraAmount' => $this->plannedPaymentExtraAmount,
            'plannedPaymentCategory' => $this->plannedPaymentCategory,
            'plannedPaymentWallet' => $this->plannedPaymentWallet,
            'plannedPaymentWalletTransfer' => $this->plannedPaymentWalletTransfer,
            'plannedPaymentRepeatType' => $this->plannedPaymentRepeatType,
            'plannedPaymentTag' => $this->plannedPaymentTag
        ]);
    }
    public function editAction($uuid = null)
    {
        $plannedPayment = \App\Models\PlannedPayment::with('wallet', 'walletTransferTarget', 'category')
            ->where(\DB::raw('BINARY `uuid`'), $uuid)
            ->where('user_id', \Auth::user()->id)
            ->firstOrFail();

        $this->plannedPaymentUuid = $plannedPayment->uuid;
        $this->plannedPaymentTitle = 'Edit Planned Payment';
        $this->plannedPaymentName = $plannedPayment->name;
        $this->plannedPaymentCategory = $plannedPayment->category()->exists() ? $plannedPayment->category->uuid : '';
        $this->plannedPaymentType = $plannedPayment->type;
        $this->plannedPaymentWallet = $plannedPayment->wallet->uuid;
        $this->plannedPaymentWalletTransfer = $plannedPayment->type === 'transfer' ? $plannedPayment->walletTransferTarget->uuid : '';
        $this->plannedPaymentAmount = $plannedPayment->amount;
        $this->plannedPaymentExtraType = $plannedPayment->extra_type;
        $this->plannedPaymentExtraAmount = $plannedPayment->extra_type === 'percentage' ? $plannedPayment->extra_percentage : $plannedPayment->extra_amount;
        $this->plannedPaymentFinalAmount = $plannedPayment->amount + $plannedPayment->extra_amount;
        $this->plannedPaymentPeriod = $plannedPayment->start_date;
        $this->plannedPaymentPeriodTemp = $plannedPayment->start_date;
        $this->plannedPaymentNote = $plannedPayment->note;
        $this->plannedPaymentRepeat = $plannedPayment->repeat_every;
        $this->plannedPaymentRepeatType = $plannedPayment->repeat_type;
        $this->plannedPaymentTag = $plannedPayment->plannedPaymentTags()->exists() ? $plannedPayment->plannedPaymentTags->pluck('uuid') : [];

        $this->dispatchBrowserEvent('trigger-eventPlannedPayment', [
            'plannedPaymentType' => $this->plannedPaymentType,
            'plannedPaymentExtraType' => $this->plannedPaymentExtraType,
            'plannedPaymentAmount' => $this->plannedPaymentAmount,
            'plannedPaymentExtraAmount' => $this->plannedPaymentExtraAmount,
            'plannedPaymentCategory' => $this->plannedPaymentCategory,
            'plannedPaymentWallet' => $this->plannedPaymentWallet,
            'plannedPaymentWalletTransfer' => $this->plannedPaymentWalletTransfer,
            'plannedPaymentRepeatType' => $this->plannedPaymentRepeatType,
            'plannedPaymentTag' => $this->plannedPaymentTag
        ]);
        $this->dispatchBrowserEvent('open-modalPlannedPayment');
    }
    // Handle Modal
    public function openModal()
    {
        $this->plannedPaymentModalState = 'show';
    }
    public function closeModal()
    {
        $this->plannedPaymentResetField[] = 'plannedPaymentMoreState';
        $this->reset($this->plannedPaymentResetField);
        $this->dispatchBrowserEvent('close-modalPlannedPayment');
        $this->dispatchBrowserEvent('trigger-eventPlannedPayment', [
            'plannedPaymentType' => $this->plannedPaymentType,
            'plannedPaymentExtraType' => $this->plannedPaymentExtraType,
            'plannedPaymentAmount' => $this->plannedPaymentAmount,
            'plannedPaymentExtraAmount' => $this->plannedPaymentExtraAmount,
            'plannedPaymentCategory' => $this->plannedPaymentCategory,
            'plannedPaymentWallet' => $this->plannedPaymentWallet,
            'plannedPaymentWalletTransfer' => $this->plannedPaymentWalletTransfer,
            'plannedPaymentRepeatType' => $this->plannedPaymentRepeatType,
            'plannedPaymentTag' => $this->plannedPaymentTag
        ]);
    }
}
