<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class WalletModal extends Component
{
    public $menuState = null;
    public $submenuState = null;

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

    public $walletResetField = [];
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
        'store' => 'store',
        'fetchTemplate' => 'fetchTemplate',
        'localUpdate' => 'localUpdate',
        'editAction' => 'editAction'
    ];

    protected $rules = [
        'walletParent' => ['nullable'],
        'walletName' => ['required'],
    ];

    public function fetchMainWallet()
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
        $this->walletResetField = [
            'walletUuid',
            'walletTitle',
            'walletParent',
            'walletName',
            'walletBalance'
        ];
    }

    public function render()
    {
        $this->fetchMainWallet();

        $this->dispatchBrowserEvent('wallet_wire-init');
        return view('livewire.sys.component.wallet-modal');
    }

    public function store()
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

        // Get Last Order
        $order = 0;
        $lastOrder = \App\Models\Wallet::query()
            ->where('user_id', \Auth::user()->id);
        if (! empty($parent)) {
            $lastOrder->where('parent_id', $parent->id);
        } else {
            $lastOrder->whereNull('parent_id');
        }
        $lastOrder = $lastOrder->orderBy('order', 'desc')->first();
        if (! empty($lastOrder)) {
            $order = $lastOrder->order;
        }

        $this->validate();
        $data = new \App\Models\Wallet();
        if(!empty($this->walletUuid)){
            $data = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $this->walletUuid)
                ->firstOrFail();
            $parent = $data->parent()->exists() ? $data->parent : null;
        }

        $data->user_id = \Auth::user()->id;
        $data->parent_id = !empty($parent) ? $parent->id : null;
        $data->name = $this->walletName;
        $data->type = 'general';
        $data->order = $order;
        $data->save();

        $this->fetchMainWallet();
        $this->emit('refreshComponent');
        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully '.(empty($this->walletUuid) ? 'store new' : 'update').' Wallet Data'
        ]);
        $this->reset($this->walletResetField);

        // Create Wallet Re-Order Request
        $allParentWallet = \App\Models\Wallet::whereNull('parent_id')
            ->orderBy('order', 'asc')
            ->get();
        $formatedRequest = [];
        if (count($allParentWallet) > 0) {
            foreach ($allParentWallet as $wallet) {
                $arr = [
                    'id' => $wallet->uuid,
                ];

                if ($wallet->child()->exists()) {
                    $childArr = [];
                    foreach ($wallet->child()->orderBy('order', 'asc')->get() as $child) {
                        $childArr[] = [
                            'id' => $child->uuid,
                        ];
                    }

                    $arr = [
                        'id' => $wallet->uuid,
                        'child' => $childArr,
                    ];
                }

                $formatedRequest[] = $arr;
            }

            (new \App\Http\Livewire\Sys\Wallet\Lists\ReOrder())->reOrder($formatedRequest);
        }
    }

    /**
     * Handle edit request data
     */
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
