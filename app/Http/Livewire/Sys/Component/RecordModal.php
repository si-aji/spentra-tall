<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\WithFileUploads;
use Livewire\Component;

class RecordModal extends Component
{
    use WithFileUploads;

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
    public $recordModalState = true;
    public $recordUuid = null;
    public $recordTitle = 'Add new Record';
    // Form Field
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
    public $recordPeriodChanged = false;
    public $recordNote = '';
    public $recordReceipt = null;
    public $recordReceiptTemp = null;
    public $recordMoreState = false;
    public $recordTag = [];
    // Reset Field
    public $recordResetField = [];

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
            'recordUuid',
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
            'recordPeriodChanged',
            'recordNote',
            'recordReceipt',
            'recordReceiptTemp',
            'recordTag'
        ];
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->fetchListTemplate();
        $this->fetchListCategory();
        $this->fetchListWallet();
        $this->fetchListTag();

        // \Log::debug("Debug on Record Modal render", [
        //     'category' => $this->recordCategory,
        //     'wallet' => $this->recordWallet,
        //     'walletTransfer' => $this->recordWalletTransfer,
        // ]);

        $this->dispatchBrowserEvent('recordModal_wire-init');
        return view('livewire.sys.component.record-modal');
    }

    /**
     * Function
     */
    public function upload($name)
    {
        $destinationPath = 'files/user'.'/'.\Auth::user()->uuid.'/receipt';
        // Check if directory exists
        if (! (\File::exists($destinationPath))) {
            \File::makeDirectory($destinationPath, 0777, true, true);
        }

        \Log::debug("Debug on Upload file", [
            'name' => $name
        ]);

        $this->recordReceipt->storeAs($destinationPath, $name);
    }
    // Fetch Data
    public function fetchDataTemplateData($uuid = null)
    {
        if($uuid == ''){
            $this->recordTemplate = '';
            $this->reset($this->recordResetField);
            return false;
        }

        $data = \App\Models\RecordTemplate::where('user_id', \Auth::user()->id)
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
            'recordExtraAmount' => $this->recordExtraAmount,
            'recordCategory' => $this->recordCategory,
            'recordWallet' => $this->recordWallet,
            'recordWalletTransfer' => $this->recordWalletTransfer,
            'recordTag' => $this->recordTag,
            'recordTemplate' => $this->recordTemplate,
        ]);
    }
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
    public function fetchListTag()
    {
        // Tag
        $this->listTag = \App\Models\Tag::where('user_id', \Auth::user()->id)
            ->orderBy('name', 'asc')
            ->get();
    }
    public function updatedRecordReceipt()
    {
        // if($this->recordReceipt){
        //     if(round($this->recordReceipt->getSize()) / 1024.4 > 100){
        //         throw \Illuminate\Validation\ValidationException::withMessages([
        //             'recordReceipt' => 'The record receipt must not be greater than 100 kilobytes.'
        //         ]);
        //     }
        // }

        $this->validate([
            'recordReceipt' => 'mimes:jpg,jpeg,png,pdf|max:1024',
        ]);
    }
    public function editAction($uuid)
    {
        $record = \App\Models\Record::with('wallet', 'walletTransferTarget', 'category', 'recordTags')
            ->where('user_id', \Auth::user()->id)
            ->where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();

        $this->recordUuid = $record->uuid;
        $this->recordTitle = 'Edit Record';
        $this->recordCategory = $record->category()->exists() ? $record->category->uuid : '';
        $this->recordType = !empty($record->to_wallet_id) ? 'transfer' : $record->type;
        $this->recordWallet = !empty($record->to_wallet_id) ? ($record->type === 'expense' ? $record->wallet->uuid : $record->walletTransferTarget->uuid) : $record->wallet->uuid;
        $this->recordWalletTransfer = !empty($record->to_wallet_id) ? ($record->type === 'income' ? $record->wallet->uuid : $record->walletTransferTarget->uuid) : '';
        if(!empty($record->to_wallet_id) && $record->type !== 'expense'){
            /**
             * Transfer Record
             * */ 

            // Get related record
            $relatedRecord = $record->getRelatedTransferRecord();

            // Update extra amount
            $this->recordAmount = $relatedRecord->amount;
            $this->recordExtraType = $relatedRecord->extra_type;
            $this->recordExtraAmount = $relatedRecord->extra_type === 'percentage' ? $relatedRecord->extra_percentage : $relatedRecord->extra_amount;
            $this->recordFinalAmount = $relatedRecord->amount + $record->extra_amount;
        } else {
            $this->recordAmount = $record->amount;
            $this->recordExtraType = $record->extra_type;
            $this->recordExtraAmount = $record->extra_type === 'percentage' ? $record->extra_percentage : $record->extra_amount;
            $this->recordFinalAmount = $record->amount + $record->extra_amount;
        }
        $this->recordPeriod = $record->datetime;
        $this->recordPeriodTemp = $record->datetime;
        $this->recordNote = $record->note;
        // $this->recordReceipt = $record->receipt;
        $this->recordReceiptTemp = $record->receipt;
        $this->recordTag = $record->recordTags()->exists() ? $record->recordTags->pluck('uuid') : [];

        $this->dispatchBrowserEvent('trigger-event', [
            'recordType' => $this->recordType,
            'recordExtraType' => $this->recordExtraType,
            'recordAmount' => $this->recordAmount,
            'recordExtraAmount' => $this->recordExtraAmount,
            'recordCategory' => $this->recordCategory,
            'recordWallet' => $this->recordWallet,
            'recordWalletTransfer' => $this->recordWalletTransfer,
            'recordTag' => $this->recordTag,
            'recordTemplate' => $this->recordTemplate,
        ]);
        $this->dispatchBrowserEvent('open-modal');
    }
    // Handle Data
    public function save($quitely = false, $plannedPaymentRecord = null)
    {
        $this->resetValidation();
        // Reset Field if Transfer
        if($this->recordType === 'transfer'){
            $this->reset([
                'recordCategory',
                // 'recordExtraType',
                // 'recordExtraAmount'
            ]);
        }

        $this->validate([
            'recordCategory' => ['nullable', 'string', 'exists:'.(new \App\Models\Category())->getTable().',uuid'],
            'recordWallet' => ['required', 'string', 'exists:'.(new \App\Models\Wallet())->getTable().',uuid'],
            'recordWalletTransfer' => [($this->recordType === 'transfer' ? 'required' : 'string'), 'string', 'exists:'.(new \App\Models\Wallet())->getTable().',uuid'],
            'recordAmount' => ['required'],
            'recordExtraAmount' => ['nullable'],
            'recordPeriod' => ['required'],
            'recordNote' => ['nullable'],
            'recordReceipt' => ['nullable', 'mimes:jpg,jpeg,png,pdf', 'max:1024']
        ]);

        // \Log::debug("Debug on Record Modal Store", [
        //     'uuid' => $this->recordUuid,
        //     'wallet' => $this->recordWallet,
        //     'recordAmount' => $this->recordAmount,
        //     'type' => $this->recordType,
        //     'period' => $this->recordPeriod,
        //     'user_timezone' => $this->user_timezone
        // ]);

        // Period, convert to UTC
        $datetime = date("Y-m-d H:i", strtotime($this->recordPeriod));
        if($this->user_timezone){
            $raw = date('Y-m-d H:i:00', strtotime($this->recordPeriod));
            // Convert to UTC
            $utc = convertToUtc($raw, ($this->user_timezone));
            $datetime = date('Y-m-d H:i:00', strtotime($utc));
        }
        // Tag, get selected tag
        $selectedTags = [];
        if(!empty($this->recordTag)){
            $selectedTags = \App\Models\Tag::where('user_id', \Auth::user()->id)
                ->whereIn(\DB::raw('BINARY `uuid`'), $this->recordTag)
                ->pluck('id')
                ->toArray();
        }
        // \Log::debug("Debug on Selected Tags", [
        //     'this' => $this->recordTag,
        //     'arr' => $selectedTags
        // ]);

        // Receipt file Upload
        $file = null;
        if(!empty($this->recordUuid)){
            $file = $this->recordReceiptTemp;
        }
        // Upload file if file exists
        if($this->recordReceipt){
            if($this->recordUuid && !empty($file)){
                // Remove old File
                \Storage::delete($file);
            }

            $destinationPath = 'files/user'.'/'.\Auth::user()->uuid.'/receipt';
            // Check if directory exists
            if (! (\File::exists($destinationPath))) {
                \File::makeDirectory($destinationPath, 0777, true, true);
            }

            $file = $this->recordReceipt->store($destinationPath);
            // Empty file
            $this->recordReceipt = null;
        }

        // Category
        $category = null;
        if($this->recordCategory){
            $categoryData = \App\Models\Category::where(\DB::raw('BINARY `uuid`'), $this->recordCategory)
                ->firstOrFail();
            $category = $categoryData->id;
        }
        // Main Wallet
        $wallet = null;
        if($this->recordWallet){
            $walletData = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->recordWallet)
                ->firstOrFail();
            $wallet = $walletData->id;
        }

        \DB::transaction(function () use ($category, $wallet, $datetime, $file, $plannedPaymentRecord, $selectedTags) {
            if($this->recordUuid){
                // Update update Function
                $record = \App\Models\Record::where('user_id', \Auth::user()->id)
                    ->where(\DB::raw('BINARY `uuid`'), $this->recordUuid)
                    ->firstOrFail();
    
                if($this->recordType === 'transfer'){
                    // Wallet Transfer
                    $walletTransfer = null;
                    if($this->recordWalletTransfer){
                        // To
                        $walletTransferData = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->recordWalletTransfer)
                            ->firstOrFail();
                        $walletTransfer = $walletTransferData->id;
                    }
    
                    // Fetch related record
                    $relatedRecord = new \App\Models\Record();
                    if(!empty($record->to_wallet_id)){
                        // Previos data is transfer, use related data instead of new one
                        $relatedRecord = \App\Models\Record::where(\DB::raw('BINARY `uuid`'), $record->getRelatedTransferRecord()->uuid)
                            ->firstOrFail();
                    }

                    // Handle Extra Amount
                    $extraType = 'amount';
                    $extraPercentage = 0;
                    $extraAmount = 0;
                    if($record->type === 'expense'){
                        $extraType = $this->recordExtraType;
                        $extraPercentage =  $this->recordExtraType === 'percentage' ? $this->recordExtraAmount : 0;
                        $extraAmount = $this->recordExtraType === 'amount' ? ($this->recordExtraAmount ?? 0) : ($this->recordAmount * ($this->recordExtraAmount / 100));
                    }
    
                    $record->user_id = \Auth::user()->id;
                    $record->category_id = $category;
                    $record->type = $record->type === 'expense' ? 'expense' : 'income';
                    $record->wallet_id = $record->type === 'expense' ? $wallet : $walletTransfer;
                    $record->to_wallet_id = $record->type === 'expense' ? $walletTransfer : $wallet;
                    $record->amount = $this->recordAmount;
                    $record->extra_type = $extraType;
                    $record->extra_percentage = $extraPercentage;
                    $record->extra_amount = $extraAmount;
                    $record->date = date("Y-m-d", strtotime($datetime));
                    $record->time = date("H:i:00", strtotime($datetime));
                    $record->datetime = $datetime;
                    $record->note = $this->recordNote;
                    $record->status = 'complete';
                    $record->receipt = $file;
                    $record->timezone_offset = $this->user_timezone;
                    $record->save();
                    // Record Tags
                    $record->recordTags()->sync($selectedTags);
    
                    // Handle Extra Amount
                    $extraType = 'amount';
                    $extraPercentage = 0;
                    $extraAmount = 0;
                    if($record->type !== 'expense'){
                        $extraType = $this->recordExtraType;
                        $extraPercentage =  $this->recordExtraType === 'percentage' ? $this->recordExtraAmount : 0;
                        $extraAmount = $this->recordExtraType === 'amount' ? ($this->recordExtraAmount ?? 0) : ($this->recordAmount * ($this->recordExtraAmount / 100));
                    }
                    // Update related record
                    $relatedRecord->user_id = \Auth::user()->id;
                    $relatedRecord->category_id = $category;
                    $relatedRecord->type = $record->type === 'expense' ? 'income' : 'expense';
                    $relatedRecord->wallet_id = $record->type === 'expense' ? $walletTransfer : $wallet;
                    $relatedRecord->to_wallet_id = $record->type === 'expense' ? $wallet : $walletTransfer;
                    $relatedRecord->amount = $this->recordAmount;
                    $relatedRecord->extra_type = $extraType;
                    $relatedRecord->extra_percentage = $extraPercentage;
                    $relatedRecord->extra_amount = $extraAmount;
                    $relatedRecord->date = date("Y-m-d", strtotime($datetime));
                    $relatedRecord->time = date("H:i:00", strtotime($datetime));
                    $relatedRecord->datetime = $datetime;
                    $relatedRecord->note = $this->recordNote;
                    $relatedRecord->status = 'complete';
                    $relatedRecord->receipt = $file;
                    $relatedRecord->timezone_offset = $this->user_timezone;
                    $relatedRecord->save();
                    // Related Record Tags
                    $relatedRecord->recordTags()->sync($selectedTags);
                } else {
                    // New data is either expense / income
                    if(!empty($record->to_wallet_id)){
                        // Previous data is transfer, remove related data
                        if(!empty($record->getRelatedTransferRecord())){
                            $record->getRelatedTransferRecord()->delete();
                        };
                    }
    
                    $record->category_id = $category;
                    $record->type = $this->recordType;
                    $record->wallet_id = $wallet;
                    $record->to_wallet_id = null;
                    $record->amount = $this->recordAmount;
                    $record->extra_type = $this->recordExtraType;
                    $record->extra_percentage = $this->recordExtraType === 'percentage' ? $this->recordExtraAmount : 0;
                    $record->extra_amount = $this->recordExtraType === 'amount' ? ($this->recordExtraAmount ?? 0) : ($this->recordAmount * ($this->recordExtraAmount / 100));
                    $record->date = date("Y-m-d", strtotime($datetime));
                    $record->time = date("H:i:00", strtotime($datetime));
                    $record->datetime = $datetime;
                    $record->note = $this->recordNote;
                    $record->status = 'complete';
                    $record->receipt = $file;
                    $record->timezone_offset = $this->user_timezone;
                    $record->save();
                    // Record Tags
                    $record->recordTags()->sync($selectedTags);
                }
            } else {
                // Handle store function
                if($this->recordType === 'transfer'){
                    $type = ['expense', 'income'];
                    $walletTransfer = null;
                    if($this->recordWalletTransfer){
                        // To
                        $walletTransferData = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->recordWalletTransfer)
                            ->firstOrFail();
                        $walletTransfer = $walletTransferData->id;
                    }
    
                    foreach($type as $typ){        
                        $extraType = 'amount';
                        $extraPercentage = 0;
                        $extraAmount = 0;
                        if($typ === 'expense'){
                            $extraType = $this->recordExtraType;
                            $extraPercentage =  $this->recordExtraType === 'percentage' ? $this->recordExtraAmount : 0;
                            $extraAmount = $this->recordExtraType === 'amount' ? ($this->recordExtraAmount ?? 0) : ($this->recordAmount * ($this->recordExtraAmount / 100));
                        }
                        
                        $data = new \App\Models\Record();
                        $data->user_id = \Auth::user()->id;
                        $data->category_id = $category;
                        $data->type = $typ;
                        $data->wallet_id = $typ === 'expense' ? $wallet : $walletTransfer;
                        $data->to_wallet_id = $typ === 'expense' ? $walletTransfer : $wallet;
                        $data->amount = $this->recordAmount;
                        $data->extra_type = $extraType;
                        $data->extra_percentage = $extraPercentage;
                        $data->extra_amount = $extraAmount;
                        $data->date = date("Y-m-d", strtotime($datetime));
                        $data->time = date("H:i:00", strtotime($datetime));
                        $data->datetime = $datetime;
                        $data->note = $this->recordNote;
                        $data->status = 'complete';
                        $data->receipt = $file;
                        $data->timezone_offset = $this->user_timezone;
                        $data->save();
                        // Record Tags
                        $data->recordTags()->sync($selectedTags);

                        if($plannedPaymentRecord !== null){
                            if($typ === 'expense'){
                                $plannedPaymentRecord->record_id = $data->id;
                            } else if($typ === 'income'){
                                $plannedPaymentRecord->to_record_id = $data->id;
                            }

                            $plannedPaymentRecord->save();
                        }
                    }
                } else {
                    $data = new \App\Models\Record();
                    $data->user_id = \Auth::user()->id;
                    $data->category_id = $category;
                    $data->type = $this->recordType;
                    $data->wallet_id = $wallet;
                    $data->to_wallet_id = null;
                    $data->amount = $this->recordAmount;
                    $data->extra_type = $this->recordExtraType;
                    $data->extra_percentage = $this->recordExtraType === 'percentage' ? $this->recordExtraAmount : 0;
                    $data->extra_amount = $this->recordExtraType === 'amount' ? ($this->recordExtraAmount ?? 0) : ($this->recordAmount * ($this->recordExtraAmount / 100));
                    $data->date = date("Y-m-d", strtotime($datetime));
                    $data->time = date("H:i:00", strtotime($datetime));
                    $data->datetime = $datetime;
                    $data->note = $this->recordNote;
                    $data->status = 'complete';
                    $data->receipt = $file;
                    $data->timezone_offset = $this->user_timezone;
                    $data->save();
                    // Record Tags
                    $data->recordTags()->sync($selectedTags);

                    if($plannedPaymentRecord !== null){
                        $plannedPaymentRecord->record_id = $data->id;
                        $plannedPaymentRecord->save();
                    }
                }
            }
        });

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
        if(!$quitely){
            $this->dispatchBrowserEvent('trigger-event', [
                'recordType' => $this->recordType,
                'recordExtraType' => $this->recordExtraType,
                'recordAmount' => $this->recordAmount,
                'recordExtraAmount' => $this->recordExtraAmount,
                'recordCategory' => $this->recordCategory,
                'recordWallet' => $this->recordWallet,
                'recordWalletTransfer' => $this->recordWalletTransfer,
                'recordTag' => $this->recordTag,
                'recordTemplate' => $this->recordTemplate,
                'resetPeriod' => true
            ]);
            $this->dispatchBrowserEvent('wire-action', [
                'status' => 'success',
                'action' => 'Success',
                'message' => 'Successfully '.(empty($this->recordUuid) ? 'store new' : 'update').' Record Data'
            ]);
        }
        
        $this->emit('refreshComponent');
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
        // \Log::debug("Remove Receipt", [
        //     '!empty' => $this->recordReceipt ? 'true' : 'false'
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
        $this->fetchListTemplate();
        $this->fetchListCategory();
        $this->fetchListWallet();
        $this->emit($this->recordModalState ? 'show' : 'hide');
    }
    public function closeModal()
    {
        $this->recordResetField[] = 'recordMoreState';
        $this->reset($this->recordResetField);
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('trigger-event', [
            'recordType' => $this->recordType,
            'recordExtraType' => $this->recordExtraType,
            'recordAmount' => $this->recordAmount,
            'recordExtraAmount' => $this->recordExtraAmount,
            'recordCategory' => $this->recordCategory,
            'recordWallet' => $this->recordWallet,
            'recordWalletTransfer' => $this->recordWalletTransfer,
            'recordTag' => $this->recordTag,
            'recordTemplate' => $this->recordTemplate,
        ]);
        $this->resetValidation();
    }
}
