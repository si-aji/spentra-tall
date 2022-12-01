<?php

namespace App\Http\Livewire\Sys\Component;

use DateTime;
use DateTimeZone;
use Livewire\Component;

class NotificationFeature extends Component
{
    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    // List / Select
    public $dataOverdue;
    public $dataToday;
    public $dataUpcoming;
    // Modal
    public $notificationModalState = 'hide';
    // Load More Conf
    public $loadPerPageOverdue = 3;
    public $loadPerPageToday = 3;
    public $loadPerPageUpcoming = 3;
    // Paginate
    protected $paginateOverdue = null;
    protected $paginateToday = null;
    protected $paginateUpcoming = null;
    // Extra Conf
    public $upcomingConf = 7; // Get X days upcoming planned payments

    /**
     * Validation
     */
    // 

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
        'store' => 'store',
        'fetchTemplate' => 'fetchTemplate',
        'localUpdate' => 'localUpdate',
        'editAction' => 'editAction'
    ];

    /**
     * Livewire Mount
     */
    public function mount()
    {
        // 
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->loadData();

        return view('livewire.sys.component.notification-feature', [
            'paginateOverdue' => $this->paginateOverdue,
            'paginateToday' => $this->paginateToday,
            'paginateUpcoming' => $this->paginateUpcoming,
        ]);
    }

    /**
     * Function
     */
    private function loadData():void
    {
        $datetime = date("Y-m-d H:i:s");
        if(\Session::has('SAUSER_TZ_OFFSET')){
            $datetime = (new DateTime('now', new DateTimeZone(\Session::get('SAUSER_TZ'))))->format('Y-m-d');
        } else {
            $datetime = date("Y-m-d", strtotime($datetime));
        }

        // Main QUery
        $query = \App\Models\PlannedPayment::with([
            'category.parent',
            'wallet.parent',
            'walletTransferTarget.parent',
            'plannedPaymentRecord' => function($q){
                return $q->orderBy('period', 'desc')
                    ->where('status', 'pending');
            }
        ])
            ->where('user_id', \Auth::user()->id);
        // Overdue Data
        $this->dataOverdue = (clone $query)->where('next_date', '<', $datetime)
            ->orderBy('next_date', 'asc');
        $this->dataOverdue = $this->dataOverdue->paginate($this->loadPerPageOverdue);
        $this->paginateOverdue = $this->dataOverdue;
        $this->dataOverdue = collect($this->dataOverdue->items());
        // Today Data
        $this->dataToday = (clone $query)->where('next_date', $datetime)
            ->orderBy('next_date', 'asc');
        $this->dataToday = $this->dataToday->paginate($this->loadPerPageToday);
        $this->paginateToday = $this->dataToday;
        $this->dataToday = collect($this->dataToday->items());
        // Upcoming Data
        $this->dataUpcoming = (clone $query)
            ->where('next_date', '>', $datetime)
            ->where('next_date', '<', date("Y-m-d", strtotime($datetime." +".$this->upcomingConf." days")))
            ->orderBy('next_date', 'asc');
        $this->dataUpcoming = $this->dataUpcoming->paginate($this->loadPerPageUpcoming);
        $this->paginateUpcoming = $this->dataUpcoming;
        $this->dataUpcoming = collect($this->dataUpcoming->items());

        $this->dispatchBrowserEvent('notificationGenerateOverdueList');
    }
    public function loadMoreOverdue($limit = 10)
    {
        $this->loadData();

        $this->notificationModalState = 'show';
        $this->loadPerPageOverdue += $limit;
    }
    public function loadMoreToday($limit = 10)
    {
        $this->loadData();

        $this->notificationModalState = 'show';
        $this->loadPerPageToday += $limit;
    }
    public function loadMoreUpcoming($limit = 10)
    {
        $this->loadData();

        $this->notificationModalState = 'show';
        $this->loadPerPageUpcoming += $limit;
    }
    // Handle Modal
    public function openModal()
    {
        $this->notificationModalState = 'show';
        $this->loadData();

        // Dispatch Browser Event
        $this->dispatchBrowserEvent('show-modalNotification');
    }
    public function closeModal()
    {
        $this->dispatchBrowserEvent('close-modalNotification');
        $this->reset([
            'loadPerPageOverdue',
            'loadPerPageToday',
            'loadPerPageUpcoming',
        ]);

        $this->notificationModalState = 'hide';
    }
    // 
    public function skipPeriod($uuid)
    {
        $this->notificationModalState = 'show';

        $plannedPayment = \App\Models\PlannedPayment::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->where('user_id', \Auth::user()->id)
            ->firstorFail();
        // Get Latest Record
        $plannedPaymentRecord = $plannedPayment->plannedPaymentRecord()->orderBy('id', 'desc')->first();

        $plannedRecordModal = new \App\Http\Livewire\Sys\Component\PlannedPaymentRecordModal();
        return $plannedRecordModal->skipRecord($plannedPaymentRecord->uuid, $plannedPayment->uuid);
    }
    public function getPaginateToday()
    {
        $this->loadData();
        return $this->paginateToday;
    }
    public function getPaginateOverdue()
    {
        $this->loadData();
        return $this->paginateOverdue;
    }
}
