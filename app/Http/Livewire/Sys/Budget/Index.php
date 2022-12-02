<?php

namespace App\Http\Livewire\Sys\Budget;

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
    public $dataBudget;

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
        $this->menuState = 'budget';
        $this->submenuState = null;
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->dataBudget = \App\Models\Budget::where('user_id', \Auth::user()->id);
        $paginate = $this->dataBudget->paginate($this->loadPerPage);
        $this->dataBudget = collect($this->dataBudget->paginate($this->loadPerPage)->items());

        $this->dispatchBrowserEvent('budgetLoadData');

        return view('livewire.sys.budget.index', [
            'paginate' => $paginate
        ])->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
            'componentBudget' => true
        ]);
    }

    /**
     * Function
     */
    // 
}
