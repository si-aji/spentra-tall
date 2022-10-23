<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class WalletGroupModal extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // List / Select
    public $listWallet;

    // Modal
    public $forceHide = false;
    public $walletGroupModalState = 'hide';
    public $walletGroupTitle = 'Add new';

    // Form Field
    public $walletGroupUuid = null;
    public $walletGroupList = null;
    public $walletGroupName = null;

    public $walletGroupResetField = [];
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
        'walletGroupList' => ['nullable'],
        'walletGroupName' => ['required'],
    ];

    /**
     * Fetch List Data
     */
    public function fetchWallet()
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
        $this->walletGroupResetField = [
            'walletGroupUuid',
            'walletGroupTitle',
            'walletGroupName',
            'walletGroupList',
            'forceHide'
        ];
    }

    /**
     * Render component livewire view
     * 
     */
    public function render()
    {
        $this->fetchWallet();
        $this->dispatchBrowserEvent('wallet_group_wire-init');

        return view('livewire.sys.component.wallet-group-modal');
    }

    /**
     * CRUD Action
     */
    public function save()
    {
        $selectedWallet = [];
        if(!empty($this->walletGroupList)){
            foreach ($this->walletGroupList as $wallet) {
                $walletData = \App\Models\Wallet::where(\DB::raw('BINARY `uuid`'), $wallet)->firstOrFail();

                $selectedWallet[] = $walletData->id;
            }
        }

        $this->validate();
        \DB::transaction(function () use ($selectedWallet) {
            $data = new \App\Models\WalletGroup();
            if(!empty($this->walletGroupUuid)){
                $data = \App\Models\WalletGroup::where(\DB::raw('BINARY `uuid`'), $this->walletGroupUuid)
                    ->firstOrFail();
            }

            // Save to Group
            $data->user_id = \Auth::user()->id;
            $data->name = $this->walletGroupName;
            $data->save();
            // Sync between Wallet Group and Wallet Group List
            $data->walletGroupList()->sync($selectedWallet);
        });

        if($this->forceHide){
            $this->dispatchBrowserEvent('wallet_group_wire-modalHide');
        }

        $this->fetchWallet();
        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully store new Wallet Data'
        ]);
        $this->reset($this->walletGroupResetField);
        $this->emit('refreshComponent');
    }

    /**
     * Handle edit request data
     */
    public function editAction($uuid, $detailPage = false)
    {
        $data = \App\Models\WalletGroup::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->walletGroupUuid = $data->uuid;

        $this->walletGroupTitle = 'Edit';
        $this->walletGroupName = $data->name;

        $selectedWallet = [];
        foreach($data->walletGroupList as $list){
            $selectedWallet[] = $list->uuid;
        }
        $this->walletGroupList = $selectedWallet;

        $this->dispatchBrowserEvent('wallet_group_wire-modalShow');
        if($detailPage){
            $this->forceHide = true;
        }
    }

    // Handle Modal
    public function openModal()
    {
        $this->walletGroupModalState = 'show';
    }
    public function closeModal()
    {
        $this->walletGroupModalState = 'hide';
        $this->reset($this->walletGroupResetField);
    }// Update Model / Variable
    public function localUpdate($key, $value): void
    {
        // \Log::debug("Debug on Local Update function", [
        //     'key' => $key,
        //     'value' => $value
        // ]);
        switch($key){
            case 'walletGroupModalState':
                $this->walletGroupModalState = $value;
                break;
            case 'walletGroupName':
                $this->walletGroupName = $value;
                break;
            case 'walletGroupList':
                $this->walletGroupList = $value;
                break;
        }
    }
}
