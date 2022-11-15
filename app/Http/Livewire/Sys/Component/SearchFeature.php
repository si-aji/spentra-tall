<?php

namespace App\Http\Livewire\Sys\Component;

use DateTime;
use DateTimeZone;
use Livewire\Component;

class SearchFeature extends Component
{
    public $search = '';
    public $result = null;
    public $avatar = '';
    public $notificationState = false;

    public function mount()
    {        
        $this->avatar = \Auth::user()->getProfilePicture();
    }

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function render()
    {
        $this->avatar = \Auth::user()->getProfilePicture();
        if(!empty($this->search) && strlen($this->search) > 2){
            $this->result = collect(config('siaji.sys.sidebar')
                ->where('is_header', false)
                ->all())
                ->filter(function ($item) {
                    // replace stristr with your choice of matching function
                    return false !== stristr($item['name'], $this->search);
                });
        } else {
            $this->result = null;
        }

        $datetime = date("Y-m-d H:i:s");
        if(\Session::has('SAUSER_TZ')){
            // Get datetime based on Timezone
            $datetime = (new DateTime('now', new DateTimeZone(\Session::get('SAUSER_TZ'))))->format('Y-m-d H:i:s');
        }
        $this->notificationState = \App\Models\PlannedPayment::where('user_id', \Auth::user()->id)
            ->where('next_date', date("Y-m-d", strtotime($datetime)))
            ->orWhere('next_date', '<', date("Y-m-d", strtotime($datetime)))
            ->count() > 0;

        return view('livewire.sys.component.search-feature', [
            'result' => strlen($this->search),
        ]);
    }
}
