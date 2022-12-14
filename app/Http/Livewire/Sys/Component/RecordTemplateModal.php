<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class RecordTemplateModal extends Component
{
    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    // List / Select
    public $listCategory;
    public $listWallet;
    public $listTag;
    // Modal
    public $recordTemplateModalState = true;
    public $recordTemplateUuid = null;
    public $recordTemplateTitle = 'Add new Record Template';
    // Form Field
    public $recordTemplateType = 'income';
    public $recordTemplateCategory = '';
    public $recordTemplateWallet = '';
    public $recordTemplateWalletTransfer = '';
    public $recordTemplateAmount = '';
    public $recordTemplateExtraType = 'amount';
    public $recordTemplateExtraAmount = 0;
    public $recordTemplateFinalAmount = 0;
    public $recordTemplateName = '';
    public $recordTemplateNote = '';
    public $recordTemplateMoreState = false;
    public $recordTemplateTag = [];
    // Reset Field
    public $recordTemplateResetField = [];

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'closeModal' => 'closeModal',
        'localUpdate' => 'localUpdate',
        'editAction' => 'editAction'
    ];

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->recordResetField = [
            'recordTemplateUuid',
            'recordTemplateType',
            'recordTemplateCategory',
            'recordTemplateWallet',
            'recordTemplateWalletTransfer',
            'recordTemplateAmount',
            'recordTemplateExtraType',
            'recordTemplateExtraAmount',
            'recordTemplateFinalAmount',
            'recordTemplateName',
            'recordTemplateNote',
            'recordTemplateTag'
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
        
        $this->dispatchBrowserEvent('record_template_wire-init');
        return view('livewire.sys.component.record-template-modal');
    }

    /**
     * Function
     */
    // Fetch List Data
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
        if($this->recordTemplateType === 'transfer'){
            $this->reset([
                'recordTemplateCategory',
                // 'recordTemplateExtraType',
                // 'recordTemplateExtraAmount'
            ]);
        }

        $this->validate([
            'recordTemplateCategory' => ['nullable', 'string', 'exists:'.(new \App\Models\Category())->getTable().',uuid'],
            'recordTemplateWallet' => ['required', 'string', 'exists:'.(new \App\Models\Wallet())->getTable().',uuid'],
            'recordTemplateWalletTransfer' => [($this->recordTemplateType === 'transfer' ? 'required' : 'string'), 'string', 'exists:'.(new \App\Models\Wallet())->getTable().',uuid'],
            'recordTemplateAmount' => ['required'],
            'recordTemplateExtraAmount' => ['nullable'],
            'recordTemplateName' => ['required'],
            'recordTemplateNote' => ['nullable'],
        ]);

        // \Log::debug("Debug on Record Template", [
        //     'name' => $this->recordTemplateName,
        //     'type' => $this->recordTemplateType,
        //     'category' => $this->recordTemplateCategory,
        //     'wallet' => [
        //         'from' => $this->recordTemplateWallet,
        //         'to' => $this->recordTemplateWalletTransfer
        //     ],
        //     'amount' => [
        //         'base' => $this->recordTemplateAmount,
        //         'extra' => [
        //             'type' => $this->recordTemplateExtraType,
        //             'amount' => $this->recordTemplateExtraAmount,
        //         ],
        //         'final' => $this->recordTemplateFinalAmount
        //     ],
        //     'note' => $this->recordTemplateNote
        // ]);

        // Tag, get selected tag
        $selectedTags = [];
        if(!empty($this->recordTemplateTag)){
            $selectedTags = \App\Models\Tag::where('user_id', \Auth::user()->id)
                ->whereIn(\DB::raw('BINARY `uuid`'), $this->recordTemplateTag)
                ->pluck('id')
                ->toArray();
        }

        \DB::transaction(function () use($selectedTags){
            // Category
            $category = null;
            if($this->recordTemplateCategory){
                $categoryData = \App\Models\Category::where(\DB::raw('BINARY `uuid`'), $this->recordTemplateCategory)
                    ->firstOrFail();
                $category = $categoryData->id;
            }
            // Main Wallet
            $wallet = null;
            if($this->recordTemplateWallet){
                $walletData = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->recordTemplateWallet)
                    ->firstOrFail();
                $wallet = $walletData->id;
            }
            // Wallet Transfer
            $walletTransfer = null;
            if($this->recordTemplateType === 'transfer' && $this->recordTemplateWalletTransfer){
                // To
                $walletTransferData = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->recordTemplateWalletTransfer)
                    ->firstOrFail();
                $walletTransfer = $walletTransferData->id;
            }
            
            $recordTemplate = new \App\Models\RecordTemplate();
            if($this->recordTemplateUuid){
                $recordTemplate = \App\Models\RecordTemplate::where('user_id', \Auth::user()->id)
                    ->where(\DB::raw('BINARY `uuid`'), $this->recordTemplateUuid)
                    ->firstOrFail();
            }

            $recordTemplate->name = $this->recordTemplateName;
            $recordTemplate->user_id = \Auth::user()->id;
            $recordTemplate->category_id = $category;
            $recordTemplate->type = $this->recordTemplateType;
            $recordTemplate->wallet_id = $wallet;
            $recordTemplate->to_wallet_id = $walletTransfer;
            $recordTemplate->amount = $this->recordTemplateAmount ?? 0;
            $recordTemplate->extra_type = $this->recordTemplateExtraType;
            $recordTemplate->extra_percentage = $this->recordTemplateExtraType === 'percentage' ? $this->recordTemplateExtraAmount : null;
            $recordTemplate->extra_amount = $this->recordTemplateExtraType === 'percentage' ? ($this->recordTemplateAmount * ($this->recordTemplateExtraAmount / 100)) : ($this->recordTemplateExtraAmount != '' ? $this->recordTemplateExtraAmount : 0);
            $recordTemplate->note = $this->recordTemplateNote;
            $recordTemplate->save();
            // Record Tags
            $recordTemplate->recordTemplateTags()->sync($selectedTags);
        });

        if(!($this->recordTemplateMoreState)){
            $this->recordResetField[] = 'recordTemplateMoreState';
            $this->dispatchBrowserEvent('close-modalRecordTemplate');
        } else {
            $key = array_search('recordTemplateMoreState', $this->recordResetField);
            if($key !== false){
                unset($this->recordResetField[$key]);
            }
        }
        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully '.(empty($this->recordTemplateUuid) ? 'store new' : 'update').' Record Template Data'
        ]);
        $this->reset($this->recordResetField);
        $this->dispatchBrowserEvent('trigger-eventRecordTemplate', [
            'recordTemplateType' => $this->recordTemplateType,
            'recordTemplateAmount' => $this->recordTemplateAmount,
            'recordTemplateExtraType' => $this->recordTemplateExtraType,
            'recordTemplateExtraAmount' => $this->recordTemplateExtraAmount,
            'recordTemplateCategory' => $this->recordTemplateCategory,
            'recordTemplateWallet' => $this->recordTemplateWallet,
            'recordTemplateWalletTransfer' => $this->recordTemplateWalletTransfer,
            'recordTemplateTag' => $this->recordTemplateTag,
        ]);
    }
    // Handle edit request data
    public function editAction($uuid)
    {
        $data = \App\Models\RecordTemplate::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->recordTemplateUuid = $data->uuid;

        $this->recordTemplateTitle = 'Edit';
        $this->recordTemplateType = $data->type;
        $this->recordTemplateCategory = $data->category()->exists() ? $data->category->uuid : '';
        $this->recordTemplateWallet = $data->wallet()->exists() ? $data->wallet->uuid : '';
        $this->recordTemplateWalletTransfer = $data->walletTransferTarget()->exists() ? $data->walletTransferTarget->uuid : '';
        $this->recordTemplateAmount = $data->amount;
        $this->recordTemplateExtraType = $data->extra_type;
        $this->recordTemplateExtraAmount = $data->extra_type === 'percentage' ? $data->extra_percentage : $data->extra_amount;
        $this->recordTemplateName = $data->name;
        $this->recordTemplateNote = $data->note;
        $this->recordTemplateTag = $data->recordTemplateTags()->exists() ? $data->recordTemplateTags->pluck('uuid') : [];

        $this->dispatchBrowserEvent('trigger-eventRecordTemplate', [
            'recordTemplateType' => $this->recordTemplateType,
            'recordTemplateAmount' => $this->recordTemplateAmount,
            'recordTemplateExtraType' => $this->recordTemplateExtraType,
            'recordTemplatextraAmount' => $this->recordTemplateExtraAmount,
            'recordTemplateCategory' => $this->recordTemplateCategory,
            'recordTemplateWallet' => $this->recordTemplateWallet,
            'recordTemplateWalletTransfer' => $this->recordTemplateWalletTransfer,
            'recordTemplateTag' => $this->recordTemplateTag,
        ]);
        $this->dispatchBrowserEvent('open-modalRecordTemplate');
    }
    // Handle Modal
    public function openModal()
    {
        $this->emit($this->recordTemplateModalState ? 'show' : 'hide');
    }
    public function closeModal()
    {
        $this->recordResetField[] = 'recordTemplateMoreState';
        $this->reset($this->recordResetField);
        $this->dispatchBrowserEvent('close-modalRecordTemplate');
        $this->dispatchBrowserEvent('trigger-eventRecordTemplate', [
            'recordTemplateType' => $this->recordTemplateType,
            'recordTemplateAmount' => $this->recordTemplateAmount,
            'recordTemplateExtraType' => $this->recordTemplateExtraType,
            'recordTemplateExtraAmount' => $this->recordTemplateExtraAmount,
            'recordTemplateCategory' => $this->recordTemplateCategory,
            'recordTemplateWallet' => $this->recordTemplateWallet,
            'recordTemplateWalletTransfer' => $this->recordTemplateWalletTransfer,
            'recordTemplateTag' => $this->recordTemplateTag,
        ]);
    }
}
