<?php

namespace App\Http\Livewire\Sys\Profile\Tag;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;
    public $extraMenu = [];

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
     * Render component livewire view
     * 
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
}
