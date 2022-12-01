<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class WalletModal extends Component
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
    public $listWallet;
    // Modal
    public $walletModalState = 'hide';
    public $walletTitle = 'Add new';
    // Form Field
    public $walletUuid = null;
    public $walletParent = '';
    public $walletName = null;
    public $walletBalance = '';
    // Reset Field
    public $walletResetField = [];

    /**
     * Validation
     */
    protected $rules = [
        'walletParent' => ['nullable'],
        'walletName' => ['required'],
    ];

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
        'store' => 'store',
        'fetchTemplate' => 'fetchTemplate',
        'localUpdate' => 'localUpdate',
        'editAction' => 'editAction'
    ];

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->walletResetField = [
            'walletUuid',
            'walletTitle',
            'walletParent',
            'walletName',
            'walletBalance'
        ];
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->fetchMainWallet();

        $this->dispatchBrowserEvent('wallet_wire-init');
        return view('livewire.sys.component.wallet-modal');
    }

    /**
     * Function
     */
    public function fetchMainWallet()
    {
        // Wallet
        $this->listWallet = \App\Models\Wallet::with('child', 'parent')
            ->where('user_id', \Auth::user()->id)
            ->whereNull('parent_id')
            ->orderBy('order_main', 'asc')
            ->get();
    }
    public function save()
    {
        // \Log::debug("Debug on Wallet Modal Component ~ \App\Http\Livewire\Sys\Component\WalletModal", [
        //     'parent' => $this->walletParent,
        //     'name' => $this->walletName,
        //     'balance' => $this->walletBalance,
        //     'modalState' => $this->walletModalState,
        //     'uuid' => $this->walletUuid
        // ]);
        $parent = null;
        if(!empty($this->walletParent)){
            $parent = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->walletParent)
                ->firstOrFail();
        }

        $this->validate();
        $data = new \App\Models\Wallet();
        if(!empty($this->walletUuid)){
            $data = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->walletUuid)
                ->firstOrFail();
            $parent = $data->parent()->exists() ? $data->parent : null;
        } else {
            // Get Last Order
            $order = 0;
            $lastOrder = \App\Models\Wallet::query()
                ->where('user_id', \Auth::user()->id);
            if (!empty($parent)) {
                $lastOrder->where('parent_id', $parent->id);
            } else {
                $lastOrder->whereNull('parent_id');
            }
            $lastOrder = $lastOrder->orderBy('order_main', 'desc')->first();
            if (! empty($lastOrder)) {
                $order = $lastOrder->order_main;
            }

            $data->order = $order + 1;
        }

        $data->user_id = \Auth::user()->id;
        $data->parent_id = !empty($parent) ? $parent->id : null;
        $data->name = $this->walletName;
        $data->type = 'general';
        $data->save();

        $this->fetchMainWallet();
        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully '.(empty($this->walletUuid) ? 'store new' : 'update').' Wallet Data'
        ]);
        $this->reset($this->walletResetField);
        $this->emit('refreshComponent');

        // Re-Order
        (new \App\Http\Livewire\Sys\Wallet\Lists\ReOrder())->reOrder();
    }
    // Handle edit request data
    public function editAction($uuid)
    {
        $data = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->walletUuid = $data->uuid;

        $this->walletTitle = 'Edit';
        $this->walletParent = $data->parent()->exists() ? $data->parent->uuid : '';
        $this->walletName = $data->name;

        $this->dispatchBrowserEvent('wallet_wire-modalShow');
    }
    // Handle Modal
    public function openModal()
    {
        $this->walletModalState = 'show';
    }
    public function closeModal()
    {
        $this->walletModalState = 'hide';
        $this->reset($this->walletResetField);
    }
    // Update Model / Variable
    public function localUpdate($key, $value): void
    {
        // \Log::debug("Debug on Local Update function", [
        //     'key' => $key,
        //     'value' => $value
        // ]);
        switch($key){
            case 'walletModalState':
                $this->walletModalState = $value;
                break;
            case 'walletParent':
                $this->walletParent = $value;
                break;
            case 'walletName':
                $this->walletName = $value;
                break;
            case 'walletBalance':
                $this->walletBalance = $value;
                break;
        }
    }
}
