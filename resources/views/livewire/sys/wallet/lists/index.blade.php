@section('title', 'Wallet List')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span class="active">Wallet: List</span>
    </h4>
@endsection

@section('css_plugins')
    @include('layouts.plugins.datatable.css')
@endsection

<div>
    {{-- Be like water. --}}
    {{-- <div class="">
        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#modal-wallet">
            <span class=" tw__flex tw__items-center tw__gap-2"><i class="bx bx-plus"></i>Add new</span>
        </a>
        <a href="{{ route('sys.wallet.list.re-order') }}" class="btn btn-secondary">
            <span class=" tw__flex tw__items-center tw__gap-2"><i class='bx bx-sort-a-z'></i>Re-order</span>
        </a>
    </div>
    <div class="card tw__mt-4" wire:ignore>
        <div class="card-body datatable">
            <table class="table table-hover table-striped table-bordered" id="table-wallet">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Balance</th>
                    <th>Action</th>
                </thead>
            </table>
        </div>
    </div> --}}

    <div class="card">
        <div class="card-body tw__p-0">
            <div class="sa-header tw__bg-white tw__rounded-t-lg tw__p-4">
                <div class=" tw__flex tw__items-center tw__flex-wrap lg:tw__flex-nowrap lg:tw__justify-between">
                    @if ($paginate->total() > 0)
                        <span>Showing {{ $paginate->firstItem() }} to {{ $paginate->lastItem() }} of {{ $paginate->total() }} result{{ $paginate->total() > 1 ? 's' : '' }}</span>
                    @else
                        <span>No data to be shown</span>
                    @endif
                    <div class=" tw__flex tw__flex-col lg:tw__flex-row tw__items-center tw__gap-1">
                        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#modal-wallet">
                            <span class=" tw__flex tw__items-center tw__gap-2"><i class="bx bx-plus"></i>Add new</span>
                        </a>
                        <a href="{{ route('sys.wallet.list.re-order') }}" class="btn btn-secondary">
                            <span class=" tw__flex tw__items-center tw__gap-2"><i class='bx bx-sort-a-z'></i>Re-order</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="">
                <div class=" tw__hidden lg:tw__grid tw__grid-flow-col tw__grid-cols-3 tw__items-center tw__gap-4 tw__px-4 tw__py-2 tw__border-t">
                    <span>Name / Type</span>
                    <span>Balance / Last Transaction</span>
                    <span class=" tw__flex tw__justify-end">Action</span>
                </div>
                <div id="walletList-container" wire:ignore></div>
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

@section('js_plugins')
    @include('layouts.plugins.jquery.js')
    @include('layouts.plugins.datatable.js')
@endsection

