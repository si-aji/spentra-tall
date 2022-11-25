<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class ShoppingListItemModal extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // Modal
    public $shoppingListItemModalState = 'hide';

    // Form Field
    public $shoppingListUuid = '';
    public $shoppingListItemUuid = '';
    public $shoppingListItemState = '';
    public $shoppingListItemName = '';
    public $shoppingListItemPrice = '';
    public $shoppingListItemQty = '';

    public $shoppingListItemResetField = [];
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
    ];

    public function mount()
    {
        $this->shoppingListItemResetField = [
            'shoppingListItemModalState',
            'shoppingListUuid',
            'shoppingListItemUuid',
            'shoppingListItemName',
            'shoppingListItemPrice',
            'shoppingListItemQty'
        ];
    }

    public function render()
    {
        $this->dispatchBrowserEvent('shopping_list_item_wire-init');
        return view('livewire.sys.component.shopping-list-item-modal');
    }

    // Handle Modal
    public function openModal()
    {
        $this->shoppingListItemModalState = 'show';
    }
    public function closeModal()
    {
        $this->shoppingListItemModalState = 'hide';
    }

    // Store to Database
    public function save()
    {
        $this->validate([
            'shoppingListItemName' => ['required', 'string'],
            'shoppingListItemPrice' => ['required', 'numeric', 'min:0'],
            'shoppingListItemQty' => ['required', 'numeric', 'min:0'],
        ]);

        \Log::debug("Debug on Shopping List Item Save function", [
            'field' => [
                'uuid' => $this->shoppingListItemUuid,
                'name' => $this->shoppingListItemName,
                'price' => $this->shoppingListItemPrice,
                'qty' => $this->shoppingListItemQty
            ]
        ]);

        $data = new \App\Models\ShoppingListItem();
        $checkState = true;
        if(!empty($this->shoppingListItemUuid)){
            $data = \App\Models\ShoppingListItem::where(\DB::raw('BINARY `uuid`'), $this->shoppingListItemUuid)
                ->firstOrFail();
            $checkState = $data->state;
        }

        $data->shopping_list_id = \App\Models\ShoppingList::where(\DB::raw('BINARY `uuid`'), $this->shoppingListUuid)
            ->where('user_id', \Auth::user()->id)
            ->firstOrFail()->id;
        if(!empty($this->shoppingListItemName)){
            $data->name = $this->shoppingListItemName;
        }
        if(!empty($this->shoppingListItemPrice)){
            $data->amount = $this->shoppingListItemPrice;
        }
        if(!empty($this->shoppingListItemQty)){
            $data->qty = $this->shoppingListItemQty;
        }
        if($this->shoppingListItemState !== ''){
            $checkState = $this->shoppingListItemState;
        }
        $data->state = $checkState;
        $data->save();

        // Hide Modal
        $this->dispatchBrowserEvent('shopping_list_item_wire-modalHide');
    }
}
