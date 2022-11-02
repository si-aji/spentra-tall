<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class WalletShareModal extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // List / Select
    public $listWallet;

    // Modal
    public $walletShareModalState = 'hide';
    public $walletShareTitle = 'Add new';

    // Form Field
    public $user_timezone;
    public $walletShareUuid = '';
    public $walletShareToken = '';
    public $walletSharePassphrase = '';
    public $walletShareNote = '';
    public $walletShareTimeLimit = 'lifetime';
    public $walletShareItem = [];

    public $walleShareResetField = [];
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
    ];

    protected $rules = [
        'walletSharePassphrase' => ['nullable', 'string'],
        'walletShareNote' => ['nullable'],
        'walletShareItem.*' => ['required']
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
        $this->walleShareResetField = [
            'walletShareTitle',
            'walletShareToken',
            'walletSharePassphrase',
            'walletShareNote',
            'walletShareTimeLimit',
            'walletShareItem'
        ];
    }

    public function render()
    {
        $this->fetchMainWallet();
        $this->dispatchBrowserEvent('wallet_share_wire-init');

        return view('livewire.sys.component.wallet-share-modal');
    }

    public function save()
    {
        $selectedWallet = [];
        if(!empty($this->walletShareItem)){
            $selectedWallet = \App\Models\Wallet::whereIn(\DB::raw('BINARY `uuid`'), $this->walletShareItem)
                ->pluck('id')
                ->toArray();
        }

        \DB::transaction(function () use ($selectedWallet) {
            // \Log::debug("Debug on Wallet Share Modal", [
            //     'passphrase' => $this->walletSharePassphrase,
            //     'description' => $this->walletShareNote,
            //     'timelimit' => $this->walletShareTimeLimit,
            //     'item' => $this->walletShareItem
            // ]);

            $data = new \App\Models\WalletShare();
            $data->user_id = \Auth::user()->id;
            $data->share_limit = $this->walletShareTimeLimit;
            $data->limit_period = null;
            $data->limit_open = null;
            $data->passphrase = siacryption($this->walletSharePassphrase, true);
            if(empty($this->walletShareUuid)){
                $data->token = generateRandomString(12);
            }
            $data->note = $this->walletShareNote;
            $data->timezone_offset = $this->user_timezone;
            $data->save();
            // Save Item
            $data->walletShareDetail()->sync($selectedWallet);
        });

        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully '.(empty($this->walletShareUuid) ? 'store new' : 'update').' Wallet Share Data'
        ]);
        $this->reset($this->walleShareResetField);
    }

    // Handle Modal
    public function openModal()
    {
        $this->walletShareModalState = 'show';
    }
    public function closeModal()
    {
        $this->walletShareModalState = 'hide';
        $this->reset($this->walleShareResetField);
    }
}