@section('js_inline')
    {{-- <script>
        let table = new DataTable('#table-wallet', {
            order: [0, 'asc'],
            pagingType: 'numbers',
            lengthMenu: [5, 10, 25],
            stateSave: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('api.sys.v0.wallet.list') }}",
                type: "GET",
                data: function(d){
                    d.is_datatable = true;
                }
            },
            columns: [
                { "data": "order_main" },
                { "data": "name" },
                { "data": "balance" },
                { "data": null },
            ],
            columnDefs: [
                {
                    targets: 0,
                    render: function (row, type, data, meta) {
                        return parseInt(row) + 1;
                    }
                }, {
                    targets: 1,
                    render: function (row, type, data, meta) {
                        // console.log(data);
                        let walletName = `${data.parent_id ? `${data.parent.name} - ` : ''}${data.name}`;
                        return walletName;
                    }
                }, {
                    targets: 2,
                    sortable: false,
                    render: function (row, type, data, meta) {
                        return formatRupiah(row);
                    }
                }, {
                    targets: 3,
                    searchable: false,
                    sortable: false,
                    render: function (row, type, data, meta) {
                        return `
                            <div class="">
                                <button type="button" class="btn btn-sm btn-warning" x-on:click="$wire.emitTo('sys.component.wallet-modal', 'editAction', '${data.uuid}')">
                                    <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-edit"></i>Edit</span>    
                                </button>
                                <a href="{{ route('sys.wallet.list.index') }}/${data.uuid}" class="btn btn-sm btn-primary">
                                    <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-edit"></i>Detail</span>    
                                </a>
                                <button type="button" class="btn btn-sm btn-secondary" x-on:click="$wire.emitTo('sys.component.wallet-balance-modal', 'editAction', '${data.uuid}')">
                                    <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-slider"></i>Adjustment</span>
                                </button>
                            </div>
                        `;
                    }
                }, 
            ],
            responsive: true
        });

        if(document.getElementById('modal-wallet')){
            document.getElementById('modal-wallet').addEventListener('hide.bs.offcanvas', (e) => {
                console.log("Refresh datatable");
                table.ajax.reload(null, false);
            });
        }
        if(document.getElementById('modal-wallet_balance')){
            document.getElementById('modal-wallet_balance').addEventListener('hide.bs.modal', (e) => {
                console.log("Refresh datatable");
                table.ajax.reload(null, false);
            });
        }
    </script> --}}

    <script>
        let loadSkeleton = false;
        const loadDataSkeleton = () => {
            let container = document.getElementById('walletList-container');

            if(container){
                let template = `
                    <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-1 lg:tw__grid-cols-3 tw__items-center tw__gap-2 lg:tw__gap-4 tw__animate-pulse">
                        <div class=" ">
                            <span class=" tw__bg-gray-300 tw__rounded tw__w-20 tw__h-5 tw__flex"></span>
                            <span class=" tw__flex tw__items-center tw__gap-1 tw__mt-1">
                                <span class=" tw__bg-gray-300 tw__rounded tw__w-24 tw__h-3 tw__flex"></span>
                            </span>
                        </div>
                        <div class=" tw__flex tw__items-start tw__gap-1 tw__flex-col">
                            <span class=" tw__bg-gray-300 tw__rounded tw__w-32 tw__h-5 tw__flex"></span>
                            <span class=" tw__bg-gray-300 tw__rounded tw__w-32 tw__h-3 tw__flex"></span>
                        </div>
                        <div class=" tw__flex tw__gap-2 lg:tw__justify-end">
                            <span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-20 tw__h-8"></span>
                            <span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-20 tw__h-8"></span>
                        </div>
                    </div>
                `;
                // Check if child element exists
                if(container.querySelectorAll('.list-wrapper').length > 0){
                    container.querySelectorAll('.list-wrapper').forEach((el, index) => {
                        el.innerHTML = template;
                    });
                } else {
                    // Child not yet exists, create new data instead using existing data
                    for(i = 0; i < 5; i++){
                        let el = document.createElement('div');
                        el.classList.add('list-wrapper', 'tw__p-4', 'first:tw__border-t', 'tw__border-b', 'tw__transition-all', 'hover:tw__bg-slate-100', 'hover:tw__bg-opacity-70');
                        el.dataset.index = i;
                        el.innerHTML = template;
                        container.appendChild(el);
                    }
                }
            }
        };

        loadDataSkeleton();
        document.addEventListener('DOMContentLoaded', (e) => {
            window.dispatchEvent(new Event('walletListLoadData'));

            document.getElementById('modal-wallet').addEventListener('hidden.bs.offcanvas', (e) => {
                loadDataSkeleton();
                Livewire.emit('refreshComponent');
            });
        });

        window.addEventListener('walletListLoadData', (e) => {
            if(document.getElementById('walletList-container')){
                // document.getElementById('shoppingList-container').innerHTML = ``;
                generateList();
            }
        });

        // Generate Shopping List
        const generateList = () => {
            // Get data from Component
            let data = @this.get('dataWallet');
            console.log(data);
            let paneEl = document.getElementById('walletList-container');
            let shoppingListContent = null;

            if(data.length > 0){
                let existingItem = paneEl.querySelectorAll('.list-wrapper');
                if(existingItem.length > 0){
                    data.forEach((val, index) => {
                        let wrapper = paneEl.querySelector(`.list-wrapper[data-index="${index}"]`);
                        if(!wrapper){
                            let wrapperTemp = document.createElement(`div`);
                            wrapperTemp.classList.add('list-wrapper', 'tw__p-4', 'first:tw__border-t', 'tw__border-b', 'tw__transition-all', 'hover:tw__bg-slate-100', 'hover:tw__bg-opacity-70');
                            wrapperTemp.dataset.index = index;
                            paneEl.appendChild(wrapperTemp);

                            wrapper = paneEl.querySelector(`.list-wrapper[data-index="${index}"]`);
                        }

                        // Generate Action button
                        let action = [];
                        action.push(`
                            <button type="button" class="btn btn-sm btn-warning" data-uuid="${val.uuid}" x-on:click="$wire.emitTo('sys.component.wallet-modal', 'editAction', '${val.uuid}')">
                                <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-edit"></i>Edit</span>
                            </button>
                        `);
                        action.push(`
                            <a href="{{ route('sys.wallet.list.index') }}/${val.uuid}" class="btn btn-sm btn-primary">
                                <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-show"></i>Detail</span>
                            </a>
                        `);
                        // Archive Action
                        action.push(`
                            <button type="button" class="btn btn-sm btn-danger" data-uuid="${val.uuid}" x-on:click="archiveWallet('${val.uuid}')">
                                <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-archive'></i>Archive</span>
                            </button>
                        `);
                        // Handle Action wrapper
                        let actionBtn = '';
                        if(action.length > 0){
                            actionBtn = `
                                <div class=" tw__flex tw__gap-2 lg:tw__justify-end tw__flex-wrap">
                                    ${action.join('')}
                                </div>
                            `;
                        }

                        // console.log(val);
                        let extraInformation = [];
                        if(Object.keys(val.last_transaction).length !== 0){
                            console.log(val.last_transaction);
                            extraInformation.push(`<a href="{{ route('sys.record.index') }}/${val.last_transaction.uuid}"><small class="tw__flex tw__items-start lg:tw__items-center tw__gap-1 tw__leading-[1.25]"><i class="bx bx-book-content"></i>${momentDateTime(val.last_transaction.datetime, 'Do, MMM YYYY / HH:mm', true)}</small></a>`);
                        }
                        // extraInformation.push(`<small class=" tw__flex tw__items-start lg:tw__items-center tw__gap-1 tw__leading-[1.25]"><i class='bx bx-time'></i>Created at ${momentDateTime(val.created_at, 'DD MMM, YYYY / HH:mm', true)}</small>`);
                        // extraInformation.push(`<small class=" tw__flex tw__items-start lg:tw__items-center tw__gap-1 tw__leading-[1.25]"><i class='bx bx-timer'></i>Last Update at ${momentDateTime(val.updated_at, 'DD MMM, YYYY / HH:mm', true)}</small>`);
                        // <div class=" tw__bg-gray-50 tw__rounded-lg tw__w-full content-list tw__p-4 hover:tw__bg-gray-100 tw__transition tw__transition-all tw__self-center">
                        //         <div class=" tw__flex tw__gap-4 tw__items-start">
                        //             <div class=" tw__flex tw__flex-col tw__gap-2">
                        //                 <strong class=" lg:tw__text-xl">${val.name}</strong>
                        //                 <small class=" tw__hidden lg:tw__flex tw__items-center tw__gap-1"><i class="bx bx-align-left"></i>${val.note ?? 'No Description'}</small>
                        //                 <span class=" tw__flex tw__items-center tw__gap-1 tw__flex-wrap">${extraInformation.join('')}</span>
                        //             </div>
                        //             <div class=" tw__flex tw__gap-4 tw__ml-auto">
                        //                 ${actionBtn}
                        //             </div>
                        //         </div>
                        //     </div>
                        let walletName = '';
                        if(val.parent){
                            walletName = `${val.parent.name} - `;
                        }
                        walletName += `${val.name}`;

                        wrapper.innerHTML = `
                            <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-1 lg:tw__grid-cols-3 tw__items-center tw__gap-2 lg:tw__gap-4">
                                <div class="">
                                    <strong class="">${walletName}</strong>
                                    <small class=" tw__hidden lg:tw__flex tw__items-center tw__gap-1"><i class="bx bx-align-left"></i>${val.note ? val.note : 'No Description'}</small>
                                </div>
                                <div class="" x-data="{toggle: false}">
                                    <span class="tw__block" data-orig="${formatRupiah(val.balance)}" data-short="${formatRupiah(val.balance, 'Rp', true)}" x-on:click="toggle = !toggle;$el.innerHTML = (toggle ? $el.dataset.orig : $el.dataset.short)">${formatRupiah(val.balance, 'Rp', true)}</span>
                                    ${extraInformation.join('')}
                                </div>
                                <div class=" tw__flex tw__gap-2 lg:tw__justify-end tw__flex-col">
                                    ${actionBtn}
                                </div>
                            </div>
                        `;
                    });

                    let extra = [].filter.call(paneEl.querySelectorAll('.list-wrapper'), (el) => {
                        return el.dataset.index >= data.length;
                    });
                    extra.forEach((el) => {
                        el.remove();
                    });
                }
            } else {
                document.getElementById('shoppingList-container').innerHTML = ``;
                // Data is empty
                shoppingListContent = document.createElement('div');
                shoppingListContent.classList.add('list-wrapper', 'tw__p-4', 'first:tw__border-t', 'tw__border-b', 'tw__transition-all', 'hover:tw__bg-slate-100', 'hover:tw__bg-opacity-70');
                shoppingListContent.dataset.index = '0';
                shoppingListContent.innerHTML = `
                    <div class=" tw__grid tw__items-center tw__gap-2 lg:tw__gap-4">
                        No data available
                    </div>
                `;

                paneEl.appendChild(shoppingListContent);
            }
        };

        function archiveWallet(uuid){
            Swal.fire({
                title: 'Warning',
                icon: 'warning',
                html: `You'll perform archive action, all related record <strong>will not be affected</strong>. All child wallet will be adjusted!`,
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: 'Archive',
                showLoaderOnConfirm: true,
                preConfirm: (request) => {
                    return @this.call('archiveData', uuid).then((e) => {
                        Swal.fire({
                            'title': 'Action: Success',
                            'icon': 'success',
                            'text': 'Wallet data successfully archived'
                        }).then((e) => {
                            loadDataSkeleton();
                            Livewire.emit('refreshComponent');
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        }
    </script>
@endsection