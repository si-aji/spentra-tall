@section('title', 'Wallet Group: Detail')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>
            <a href="{{ route('sys.wallet.group.index') }}">Wallet Group: List</a>
        </span>
        <span class="active">Detail</span>
    </h4>
@endsection

@section('css_plugins')
    @include('layouts.plugins.datatable.css')
@endsection

<div>
    <div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-arrow-back'></i>Back</span>
        </a>
        <button type="button" class="btn btn-warning" data-uuid="{{ $walletGroup->uuid }}" x-on:click="$wire.emitTo('sys.component.wallet-group-modal', 'editAction', @this.get('walletGroupUuid'), true);">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-edit'></i>Edit</span>
        </button>
    </div>

    <div class="card tw__mt-4">
        <div class="card-body">
            <table class="table table-hover table-striped">
                <tr>
                    <th>Name</th>
                    <td>{{ $walletGroup->name }}</td>
                </tr>
                <tr>
                    <th>Account(s)</th>
                    <td>
                        <small class=" tw__flex tw__flex-wrap tw__items-center tw__gap-2 tw__mt-2">
                            @foreach ($walletGroup->walletGroupList as $item)
                                <small class=" bg-primary tw__px-2 tw__py-1 tw__rounded tw__text-white">{{ ($item->parent()->exists() ? $item->parent->name.' - ' : '').$item->name }}</small>
                            @endforeach
                        </small>
                    </td>
                </tr>
                <tr>
                    <th>Balance</th>
                    <td>
                        <span>{{ formatRupiah($walletGroup->getBalance()) }}</span>
                    </td>
                </tr>
            </table>

            {{-- <div class="card tw__mt-4" wire:ignore>
                <div class="card-header">
                    <h5 class="card-title tw__mb-0">Account(s)</h5>
                </div>
                <div class="card-body datatable">
                    <table class="table table-bordered table-hover table-striped" id="table-wallet_group_list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div> --}}
            <div class="card tw__mt-4">
                <div class="card-body tw__p-0">
                    <div class="sa-header tw__bg-white tw__rounded-t-lg tw__p-4">
                        <div class=" tw__flex tw__items-center tw__flex-wrap lg:tw__flex-nowrap lg:tw__justify-between">
                            @if ($paginateWallet->total() > 0)
                                <span>Showing {{ $paginateWallet->firstItem() }} to {{ $paginateWallet->lastItem() }} of {{ $paginateWallet->total() }} result{{ $paginateWallet->total() > 1 ? 's' : '' }}</span>
                            @else
                                <span>No data to be shown</span>
                            @endif
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
                            @if ($paginateWallet->total() > 0)
                                <span>Showing {{ $paginateWallet->firstItem() }} to {{ $paginateWallet->lastItem() }} of {{ $paginateWallet->total() }} result{{ $paginateWallet->total() > 1 ? 's' : '' }}</span>
                            @else
                                <span>No data to be shown</span>
                            @endif
                            <div class="">
                                {{ $paginateWallet->links('vendor.livewire.sneat') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card tw__mt-4">
                <div class="card-header">
                    <h5 class="card-title">Record History</h5>
                </div>
                <div class="card-body">
                    <div id="record-container">
                        <div>
                            @for ($i = 0; $i < 3; $i++)
                                <div class=" tw__flex tw__flex-col">
                                    <div class="list-wrapper tw__flex tw__gap-2 tw__mb-4 last:tw__mb-0">
                                        <div class=" tw__p-4 tw__text-center">
                                            <div class="tw__sticky tw__top-24 md:tw__top-40 tw__flex tw__items-center tw__flex-col">
                                                <span class="tw__font-semibold tw__bg-gray-300 tw__animate-pulse tw__h-4 tw__w-8 tw__block tw__rounded tw__mr-0 tw__mb-2"></span>
                                                <div class=" tw__min-h-[40px] tw__min-w-[40px] tw__bg-gray-300 tw__bg-opacity-60 tw__rounded-full tw__flex tw__leading-none tw__items-center tw__justify-center tw__align-middle tw__animate-pulse">
                                                    <p class="tw__mb-0 tw__font-bold tw__text-xl tw__text-white"></p>
                                                </div>
                                                <span class="tw__font-semibold tw__bg-gray-300 tw__animate-pulse tw__h-3 tw__w-12 tw__block tw__rounded tw__mr-0 tw__mt-1"></span>
                                            </div>
                                        </div>
                                        <div class=" tw__bg-gray-300 tw__rounded-lg tw__w-full content-list tw__p-4 tw__h-20 tw__animate-pulse tw__self-center">
                                            
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="card-footer tw__pt-0">
                    <div class=" tw__flex tw__items-center tw__justify-between">
                        <button wire:loading.remove wire:target="loadMore" type="button" class="btn btn-primary disabled:tw__cursor-not-allowed" {{ $paginate->hasMorePages() ? '' : 'disabled' }} wire:click="loadMore">
                            <span>Load more</span>
                        </button>
                        <button wire:loading.block wire:target="loadMore" type="button" class="btn btn-primary disabled:tw__cursor-not-allowed" disabled>
                            <span class=" tw__flex tw__items-center tw__gap-2">
                                <i class="bx bx-loader-alt bx-spin"></i>
                                <span>Loading</span>
                            </span>
                        </button>
                        <span>Showing {{ $paginate->count() }} of {{ $paginate->total() }} entries</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js_plugins')
    @include('layouts.plugins.jquery.js')
    @include('layouts.plugins.datatable.js')
    <script src="{{ mix('assets/js/format-record.js') }}"></script>
@endsection

@section('js_inline')
    <script>
        const generateRecordWalletList = () => {
            if(document.getElementById('record-container')){
                document.getElementById('record-container').innerHTML = ``;
            }

            let data = @this.get('walletRecordData');
            let paneEl = document.getElementById('record-container');
            console.log(data);

            if(data.length > 0){
                if(!paneEl.querySelector(`.content-wrapper`)){
                    recordContent = document.createElement('div');
                    recordContent.classList.add('content-wrapper');
                    recordContent.classList.add('tw__flex', 'tw__gap-4');
                    paneEl.appendChild(recordContent);
                } else {
                    recordContent = paneEl.querySelector('.content-wrapper');
                }

                let prevDate = null;
                data.forEach((val, index) => {
                    let date = val.datetime;
                    let original = val.datetime;
                    let recordDate = momentDateTime(val.datetime, 'YYYY-MM-DD');

                    if(recordDate != prevDate){
                        let listContainer = document.createElement('div');
                        listContainer.classList.add('list-wrapper', 'tw__flex', 'tw__gap-4', 'tw__mb-4', 'last:tw__mb-0');
                        listContainer.innerHTML = recordContainerFormat(val, index);
                        // Date not same with previous, generate new list
                        recordContent.appendChild(listContainer);
                        prevDate = recordDate;
                    }

                    // Append Record Item
                    let contentContainer = recordContent.querySelector(`.content-list[data-date="${momentDateTime(val.datetime, 'YYYY-MM-DD')}"]`);
                    if(contentContainer){
                        // console.log(contentContainer);
                        let item = document.createElement('div');
                        item.classList.add('tw__border-b', 'last:tw__border-b-0', 'tw__py-4', 'first:tw__pt-0', 'last:tw__pb-0');

                        // Append Action
                        let action = [];
                        // Detail Action
                        action.push(`
                            <li>
                                <a class="dropdown-item tw__text-blue-400" href="{{ route('sys.record.index') }}/${val.uuid}">
                                    <span class=" tw__flex tw__items-center"><i class="bx bx-show tw__mr-2"></i>Detail</span>
                                </a>
                            </li>
                        `);

                        // Append Item
                        item.innerHTML = recordContentFormat(val, index, action);
                        contentContainer.appendChild(item);
                    }
                });
            } else {
                // Data is empty
                recordContent = document.createElement('div');
                recordContent.classList.add('alert', 'alert-primary', 'tw__mb-0');
                recordContent.setAttribute('role', 'alert');
                recordContent.innerHTML = `
                    <div class=" tw__flex tw__items-center">
                        <i class="bx bx-error tw__mr-2"></i>
                        <div class="tw__block tw__font-bold tw__uppercase">
                            Attention!
                        </div>
                    </div>
                    <span class="tw__block tw__italic">No data found</span>
                `;

                paneEl.appendChild(recordContent);
            }
        };
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
            // Record
            window.dispatchEvent(new Event('walletGroupShowRecordLoadData'));
            // Wallet
            window.dispatchEvent(new Event('walletListLoadData'));
            document.getElementById('modal-wallet_balance').addEventListener('hide.bs.modal', (e) => {
                loadDataSkeleton();
                Livewire.emit('refreshComponent');
            });
        });
        window.addEventListener('walletGroupShowRecordLoadData', (e) => {
            generateRecordWalletList();
        });
        window.addEventListener('walletListLoadData', (e) => {
            if(document.getElementById('walletList-container')){
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
                                <a href="{{ route('sys.wallet.list.index') }}/${val.uuid}" class="btn btn-sm btn-primary">
                                    <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-show"></i>Detail</span>
                                </a>
                            `);
                            action.push(`
                                <button type="button" class="btn btn-sm btn-secondary" x-on:click="$wire.emitTo('sys.component.wallet-balance-modal', 'editAction', '${val.uuid}')">
                                    <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-slider"></i>Adjustment</span>
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
            }
        });

        if(document.getElementById('modal-wallet_group')){
            document.getElementById('modal-wallet_group').addEventListener('hide.bs.offcanvas', (e) => {
                loadDataSkeleton();
                Livewire.emit('refreshComponent');
            });
        }
        if(document.getElementById('modal-record')){
            document.getElementById('modal-record').addEventListener('hide.bs.modal', (e) => {
                loadDataSkeleton();
                Livewire.emit('refreshComponent');
            });
        }
        if(document.getElementById('modal-plannedPaymentRecord')){
            document.getElementById('modal-plannedPaymentRecord').addEventListener('hide.bs.modal', (e) => {
                loadDataSkeleton();
                Livewire.emit('refreshComponent');
            });
        }
    </script>
@endsection