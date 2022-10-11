<?php

namespace App\Http\Livewire\Sys\Component;

use Livewire\Component;

class CategoryModal extends Component
{
    public $menuState = null;
    public $submenuState = null;

    // List / Select
    public $listCategory;

    // Modal
    public $categoryModalState = 'hide';
    public $categoryTitle = 'Add new';

    // Form Field
    public $categoryUuid = null; // State current active data
    public $categoryParent = '';
    public $categoryName = null;

    public $categoryResetField = [];
    protected $listeners = [
        'refreshComponent' => '$refresh',
        'openModal' => 'openModal',
        'closeModal' => 'closeModal',
        'store' => 'store',
        'fetchTemplate' => 'fetchTemplate',
        'localUpdate' => 'localUpdate',
        'editAction' => 'editAction'
    ];

    protected $rules = [
        'categoryParent' => ['nullable'],
        'categoryName' => ['required'],
    ];

    public function fetchMainCategory()
    {
        // Category
        $this->listCategory = \App\Models\Category::with('child', 'parent')
            ->where('user_id', \Auth::user()->id)
            ->whereNull('parent_id')
            ->orderBy('order_main', 'asc')
            ->get();
    }
    public function mount()
    {
        $this->categoryResetField = [
            'categoryUuid',
            'categoryTitle',
            'categoryParent',
            'categoryName',
        ];
    }

    public function render()
    {
        $this->fetchMainCategory();

        $this->dispatchBrowserEvent('category_wire-init');
        return view('livewire.sys.component.category-modal');
    }

    public function store()
    {
        $parent = null;
        if(!empty($this->categoryParent)){
            $parent = \App\Models\Category::where(\DB::raw('BINARY `uuid`'), $this->categoryParent)
                ->firstOrFail();
        }

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

        $this->validate();
        $data = new \App\Models\Category();
        if(!empty($this->categoryUuid)){
            $data = \App\Models\Category::where(\DB::raw('BINARY `uuid`'), $this->categoryUuid)
                ->firstOrFail();
            $parent = $data->parent()->exists() ? $data->parent : null;
        }

        $data->user_id = \Auth::user()->id;
        $data->parent_id = !empty($parent) ? $parent->id : null;
        $data->name = $this->categoryName;
        $data->order = $order;
        $data->save();

        $this->reset($this->categoryResetField);
        $this->fetchMainCategory();
        $this->dispatchBrowserEvent('wire-action', [
            'status' => 'success',
            'action' => 'Success',
            'message' => 'Successfully '.(empty($this->categoryUuid) ? 'store new' : 'update').' Category Data'
        ]);
        $this->emit('refreshComponent');

        // Create Category Re-Order Request
        $allParentCategory = \App\Models\Category::whereNull('parent_id')
            ->orderBy('order', 'asc')
            ->get();
        $formatedRequest = [];
        if (count($allParentCategory) > 0) {
            foreach ($allParentCategory as $category) {
                $arr = [
                    'id' => $category->uuid,
                ];

                if ($category->child()->exists()) {
                    $childArr = [];
                    foreach ($category->child()->orderBy('order', 'asc')->get() as $child) {
                        $childArr[] = [
                            'id' => $child->uuid,
                        ];
                    }

                    $arr = [
                        'id' => $category->uuid,
                        'child' => $childArr,
                    ];
                }

                $formatedRequest[] = $arr;
            }

            (new \App\Http\Livewire\Sys\Profile\Category\ReOrder())->reOrder($formatedRequest);
        }
    }

    /**
     * Handle edit request data
     */
    public function editAction($uuid)
    {
        $data = \App\Models\Category::where(\DB::raw('BINARY `uuid`'), $uuid)
            ->firstOrFail();
        $this->categoryUuid = $data->uuid;

        $this->categoryTitle = 'Edit';
        $this->categoryParent = $data->parent()->exists() ? $data->parent->uuid : '';
        $this->categoryName = $data->name;

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
        // \Log::debug("Debug on Local Update function", [
        //     'key' => $key,
        //     'value' => $value
        // ]);
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
