<?php

namespace App\Http\Livewire\Sys\Profile\Category;

use Livewire\Component;

class ReOrder extends Component
{
    public $menuState = null;
    public $submenuState = null;
    public $extraMenu = [];

    public $listCategory;

    protected $listeners = [
        'refreshComponent' => '$refresh',
        'reOrder' => 'reOrder',
    ];

    public function fetchMainCategory()
    {
        // Category
        $this->listCategory = \App\Models\Category::with('child', 'parent')
            ->where('user_id', \Auth::user()->id)
            ->whereNull('parent_id')
            ->orderBy('order_main', 'asc')
            ->get();
    }
    public function mount()
    {
        $this->menuState = 'profile';
        $this->submenuState = 'category';

        $extraMenu = config('siaji.sys.sidebar')
            ->where('name', 'Profile')
            ->first();

        if(!empty($extraMenu) && count($extraMenu['sub']) > 0){
            foreach($extraMenu['sub'] as $menu){
                $this->extraMenu[] = $menu;
            }
        }
    }

    public function render()
    {
        $this->fetchMainCategory();
        $this->dispatchBrowserEvent('categoryorder_wire-init');

        return view('livewire.sys.profile.category.re-order')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState
        ]);
    }

    /**
     * Handle Re-Order
     * 
     */
    public function reOrder($order = null)
    {
        $numorder = 0;
        $numorderMain = 0;
        foreach ($order as $hierarchy) {
            // Update Main Order
            $category = \App\Models\Category::where(\DB::raw('BINARY `uuid`'), $hierarchy['id'])->firstOrFail();
            $category->order = $numorder;
            $category->order_main = $numorderMain;
            if (! empty($category->parent_id)) {
                $category->parent_id = null;
            }
            $category->save();

            // Request has Child Category
            if (isset($hierarchy['child']) && is_array($hierarchy['child']) && count($hierarchy['child']) > 0) {
                $childOrder = 0;
                foreach ($hierarchy['child'] as $child) {
                    $numorderMain++;

                    // Update Child Order
                    $subcategory = \App\Models\Category::where(\DB::raw('BINARY `uuid`'), $child['id'])->firstOrFail();
                    $subcategory->order = $childOrder;
                    $subcategory->order_main = $numorderMain;
                    $subcategory->parent_id = $category->id;
                    $subcategory->save();

                    $childOrder++;
                }
            }

            $numorderMain++;
            $numorder++;
        }
    }
}
