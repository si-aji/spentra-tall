<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class BudgetModal extends Component
{
    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    // Modal
    public $budgetModalState = 'hide';
    public $budgetTitle = 'Add new';
    // Form Field
    public $budgetName = null;
    public $budgetPeriod = null;
    public $budgetAmount = null;
    public $budgetIncludedWallet = [];
    public $budgetIncludedCategory = [];
    public $budgetIncludedTags = [];
    public $budgetExcludedWallet = [];
    public $budgetExcludedCategory = [];
    public $budgetExcludedTags = [];
    // Reset Field
    public $budgetResetField = [];
    // List
    public $listCategory;
    public $listWallet;
    public $listTag;

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
    ];

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->budgetResetField = [
            'budgetName',
            'budgetPeriod',
            'budgetAmount',
            'budgetIncludedWallet',
            'budgetIncludedCategory',
            'budgetIncludedTags',
            'budgetExcludedWallet',
            'budgetExcludedCategory',
            'budgetExcludedTags',
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
        
        return view('livewire.sys.component.budget-modal');
    }

    /**
     * Function
     */
    public function closeModal()
    {
        $this->budgetModalState = 'hide';
        $this->reset($this->budgetResetField);

        $this->dispatchBrowserEvent('trigger-eventBudget', [
            'budgetName' => $this->budgetName,
            'budgetPeriod' => $this->budgetPeriod,
            'budgetAmount' => $this->budgetAmount,
            'budgetIncludedWallet' => $this->budgetIncludedWallet,
            'budgetIncludedCategory' => $this->budgetIncludedCategory,
            'budgetIncludedTags' => $this->budgetIncludedTags,
            'budgetExcludedWallet' => $this->budgetExcludedWallet,
            'budgetExcludedCategory' => $this->budgetExcludedCategory,
            'budgetExcludedTags' => $this->budgetExcludedTags,
        ]);
    }
    public function save()
    {
        $this->validate([
            'budgetName' => ['required', 'string'],
            'budgetPeriod' => ['required', 'string', 'in:daily,weekly,monthly,yearly'],
            'budgetAmount' => ['required', 'numeric', 'min:0'],
            'budgetIncludedWallet.*' => ['nullable', 'string', 'exists:'.(new \App\Models\Wallet())->getTable().',uuid', 'not_in:'.implode(',', $this->budgetExcludedWallet)],
            'budgetIncludedCategory.*' => ['nullable', 'string', 'exists:'.(new \App\Models\Category())->getTable().',uuid', 'not_in:'.implode(',', $this->budgetExcludedCategory)],
            'budgetIncludedTags.*' => ['nullable', 'string', 'exists:'.(new \App\Models\Tag())->getTable().',uuid', 'not_in:'.implode(',', $this->budgetExcludedTags)],
            'budgetExcludedWallet.*' => ['nullable', 'string', 'exists:'.(new \App\Models\Wallet())->getTable().',uuid', 'not_in:'.implode(',', $this->budgetIncludedWallet)],
            'budgetExcludedCategory.*' => ['nullable', 'string', 'exists:'.(new \App\Models\Category())->getTable().',uuid', 'not_in:'.implode(',', $this->budgetIncludedCategory)],
            'budgetExcludedTags.*' => ['nullable', 'string', 'exists:'.(new \App\Models\Tag())->getTable().',uuid', 'not_in:'.implode(',', $this->budgetIncludedTags)],
        ]);
        $data = new \App\Models\Category();

        \Log::debug("Debug on Budget Modal Save", [
            'name' => $this->budgetName,
            'period' => $this->budgetPeriod,
            'amount' => $this->budgetAmount,
            'included' => [
                'wallet' => $this->budgetIncludedWallet,
                'category' => $this->budgetIncludedCategory,
                'tags' => $this->budgetIncludedTags,
            ],
            'exlucded' => [
                'wallet' => $this->budgetExcludedWallet,
                'category' => $this->budgetExcludedCategory,
                'tags' => $this->budgetExcludedTags,
            ]
        ]);
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
}
