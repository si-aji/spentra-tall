<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class CategoryModal extends Component
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
    public $listCategory;
    // Modal
    public $categoryModalState = 'hide';
    public $categoryTitle = 'Add new';
    // Form Field
    public $categoryUuid = null; // State current active data
    public $categoryParent = '';
    public $categoryName = null;
    public $categoryColor = null;
    // Reset Field
    public $categoryResetField = [];

    /**
     * Validation
     */
    protected $rules = [
        'categoryParent' => ['nullable'],
        'categoryName' => ['required'],
    ];

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
        $this->categoryResetField = [
            'categoryUuid',
            'categoryTitle',
            'categoryParent',
            'categoryName',
            'categoryColor'
        ];
    }

    /**
     * Livewire Component Render
     */
    public function render()
    {
        $this->fetchMainCategory();

        $this->dispatchBrowserEvent('category_wire-init');
        return view('livewire.sys.component.category-modal');
    }

    /**
     * Function
     */
    // Fetch List Data
    public function fetchMainCategory()
    {
        // Category
        $this->listCategory = \App\Models\Category::with('child', 'parent')
            ->where('user_id', \Auth::user()->id)
            ->whereNull('parent_id')
            ->orderBy('order_main', 'asc')
            ->get();
    }
    // Function to save to database
    public function save()
    {
        $parent = null;
        if(!empty($this->categoryParent)){
            $parent = \App\Models\Category::where(\DB::raw('BINARY `uuid`'), $this->categoryParent)
                ->firstOrFail();
        }

        $this->validate();
        $data = new \App\Models\Category();
        if(!empty($this->categoryUuid)){
            // Update Data
            $data = \App\Models\Category::where(\DB::raw('BINARY `uuid`'), $this->categoryUuid)
                ->firstOrFail();
            $parent = $data->parent()->exists() ? $data->parent : null;
        } else {
            // Add new Data

            // Get Last Order
            $order = 0;
            $lastOrder = \App\Models\Category::query()
                ->where('user_id', \Auth::user()->id);
            if (! empty($parent)) {
                $lastOrder->where('parent_id', $parent->id);
            } else {
                $lastOrder->whereNull('parent_id');
            }
            $lastOrder = $lastOrder->orderBy('order', 'desc')->first();
            if (! empty($lastOrder)) {
                $order = $lastOrder->order;
            }

            $data->order = $order;
        }

        $data->user_id = \Auth::user()->id;
        $data->parent_id = !empty($parent) ? $parent->id : null;
        $data->name = $this->categoryName;
        $data->color = $this->categoryColor;
        $data->save();

        $this->fetchMainCategory();
        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully '.(empty($this->categoryUuid) ? 'store new' : 'update').' Category Data'
        ]);
        $this->reset($this->categoryResetField);
        $this->emit('refreshComponent');

        // Create Category Re-Order Request
        (new \App\Http\Livewire\Sys\Profile\Category\ReOrder())->reOrder(null);
    }
    // Handle edit request data
    public function editAction($uuid)
    {
        $data = \App\Models\Category::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->categoryUuid = $data->uuid;

        $this->categoryTitle = 'Edit';
        $this->categoryParent = $data->parent()->exists() ? $data->parent->uuid : '';
        $this->categoryName = $data->name;
        $this->categoryColor = $data->color;

        $this->dispatchBrowserEvent('category_wire-modalShow');
    }
    // Handle Modal
    public function openModal()
    {
        $this->categoryModalState = 'show';
    }
    public function closeModal()
    {
        $this->categoryModalState = 'hide';
        $this->reset($this->categoryResetField);
    }
    // Update Model / Variable
    public function localUpdate($key, $value): void
    {
        switch($key){
            case 'categoryModalState':
                $this->categoryModalState = $value;
                break;
            case 'categoryParent':
                $this->categoryParent = $value;
                break;
            case 'categoryName':
                $this->categoryName = $value;
                break;
        }
    }
}
