<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class ShoppingListModal extends Component
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
    public $shoppingListModalState = 'hide';
    public $shoppingListTitle = 'Add new';
    // Form Field
    public $shoppingListUuid = null;
    public $shoppingListName = null;
    public $shoppingListDescription = null;
    public $shoppingListBudget = null;
    // Reset Field
    public $shoppingListResetField = [];

    /**
     * Validation
     */
    protected $rules = [
        'shoppingListName' => ['required'],
        'shoppingListDescription' => ['nullable', 'string'],
        'shoppingListBudget' => ['nullable', 'numeric']
    ];

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
        'store' => 'store',
        'localUpdate' => 'localUpdate',
        'editAction' => 'editAction'
    ];

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->shoppingListResetField = [
            'shoppingListUuid',
            'shoppingListTitle',
            'shoppingListName',
            'shoppingListDescription',
            'shoppingListBudget',
        ];
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->dispatchBrowserEvent('shoppingList_wire-init');
        return view('livewire.sys.component.shopping-list-modal');
    }

    /**
     * Function
     */
    // Function to save to database
    public function save()
    {
        $this->validate();
        $data = new \App\Models\ShoppingList();
        if(!empty($this->shoppingListUuid)){
            $data = \App\Models\ShoppingList::where(\DB::raw('BINARY `uuid`'), $this->shoppingListUuid)
                ->where('user_id', \Auth::user()->id)
                ->firstOrFail();
        }

        $data->user_id = \Auth::user()->id;
        $data->name = $this->shoppingListName;
        $data->note = $this->shoppingListDescription;
        $data->budget = $this->shoppingListBudget ?? 0;
        $data->save();

        $this->dispatchBrowserEvent('shoppingList_wire-modalHide');
        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully '.(empty($this->shoppingListUuid) ? 'store new' : 'update').' Shopping List Data'
        ]);
        $this->reset($this->shoppingListResetField);
        $this->emit('refreshComponent');
        $this->dispatchBrowserEvent('trigger-eventShoppingList', [
            'shoppingListBudget' => $this->shoppingListBudget,
        ]);
    }
    // Handle edit request data
    public function editAction($uuid)
    {
        $data = \App\Models\ShoppingList::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->where('user_id', \Auth::user()->id)
            ->firstOrFail();
        $this->shoppingListUuid = $data->uuid;

        $this->shoppingListTitle = 'Edit';
        $this->shoppingListName = $data->name;
        $this->shoppingListDescription = $data->note;
        $this->shoppingListBudget = $data->budget;

        $this->dispatchBrowserEvent('trigger-eventShoppingList', [
            'shoppingListBudget' => $this->shoppingListBudget,
        ]);
        $this->dispatchBrowserEvent('shoppingList_wire-modalShow');
    }
}
