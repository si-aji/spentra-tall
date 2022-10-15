<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class SearchFeature extends Component
{
    public $search = '';
    public $result = null;
    public $avatar = '';
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

        return view('livewire.sys.component.search-feature', [
            'result' => strlen($this->search),
        ]);
    }
}
