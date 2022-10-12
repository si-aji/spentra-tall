@section('title', 'Category: Re Order')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>Profile</span>
        <span>
            <a href="{{ route('sys.category.index') }}">Category</a>
        </span>
        <span class="active">Re Order</span>
    </h4>
@endsection

@section('css_plugins')
    <link href="{{ mix('assets/plugins/nestable/nestable.css') }}" rel="stylesheet">
@endsection

@section('css_inline')
    <style>
        .nst-item .nst-content {
            display: block !important;
        }
    </style>
@endsection

<div wire:init="">
    {{-- Success is as dangerous as failure. --}}
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills flex-column flex-md-row">
                @foreach ($extraMenu as $menu)
                    <li class="nav-item">
                        <a class="nav-link {{ $submenuState === $menu['state'] ? 'active' : '' }}" href="{{ isset($menu['route']) && !empty($menu['route']) ? route($menu['route']) : 'javascript:void(0);' }}"><i class="{{ $menu['icon'] }} me-1"></i> {{ $menu['name'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class=" tw__mb-4 tw__mt-4">
        <a href="{{ route('sys.category.index') }}" class="btn btn-secondary">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-arrow-back'></i>Back</span>
        </a>
    </div>

    <div class="sa-sortable">
        <ol id="category-list">
            @foreach ($listCategory as $item)
                <li data-category_id="{{ $item->uuid }}">
                    <div class="nst-handle custom-handle">
                       <i class='bx bx-grid-vertical'></i>
                    </div>
                    <span class="category-name" data-name="{{ $item->name }}">{{ $item->name }}</span>

                    @if ($item->child()->exists())
                        <ol>
                            @foreach($item->child()->orderBy('order', 'asc')->get() as $child)
                                <li data-category_id="{{ $child->uuid }}" data-parent_id="{{ $item->uuid }}">
                                    <div class="nst-handle custom-handle">
                                       <i class='bx bx-grid-vertical'></i>
                                    </div>
                                    <span class="category-name" data-name="{{ $child->name }}"><p class="category_parent-name" data-name="{{ $item->name }}">{{ $item->name }} - </p>{{ $child->name }}</span>
                                </li>
                            @endforeach
                        </ol>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</div>

@section('js_plugins')
    <script src="{{ mix('assets/plugins/nestable/nestable.js') }}"></script>
@endsection

@section('js_inline')
    <script>
        var nestableInstance = null;
        const initNestable = () => {
            nestableInstance = new Nestable("#category-list", {
                maxDepth: 1,
                animation: 150
            });

            // Listen to event
            nestableInstance.on("stop", (event) => {
                let activeEl = event.movedNode;
                let parentEl = event.newParentItem;
                let exitFunct = false;
                // Check if moved node has child
                activeEl.childNodes.forEach((el) => {
                    if(el.classList.contains('nst-list') && event.newParent && parentEl !== null){                    
                        exitFunct = true;
                    }
                }); 
                if(exitFunct){
                    // Sent alwert
                    let alert = new CustomEvent('wire-action', {
                        detail: {
                            status: 'warning',
                            action: 'Failed',
                            message: `Parent data cannot be moved inside another parent data`
                        }
                    });
                    this.dispatchEvent(alert);    
                    
                    nestableInstance.destroy();
                    Livewire.emitTo('sys.profile.category.re-order', 'refreshComponent');
                    return;
                }

                if(parentEl === null || parentEl === undefined){
                    // ActiveEl is stand alone
                    if(event.newParent && event.originalParent !== event.newParent){
                        if(activeEl.hasAttribute('data-parent_id')){
                            // Check if activeEl has data-parent_id attribute
                            activeEl.removeAttribute('data-parent_id');
                        }

                        if(activeEl.querySelector('.category_parent-name')){
                            activeEl.querySelector('.category_parent-name').remove();
                        }
                    }
                } else {
                    // ActiveEl is moved to child position
                    if(!(activeEl.hasAttribute('data-parent_id'))){
                        activeEl.dataset.parent_id = parentEl.dataset.category_id;
                    }

                    if(!activeEl.querySelector('.category_parent-name')){
                        activeEl.querySelector('.category-name').insertAdjacentHTML('afterbegin', `
                            <p class="category_parent-name" data-name="${parentEl.querySelector('.category-name').dataset.name}">${parentEl.querySelector('.category-name').dataset.name} - </p>
                        `);
                    } else if(activeEl.dataset.parent_id !== parentEl.dataset.category_id){
                        console.log("Different parent El");
                        if(activeEl.querySelector('.category_parent-name')){
                            activeEl.querySelector('.category_parent-name').innerHTML = `${parentEl.querySelector('.category-name').dataset.name} - `;
                        }
                    }
                }

                let serialize = [];
                (event.hierarchy).forEach((e) => {
                    let child = [];
                    // Check if active el has child
                    if(e.children !== undefined){
                        (e.children).forEach((ec) => {
                            child.push({
                                'id': ec.node.dataset.category_id
                            });
                        });
                    }

                    if(child.length > 0){
                        // Push child arr if exists
                        serialize.push({
                            'id': e.node.dataset.category_id,
                            'child': child
                        });
                    } else {
                        serialize.push({
                            'id': e.node.dataset.category_id
                        });
                    }
                    
                });
                updateHierarchy(serialize);
            });
        }
        const updateHierarchy = (hierarchy) => {
            let orderId = hierarchy.reduce(function (r, a) {
                r[a.id] = r[a.id] || [];
                r[a.id].push(a.child);
                return r;
            }, Object.create(null));

            Livewire.emitTo('sys.profile.category.re-order', 'reOrder', hierarchy);
            nestableInstance.destroy();
        }

        document.addEventListener('categoryorder_wire-init', (event) => {
            console.log("Category Init");

            nestableInstance = null;
            initNestable();
        });
    </script>
@endsection