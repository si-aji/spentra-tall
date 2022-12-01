<?php

namespace App\Http\Livewire\Sys\Profile\Category;

use Livewire\Component;

class Index extends Component
{
    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    public $extraMenu = [];
    // List / Select
    public $listCategoryDefault = [
        [
            'name' => 'Income',
            'sub' => [
                [
                    'name' => 'Salary'
                ], [
                    'name' => 'Child Support'
                ], [
                    'name' => 'Gift'
                ], [
                    'name' => 'Interest, Dividens'
                ], [
                    'name' => 'Sale'
                ], [
                    'name' => 'Refund'
                ], 
            ]
        ], [
            'name' => 'Expense',
            'sub' => [
                [
                    'name' => 'Child Support'
                ], [
                    'name' => 'Charges, Fees'
                ], [
                    'name' => 'Tax'
                ], [
                    'name' => 'Insurance'
                ], 
            ]
        ], [
            'name' => 'Food & Drinks',
            'sub' => [
                [
                    'name' => 'Fast Food'
                ], [
                    'name' => 'Groceries'
                ], 
            ]
        ], [
            'name' => 'PC & Communication',
            'sub' => [
                [
                    'name' => 'Internet'
                ], [
                    'name' => 'Phone Credit'
                ], [
                    'name' => 'Software'
                ], 
            ]
        ], [
            'name' => 'Life & Entertainment',
            'sub' => [
                [
                    'name' => 'Fitness'
                ], [
                    'name' => 'Events'
                ], [
                    'name' => 'Education'
                ], [
                    'name' => 'Doctor'
                ], [
                    'name' => 'Health & Beauty'
                ], [
                    'name' => 'Subscription'
                ], [
                    'name' => 'Wellness, Beauty'
                ], 
            ]
        ], [
            'name' => 'Shopping',
            'sub' => [
                [
                    'name' => 'Clothes'
                ], [
                    'name' => 'Electronic'
                ], [
                    'name' => 'Gift'
                ], [
                    'name' => 'Stationary'
                ], 
            ]
        ], [
            'name' => 'Housing',
            'sub' => [
                [
                    'name' => 'Energy'
                ], [
                    'name' => 'Garden'
                ], [
                    'name' => 'Maintenance'
                ], [
                    'name' => 'Rent'
                ], [
                    'name' => 'Services'
                ], 
            ]
        ], [
            'name' => 'Investment',
            'sub' => []
        ], [
            'name' => 'Social',
            'sub' => []
        ], [
            'name' => 'Transportation',
            'sub' => [
                [
                    'name' => 'Business Trips'
                ], [
                    'name' => 'Public Transport'
                ], 
            ]
        ], [
            'name' => 'Vehicle',
            'sub' => [
                [
                    'name' => 'Fuel'
                ], [
                    'name' => 'Parking'
                ], [
                    'name' => 'Maintenance'
                ], [
                    'name' => 'Parts'
                ], [
                    'name' => 'Insurance'
                ], 
            ]
        ], 
    ];

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    // 

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->menuState = 'profile';
        $this->submenuState = 'category';

        $extraMenu = collect(config('siaji.sys.sidebar'))
            ->where('name', 'Profile')
            ->first();

        if(!empty($extraMenu) && count($extraMenu['sub']) > 0){
            foreach($extraMenu['sub'] as $menu){
                $this->extraMenu[] = $menu;
            }
        }
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        return view('livewire.sys.profile.category.index')
            ->extends('layouts.sneat', [
                'menuState' => $this->menuState,
                'submenuState' => $this->submenuState,
                'componentCategory' => true
            ]);
    }

    /**
     * Function
     */
    // Generate Default Category
    public function generateDefaultCategory()
    {
        $orderMain = 0;
        foreach($this->listCategoryDefault as $default){
            $order = 0;

            $data = new \App\Models\Category();
            $data->user_id = \Auth::user()->id;
            $data->name = $default['name'];
            $data->order = $order;
            $data->order_main = $orderMain;
            $data->save();

            // Save Child
            if(isset($default['sub']) && count($default['sub']) > 0){
                foreach($default['sub'] as $sub){
                    $order++;
                    $orderMain++;

                    $child = new \App\Models\Category();
                    $child->parent_id = $data->id;
                    $child->user_id = \Auth::user()->id;
                    $child->name = $sub['name'];
                    $child->order = $order;
                    $child->order_main = $orderMain;
                    $child->save();
                }
            }

            $orderMain++;
        }

        (new \App\Http\Livewire\Sys\Profile\Category\ReOrder())->reOrder(null);
    }
}
