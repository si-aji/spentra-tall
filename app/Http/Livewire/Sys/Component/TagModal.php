<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class TagModal extends Component
{
    /**
     * Sidebar Configuration
     */
    public $menuState = null;
    public $submenuState = null;

    /**
     * Component Variable
     */
    // Modal
    public $tagModalState = 'hide';
    public $tagTitle = 'Add new';

    // Form Field
    public $tagUuid = null;
    public $tagName = null;
    // Reset Field
    public $tagResetField = [];

    /**
     * Validation
     */
    protected $rules = [
        'tagName' => ['required'],
    ];

    /**
     * Livewire Event Listener
     */
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
        'store' => 'store',
        'localUpdate' => 'localUpdate',
        'editAction' => 'editAction'
    ];

    /**
     * Livewire Mount
     */
    public function mount()
    {
        $this->tagResetField = [
            'tagUuid',
            'tagTitle',
            'tagName',
        ];
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->dispatchBrowserEvent('tag_wire-init');
        return view('livewire.sys.component.tag-modal');
    }

    /**
     * Function
     */
    // Function to save to database
    public function save()
    {
        $this->validate();
        $data = new \App\Models\Tag();
        if(!empty($this->tagUuid)){
            $data = \App\Models\Tag::where(\DB::raw('BINARY `uuid`'), $this->tagUuid)
                ->firstOrFail();
        }

        $data->user_id = \Auth::user()->id;
        $data->name = $this->tagName;
        $data->save();

        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully '.(empty($this->tagUuid) ? 'store new' : 'update').' Tag Data'
        ]);
        $this->reset($this->tagResetField);
        $this->emit('refreshComponent');
    }
    // Handle edit request data
    public function editAction($uuid)
    {
        $data = \App\Models\Tag::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->tagUuid = $data->uuid;

        $this->tagTitle = 'Edit';
        $this->tagName = $data->name;

        $this->dispatchBrowserEvent('tag_wire-modalShow');
    }
    // Handle Modal
    public function openModal()
    {
        $this->tagModalState = 'show';
    }
    public function closeModal()
    {
        $this->tagModalState = 'hide';
        $this->reset($this->tagResetField);
    }
    // Update Model / Variable
    public function localUpdate($key, $value): void
    {
        switch($key){
            case 'tagModalState':
                $this->tagModalState = $value;
                break;
            case 'tagName':
                $this->tagName = $value;
                break;
        }
    }
}
