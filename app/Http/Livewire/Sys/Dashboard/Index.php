<?php

namespace App\Http\Livewire\Sys\Dashboard;

use Livewire\Component;

class Index extends Component
{
    public $menuState = null;
    public $submenuState = null;
    public $menuSearch = null;

    public $cashFlowLabel = [];
    public $cashFlowIncome = [];
    public $cashFlowExpense = [];
    public $cashFlowIncomeSum = 0;
    public $cashFlowExpenseSum = 0;

    public function mount()
    {
        $this->menuState = 'dashboard';
        $this->submenuState = null;

        for($start = 1; $start <= date("m"); $start++){
            $this->cashFlowLabel[] = date('M', strtotime("1970-".(str_pad($start,  2, "0", STR_PAD_LEFT))."-01"));

            $income = rand(1, 15) * 1000;
            $this->cashFlowIncome[] = $income;
            $this->cashFlowIncomeSum += $income;

            $expense = (rand(1, 10) * 1000);
            $this->cashFlowExpense[] = $expense * -1;
            $this->cashFlowExpenseSum += $expense;
        }
    }

    protected $listeners = ['searchKeyword'];
    public function searchKeyword($value)
    {
        $this->menuSearch = $value;
    }
    
    public function render()
    {
        return view('livewire.sys.dashboard.index')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
        ]);
    }
}
