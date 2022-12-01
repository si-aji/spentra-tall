<?php

namespace App\Http\Livewire\Sys\ShoppingList;

use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    // Load More Conf
    public $loadPerPage = 10;
    // List Data
    public $dataShoppingList;

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'removeData' => 'removeData'
    ];

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->menuState = 'shopping-list';
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->dataShoppingList = \App\Models\ShoppingList::with('shoppingListItem')
            ->where('user_id', \Auth::user()->id);
        $this->dataShoppingList = $this->dataShoppingList->paginate($this->loadPerPage);
        $paginate = $this->dataShoppingList;
        $this->dataShoppingList = collect($this->dataShoppingList->items());

        $this->dispatchBrowserEvent('shoppingListLoadData');

        return view('livewire.sys.shopping-list.index', [
                'paginate' => $paginate
            ])
            ->extends('layouts.sneat', [
                'menuState' => $this->menuState,
                'submenuState' => $this->submenuState,
                'componentShoppingList' => true
            ]);
    }

    /**
     * Function
     */
    // Remove Data
    public function removeData($uuid)
    {
        $data = \App\Models\ShoppingList::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->where('user_id', \Auth::user()->id)
            ->firstOrFail();
        if($data->shoppingListItem()->exists()){
            $data->shoppingListItem()->delete();
        }
        $data->delete();

        return $uuid;
    }
}
