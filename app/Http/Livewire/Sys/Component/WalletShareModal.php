<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class WalletShareModal extends Component
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
    // Reset Field
    public $walleShareResetField = [];

    /**
     * Validation
     */
    protected $rules = [
        'walletSharePassphrase' => ['nullable', 'string'],
        'walletShareNote' => ['nullable'],
        'walletShareItem.*' => ['required']
    ];

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
        $this->walleShareResetField = [
            'walletShareTitle',
            'walletShareToken',
            'walletSharePassphrase',
            'walletShareNote',
            'walletShareTimeLimit',
            'walletShareItem'
        ];
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->fetchMainWallet();
        $this->dispatchBrowserEvent('wallet_share_wire-init');

        return view('livewire.sys.component.wallet-share-modal');
    }

    /**
     * Function
     */
    // Fetch List Data
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
            if($this->walletShareUuid){
                $data = \App\Models\WalletShare::where(\DB::raw('BINARY `uuid`'), $this->walletShareUuid)
                    ->firstOrFail();
            }

            $data->user_id = \Auth::user()->id;
            $data->share_limit = $this->walletShareTimeLimit;
            $data->limit_period = null;
            $data->limit_open = null;
            $data->passphrase = $this->walletSharePassphrase ? siacryption($this->walletSharePassphrase, true) : null;
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
        $this->dispatchBrowserEvent('trigger-eventWalletShare', [
            'walletShareToken' => $this->walletShareToken,
            'walletShareNote' => $this->walletShareNote,
            'walletSharePassphrase' => $this->walletSharePassphrase,
            'walletShareItem' => $this->walletShareItem,
        ]);
    }
    // Handle edit request data
    public function editAction($uuid, $detailPage = false)
    {
        $this->walletShareTitle = 'Wallet Share: Edit';

        $data = \App\Models\WalletShare::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->walletShareUuid = $data->uuid;
        $this->walletShareToken = $data->token;
        $this->walletShareNote = $data->note;
        $this->walletSharePassphrase = !empty($data->passphrase) ? siacryption($data->passphrase) : null;
        $this->walletShareItem = $data->walletShareDetail()->get()->pluck('uuid')->toArray();

        $this->dispatchBrowserEvent('trigger-eventWalletShare', [
            'walletShareToken' => $this->walletShareToken,
            'walletShareNote' => $this->walletShareNote,
            'walletSharePassphrase' => $this->walletSharePassphrase,
            'walletShareItem' => $this->walletShareItem,
        ]);
        $this->dispatchBrowserEvent('wallet_share_wire-modalShow');
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
