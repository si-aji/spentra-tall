<?php

namespace App\Http\Livewire\Sys\ShoppingList;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // Load More Conf
    public $loadPerPage = 10;

    // List Data
    public $dataShoppingList;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'removeData' => 'removeData'
    ];
    public function mount()
    {
        $this->menuState = 'shopping-list';
    }

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
