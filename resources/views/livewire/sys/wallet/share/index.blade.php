@section('title', 'Wallet Share')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span class="active">Wallet Share: List</span>
    </h4>
@endsection

@section('css_plugins')
    @include('layouts.plugins.datatable.css')
@endsection

<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div id="walletShareIndex" x-data="{
    }">
        <div class=" tw__shadow tw__rounded-lg">
            <div class="sa-header tw__bg-white tw__p-4 tw__rounded-t-lg">
                <div class=" tw__flex tw__items-center tw__flex-wrap lg:tw__flex-nowrap lg:tw__justify-between">
                    @if ($paginate->total() > 0)
                        <span>Showing {{ $paginate->firstItem() }} to {{ $paginate->lastItem() }} of {{ $paginate->total() }} result{{ $paginate->total() > 1 ? 's' : '' }}</span>
                    @else
                        <span>No data to be shown</span>
                    @endif
                    <div class="">
                        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#modal-wallet_share">
                            <span class=" tw__flex tw__items-center tw__gap-1"><i class="bx bx-plus"></i>Add new</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="sa-body tw__bg-white" wire:ignore>
                <div class=" tw__px-4 tw__pb-4">
                    <div class=" tw__flex lg:tw__justify-between tw__flex-col lg:tw__flex-row tw__gap-2">
                        <div class=" tw__flex tw__items-center tw__gap-2 tw__flex-row  tw__w-full">
                            <div class=" tw__w-3/5 lg:tw__w-1/5">
                                <div class="form-group">
                                    <div wire:ignore>
                                        <select class="form-control tw__w-full" id="input_filter_wallet_share-sort">
                                            <option value="">Search for Sort Key</option>
                                            <option value="token">Token</option>
                                            <option value="created_at" selected>Created at</option>
                                            <option value="updated_at">Updated at</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class=" tw__w-2/5 lg:tw__w-1/6">
                                <div class="form-group">
                                    <div wire:ignore>
                                        <select class="form-control tw__w-full" id="input_filter_wallet_share-sort_type">
                                            <option value="">Search for Sort Type</option>
                                            <option value="asc">Asc</option>
                                            <option value="desc" selected>Desc</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" tw__w-full lg:tw__w-1/4">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search by note or token" wire:model.debounce="filterWalletShareNote">
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" tw__hidden lg:tw__grid tw__grid-flow-col tw__grid-cols-3 tw__items-center tw__gap-4 tw__px-4 tw__py-2 tw__border-t">
                    <span>Share Token / Note / Time Limit</span>
                    <span>Shared Wallet</span>
                    <span class=" tw__flex tw__justify-end">Action</span>
                </div>
                <div id="wallet_share-container"></div>
            </div>
            <div class="sa-footer tw__bg-white tw__rounded-b-lg tw__p-4">
                <div class=" tw__flex tw__items-center tw__flex-wrap lg:tw__flex-nowrap lg:tw__justify-between">
                    @if ($paginate->total() > 0)
                        <span>Showing {{ $paginate->firstItem() }} to {{ $paginate->lastItem() }} of {{ $paginate->total() }} result{{ $paginate->total() > 1 ? 's' : '' }}</span>
                    @else
                        <span>No data to be shown</span>
                    @endif
                    <div class="">
                        {{ $paginate->links('vendor.livewire.sneat') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js_inline')
    <script>
        let loadSkeleton = false;
        const loadDataSkeleton = () => {
            let container = document.getElementById('wallet_share-container');

            if(container){
                let template = `
                    <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-1 lg:tw__grid-cols-3 tw__items-center tw__gap-2 lg:tw__gap-4">
                        <div class="">
                            <span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-12 tw__h-3"></span>
                            <span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-36 tw__h-5 tw__mt-1"></span>
                            <span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-20 tw__h-3 tw__mt-2"></span>
                        </div>
                        <div class=" tw__flex tw__flex-wrap tw__gap-2 list-item">
                        </div>
                        <div class=" tw__flex tw__gap-2 lg:tw__justify-end">
                            <span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-20 tw__h-8"></span>
                            <span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-20 tw__h-8"></span>
                        </div>
                    </div>
                `;
                // Check if child element exists
                if(container.querySelectorAll('.share-list').length > 0){
                    container.querySelectorAll('.share-list').forEach((el, index) => {
                        el.innerHTML = template;

                        if(container.querySelector(`.share-list[data-index="${index}"]`)){
                            let items = [];
                            for(j = 0; j < Math.floor(Math.random() * 15) + 1; j++){
                                items.push(`<span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-12 tw__h-5"></span>`);
                            }

                            (container.querySelector(`.share-list[data-index="${index}"]`)).querySelector('.list-item').innerHTML = items.join('');
                        }
                    });
                } else {
                    // Child not yet exists, create new data instead using existing data
                    for(i = 0; i < 15; i++){
                        let el = document.createElement('div');
                        el.classList.add('share-list', 'tw__p-4', 'first:tw__border-t', 'tw__border-b', 'tw__transition-all', 'hover:tw__bg-slate-100', 'hover:tw__bg-opacity-70');
                        el.dataset.index = i;
                        el.innerHTML = template;
                        container.appendChild(el);

                        if(container.querySelector(`.share-list[data-index="${i}"]`)){
                            let items = [];
                            for(j = 0; j < Math.floor(Math.random() * 15) + 1; j++){
                                items.push(`<span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-12 tw__h-5"></span>`);
                            }

                            (container.querySelector(`.share-list[data-index="${i}"]`)).querySelector('.list-item').innerHTML = items.join('');
                        }
                    }
                }
            }
        };
        const loadData = () => {
            loadSkeleton = false;
            let container = document.getElementById('wallet_share-container');

            if(container){
                let data = @this.get('dataWalletShare');
                // console.log(data);
                if(data.length > 0){
                    data.forEach((val, index) => {
                        // console.log(val);
                        let wrapper = container.querySelector(`.share-list[data-index="${index}"]`);
                        if(!wrapper){
                            let wrapperTemp = document.createElement(`div`);
                            wrapperTemp.classList.add('share-list', 'tw__p-4', 'first:tw__border-t', 'tw__border-b', 'tw__transition-all', 'hover:tw__bg-slate-100', 'hover:tw__bg-opacity-70');
                            wrapperTemp.dataset.index = index;
                            container.appendChild(wrapperTemp);

                            wrapper = container.querySelector(`.share-list[data-index="${index}"]`);
                        }

                        wrapper.innerHTML = `
                            <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-1 lg:tw__grid-cols-3 tw__items-center tw__gap-2 lg:tw__gap-4">
                                <div class="">
                                    <span class=""><a href="{{ route('sys.wallet.share.index') }}/${val.uuid}"><span class=" tw__flex tw__items-center tw__gap-1">${val.passphrase ? `<i class='bx bxs-lock-alt'></i>` : ''}${val.token}</span></a></span>
                                    ${val.note ? `<small class="tw__block tw__italic text-muted">${val.note}</small>` : ''}
                                    <small class=" bg-${val.share_limit === 'lifetime' ? 'success' : ''} tw__px-2 tw__py-1 tw__rounded tw__text-white">${ucwords(val.share_limit)}</small>
                                </div>
                                <div class=" tw__flex tw__flex-wrap tw__gap-2 list-item">
                                </div>
                                <div class=" tw__flex tw__gap-2 lg:tw__justify-end tw__flex-col">
                                    <div class=" tw__flex tw__gap-2 lg:tw__justify-end ">
                                        <a href="{{ route('sys.wallet.share.index') }}/${val.uuid}" class="btn btn-sm btn-primary">
                                            <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-show"></i>Detail</span>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-warning" x-on:click="$wire.emitTo('sys.component.wallet-share-modal', 'editAction', '${val.uuid}')">
                                            <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-edit"></i>Edit</span>
                                        </button>
                                    </div>
                                    <div class=" tw__flex tw__flex-col lg:tw__justify-end lg:tw__text-right">
                                        <small>**Created at ${momentDateTime(val.created_at, 'DD MMM, YYYY / HH:mm', true)}</small>
                                        <small>**Last update at ${momentDateTime(val.updated_at, 'DD MMM, YYYY / HH:mm', true)}</small>
                                    </div>
                                </div>
                            </div>
                        `;

                        let items = [];
                        let selectedWallet = val.wallet_share_detail.length;
                        if(selectedWallet > 0){
                            (val.wallet_share_detail).some((lis, index) => {
                                let stopper = 1;
                                if(index > stopper){
                                    items.push(`<small class=" bg-secondary tw__px-2 tw__py-1 tw__rounded tw__text-white">and ${selectedWallet - (stopper + 1)} more...</small>`);
                                    return true;
                                }

                                let walletName = `${lis.parent ? `${lis.parent.name} - ` : ''}${lis.name}`;
                                items.push(`<small class=" bg-primary tw__px-2 tw__py-1 tw__rounded tw__text-white">${walletName}</small>`);
                            });
                        } else {
                            items.push(`
                                <small class=" bg-secondary tw__px-2 tw__py-1 tw__rounded tw__text-white">No wallet selected</small>
                            `);
                        }
                        
                        wrapper.querySelector('.list-item').innerHTML = items.join('');
                    });

                    // Remove extra element
                    let extra = [].filter.call(container.querySelectorAll('.share-list'), (el) => {
                        return el.dataset.index >= data.length;
                    });
                    extra.forEach((el) => {
                        el.remove();
                    });
                } else {
                    // No data found
                }
            }
        };
        Livewire.hook('message.sent', (message, component) => {
            if(component.el.id && component.el.id === 'walletShareIndex'){
                loadSkeleton = true;
                setTimeout(() => {
                    if(loadSkeleton){
                        loadDataSkeleton();
                    }
                }, 250);
            }
        });

        loadDataSkeleton();
        window.addEventListener('wallet_share_index_wire-init', () => {
            loadData();
        });

        let filterWalletShareSortChoice;
        let filterWalletShareSortTypeChoice;
        document.addEventListener('DOMContentLoaded', () => {
            loadData();

            document.getElementById('modal-wallet_share').addEventListener('hidden.bs.offcanvas', (e) => {
                @this.emit('refreshComponent');
            });

            // Choices
            let filterWalletShareSortEl = document.getElementById('input_filter_wallet_share-sort');
            filterWalletShareSortChoice = new Choices(filterWalletShareSortEl, {
                allowHTML: true,
                shouldSort: false,
                callbackOnCreateTemplates: function(strToEl) {
                    var classNames = this.config.classNames;
                    var itemSelectText = this.config.itemSelectText;
                    return {
                        item: function({ classNames }, data) {
                            return strToEl(`
                                <div 
                                    class="${classNames.item} ${data.highlighted ? classNames.highlightedState : classNames.itemSelectable}"
                                    data-item
                                    data-value="${data.value}"
                                    ${data.active ? 'aria-selected="true"' : ''}
                                    ${data.disabled ? 'aria-disabled="true"' : ''}
                                >
                                    <span class="tw__flex tw__items-center tw__gap-1">
                                        <i class='bx bx-sort'></i>
                                        <span>${data.label}</span>
                                    </span>
                                </div>
                            `);
                        },
                    };
                },
            });
            filterWalletShareSortChoice.passedElement.element.addEventListener('change', (e) => {
                @this.set('sortKeyWalletShare', e.target.value);
                @this.emit('refreshComponent');
            });
            let filterWalletShareSortTypeEl = document.getElementById('input_filter_wallet_share-sort_type');
            filterWalletShareSortTypeChoice = new Choices(filterWalletShareSortTypeEl, {
                allowHTML: true,
                shouldSort: false,
                callbackOnCreateTemplates: function(strToEl) {
                    var classNames = this.config.classNames;
                    var itemSelectText = this.config.itemSelectText;
                    return {
                        item: function({ classNames }, data) {
                            return strToEl(`
                                <div 
                                    class="${classNames.item} ${data.highlighted ? classNames.highlightedState : classNames.itemSelectable}"
                                    data-item
                                    data-value="${data.value}"
                                    ${data.active ? 'aria-selected="true"' : ''}
                                    ${data.disabled ? 'aria-disabled="true"' : ''}
                                >
                                    <span class="tw__flex tw__items-center tw__gap-1">
                                        <i class='bx bx-sort-down' ></i>
                                        <span>${data.label}</span>
                                    </span>
                                </div>
                            `);
                        },
                    };
                },
            });
            filterWalletShareSortTypeChoice.passedElement.element.addEventListener('change', (e) => {
                @this.set('sortTypeWalletShare', e.target.value);
                @this.emit('refreshComponent');
            });
        });
    </script>
@endsection