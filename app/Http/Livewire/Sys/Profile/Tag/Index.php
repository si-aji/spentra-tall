<?php

namespace App\Http\Livewire\Sys\Profile\Tag;

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
        $this->submenuState = 'tag';

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
        return view('livewire.sys.profile.tag.index')
            ->extends('layouts.sneat', [
                'menuState' => $this->menuState,
                'submenuState' => $this->submenuState,
                'componentTag' => true
            ]);
    }

    /**
     * Function
     */
    // 
}
