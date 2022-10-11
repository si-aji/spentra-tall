@section('title', 'Wallet List: Re Order')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>
            <a href="{{ route('sys.wallet.list.index') }}">Wallet: List</a>
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
    {{-- Stop trying to control. --}}
    <div class=" tw__mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-arrow-back'></i>Back</span>
        </a>
    </div>

    <div class="sa-sortable">
        <ol id="wallet-list">
            @foreach ($listWallet as $item)
                <li data-wallet_id="{{ $item->uuid }}">
                    <div class="nst-handle custom-handle">
                       <i class='bx bx-grid-vertical'></i>
                    </div>
                    <span class="wallet-name" data-name="{{ $item->name }}">{{ $item->name }}</span>

                    @if ($item->child()->exists())
                        <ol>
                            @foreach($item->child()->orderBy('order', 'asc')->get() as $child)
                                <li data-wallet_id="{{ $child->uuid }}" data-parent_id="{{ $item->uuid }}">
                                    <div class="nst-handle custom-handle">
                                       <i class='bx bx-grid-vertical'></i>
                                    </div>
                                    <span class="wallet-name" data-name="{{ $child->name }}"><p class="wallet_parent-name" data-name="{{ $item->name }}">{{ $item->name }} - </p>{{ $child->name }}</span>
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
            nestableInstance = new Nestable("#wallet-list", {
                maxDepth: 1,
                animation: 150
            });

            // Listen to event
            nestableInstance.on("stop", (event) => {
                let activeEl = event.movedNode;
                let parentEl = event.newParentItem;

                if(parentEl === null || parentEl === undefined){
                    // ActiveEl is stand alone
                    if(activeEl.hasAttribute('data-parent_id')){
                        // Check if activeEl has data-parent_id attribute
                        activeEl.removeAttribute('data-parent_id');
                    }

                    if(activeEl.querySelector('.wallet_parent-name')){
                        activeEl.querySelector('.wallet_parent-name').remove();
                    }
                } else {
                    // ActiveEl is moved to child position
                    if(!(activeEl.hasAttribute('data-parent_id'))){
                        activeEl.dataset.parent_id = parentEl.dataset.wallet_id;
                    }

                    if(!activeEl.querySelector('.wallet_parent-name')){
                        activeEl.querySelector('.wallet-name').insertAdjacentHTML('afterbegin', `
                            <p class="wallet_parent-name" data-name="${parentEl.querySelector('.wallet-name').dataset.name}">${parentEl.querySelector('.wallet-name').dataset.name} - </p>
                        `);
                    } else if(activeEl.dataset.parent_id !== parentEl.dataset.wallet_id){
                        console.log("Different parent El");
                        if(activeEl.querySelector('.wallet_parent-name')){
                            activeEl.querySelector('.wallet_parent-name').innerHTML = `${parentEl.querySelector('.wallet-name').dataset.name} - `;
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
                                'id': ec.node.dataset.wallet_id
                            });
                        });
                    }

                    if(child.length > 0){
                        // Push child arr if exists
                        serialize.push({
                            'id': e.node.dataset.wallet_id,
                            'child': child
                        });
                    } else {
                        serialize.push({
                            'id': e.node.dataset.wallet_id
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

            Livewire.emitTo('sys.wallet.lists.re-order', 'reOrder', hierarchy);
            nestableInstance.destroy();
        }

        document.addEventListener('walletorder_wire-init', (event) => {
            initNestable();
        });
    </script>
@endsection