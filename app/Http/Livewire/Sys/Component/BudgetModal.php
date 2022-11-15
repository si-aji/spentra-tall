<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class BudgetModal extends Component
{
    public $menuState = null;
    public $submenuState = null;
    public function mount()
    {
        // 
    }

    public function render()
    {
        return view('livewire.sys.component.budget-modal');
    }
}
