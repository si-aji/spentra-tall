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
    public $plannedPaymentCount = 0;
    public $walletData;

    // Weekly record
    public $weeklyRecordType = 'income';
    public $weeklyStart, 
        $weeklyEnd,
        $prevWeeklyStart,
        $prevWeeklyEnd,
        $weeklyAmount,
        $prevWeeklyAmount,
        $weeklyPercentage;

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
    
    private function fetchWalletData()
    {
        $this->walletData = \App\Models\Wallet::with('parent')
            ->where('user_id', \Auth::user()->id)
            ->orderBy('order_main', 'asc')
            ->get();
    }
    public function fetchWeeklyRecord()
    {
        $recordType = $this->weeklyRecordType;
        $now = new \DateTime(date("Y-m-d H:i:s"));
        if(\Session::has('SAUSER_TZ')){
            $now = $now->setTimezone(new \DateTimeZone(\Session::get('SAUSER_TZ')));
            // $recordDateTime = (new \DateTime($recordDateTime, new \DateTimeZone(\Session::get('SAUSER_TZ'))))->format('Y-m-d H:i:s');
        } else {
            $now = $now;
        }

        // Get This week
        $rawWeeklyStart = (clone $now)->modify('Last Monday');
        $this->weeklyStart = (clone $now)->modify('Last Monday')->format('Y-m-d');
        if(strtolower((clone $now)->format('D')) === 'mon'){
            $rawWeeklyStart = (clone $now);
            $this->weeklyStart = (clone $now)->format('Y-m-d');
        }
        $rawWeeklyEnd = (clone $now)->modify('Next Sunday');
        $this->weeklyEnd = (clone $rawWeeklyEnd)->format('Y-m-d');
        if((clone $now)->format('Y-m-d') < $this->weeklyEnd){
            $rawWeeklyEnd = (clone $now);
            $this->weeklyEnd = (clone $rawWeeklyEnd)->format('Y-m-d');
        }
        // Get Prev week
        $this->prevWeeklyStart = (clone $rawWeeklyStart)->modify('Last Monday')->format('Y-m-d');
        $this->prevWeeklyEnd = (clone $rawWeeklyStart)->modify('Last '.(clone $rawWeeklyEnd)->format('l'))->format('Y-m-d');

        // Get Balance
        $this->weeklyAmount = (new \App\Models\WalletGroup())->getBalance('all', [$this->weeklyStart, $this->weeklyEnd], $recordType);
        if($this->weeklyAmount < 0){
            $this->weeklyAmount *= -1;
        }
        $this->prevWeeklyAmount = (new \App\Models\WalletGroup())->getBalance('all', [$this->prevWeeklyStart, $this->prevWeeklyEnd], $recordType);
        if($this->prevWeeklyAmount < 0){
            $this->prevWeeklyAmount *= -1;
        }
        // Calculate Percentage
        $diff = $this->weeklyAmount - $this->prevWeeklyAmount;
        $divide = $this->prevWeeklyAmount;
        if($this->weeklyAmount < $this->prevWeeklyAmount){
            $diff = $this->prevWeeklyAmount - $this->weeklyAmount;
            $divide = $this->weeklyAmount;
        }

        $this->weeklyPercentage = ($diff / (max($divide, 1))) * 100;
        if($divide === 0){
            $this->weeklyPercentage = 100;
        }
    }

    public function render()
    {
        $notificationLivewire = (new \App\Http\Livewire\Sys\Component\NotificationFeature());
        $this->plannedPaymentCount = $notificationLivewire->getPaginateToday()->total();
        $this->plannedPaymentOverdueCount = $notificationLivewire->getPaginateOverdue()->total();

        // Fetch Related Data
        $this->fetchWeeklyRecord();
        $this->fetchWalletData();

        $this->dispatchBrowserEvent('dashboardWireInit');

        return view('livewire.sys.dashboard.index')->extends('layouts.sneat', [
            'menuState' => $this->menuState,
            'submenuState' => $this->submenuState,
        ]);
    }
}
