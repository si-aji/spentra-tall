<?php

namespace App\Http\Livewire\Sys\ShoppingList;

use Livewire\Component;

class Show extends Component
{
    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    public $quitely = false;
    public $shoppingListData;
    public $shoppingListDataCollect;
    public $shoppingListItemData;
    public $shoppingListUuid;

    // Shopping List Item Field
    public $shoppingListItemUuid;
    public $shoppingListItemState;
    public $shoppingListItemName;
    public $shoppingListItemQty;
    public $shoppingListItemPrice;

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    /**
     * Livewire Mount
     */
    public function mount($uuid)
    {
        $this->menuState = 'shopping-list';
        $this->shoppingListUuid = $uuid;
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->shoppingListData = \App\Models\ShoppingList::with('shoppingListItem')
            ->where(\DB::raw('BINARY `uuid`'), $this->shoppingListUuid)
            ->where('user_id', \Auth::user()->id)
            ->firstOrFail();
        $this->shoppingListItemData = collect($this->shoppingListData->shoppingListItem);
        if(!($this->quitely)){
            $this->dispatchBrowserEvent('shoppingListItemLoadData');
        }

        // Reset Quitely
        $this->quitely = false;
        // Convert to collection
        $this->shoppingListDataCollect = collect($this->shoppingListData);

        return view('livewire.sys.shopping-list.show')
            ->extends('layouts.sneat', [
                'menuState' => $this->menuState,
                'submenuState' => $this->submenuState,
                'componentShoppingList' => true
            ]);
    }

    /**
     * Function
     */
    public function saveItem()
    {
        \Log::debug("Debug on Shopping List Item Save function on Shopping List Show", [
            'field' => [
                'uuid' => $this->shoppingListItemUuid,
                'state' => $this->shoppingListItemState,
                'name' => $this->shoppingListItemName,
                'price' => $this->shoppingListItemPrice,
                'qty' => $this->shoppingListItemQty
            ]
        ]);

        // Update to Shopping List Item
        $shoppingListItemModal = new \App\Http\Livewire\Sys\Component\ShoppingListItemModal();
        $shoppingListItemModal->shoppingListUuid = $this->shoppingListData->uuid;
        $shoppingListItemModal->shoppingListItemUuid = $this->shoppingListItemUuid;
        $shoppingListItemModal->shoppingListItemState = $this->shoppingListItemState;
        $shoppingListItemModal->shoppingListItemName = $this->shoppingListItemName;
        $shoppingListItemModal->shoppingListItemQty = $this->shoppingListItemQty;
        $shoppingListItemModal->shoppingListItemPrice = $this->shoppingListItemPrice;
        $shoppingListItemModal->save();
    }
    // Remove Data
    public function removeData($uuid)
    {
        $data = \App\Models\ShoppingListItem::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->whereHas('shoppingList', function($q){
                return $q->where('user_id', \Auth::user()->id);
            })
            ->firstOrFail();
        $data->delete();

        return $uuid;
    }
}
