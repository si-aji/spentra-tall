@section('title', 'Wallet Group')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span class="active">Wallet Group: List</span>
    </h4>
@endsection

@section('css_plugins')
    @include('layouts.plugins.datatable.css')
@endsection

<div id="walletGroupIndex" x-data="{
    refreshState: false
}">
    <div class=" tw__shadow tw__rounded-lg">
        <div class="sa-header tw__bg-white tw__p-4 tw__rounded-t-lg">
            <div class=" tw__flex tw__items-center tw__flex-wrap lg:tw__flex-nowrap lg:tw__justify-between">
                <span>Showing {{ $paginate->firstItem() }} to {{ $paginate->lastItem() }} of {{ $paginate->total() }} result{{ $paginate->total() > 1 ? 's' : '' }}</span>
                <div class="">
                    {{-- <button type="button" class="btn btn-outline-secondary" @click="refreshState = true" :disabled="refreshState">
                        <span class=" tw__flex tw__items-center tw__gap-1"><i class="bx bx-refresh" :class="refreshState ? 'bx-spin-reverse' : ''"></i>Refresh</span>
                    </button> --}}
                    <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#modal-wallet_group">
                        <span class=" tw__flex tw__items-center tw__gap-1"><i class="bx bx-plus"></i>Add new</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="sa-body tw__bg-white" id="wallet_group-container" wire:ignore>
        </div>
        <div class="sa-footer tw__bg-white tw__rounded-b-lg tw__p-4">
            <div class=" tw__flex tw__items-center tw__flex-wrap lg:tw__flex-nowrap lg:tw__justify-between">
                <span>Showing {{ $paginate->firstItem() }} to {{ $paginate->lastItem() }} of {{ $paginate->total() }} result{{ $paginate->total() > 1 ? 's' : '' }}</span>
                <div class="">
                    {{ $paginate->links('vendor.livewire.sneat') }}
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
    <script>
        // let table = new DataTable('#table-wallet_group', {
        //     order: [1, 'asc'],
        //     pagingType: 'numbers',
        //     lengthMenu: [5, 10, 25],
        //     stateSave: true,
        //     processing: true,
        //     serverSide: true,
        //     ajax: {
        //         url: "{{ route('api.sys.v0.wallet.group.list') }}",
        //         type: "GET",
        //         data: function(d){
        //             d.is_datatable = true;
        //         }
        //     },
        //     columns: [
        //         { "data": null },
        //         { "data": "name" },
        //         { "data": null },
        //         { "data": null },
        //     ],
        //     columnDefs: [
        //         {
        //             targets: 0,
        //             searchable: false,
        //             sortable: false,
        //             render: function (row, type, data, meta) {
        //                 return parseInt(meta.row) + 1;
        //             }
        //         }, {
        //             targets: 1,
        //             render: function (row, type, data, meta) {
        //                 // console.log(data);
        //                 return '-';
        //                 return `
        //                     ${row}
        //                     <small class="tw__block tw__italic text-muted">${formatRupiah(data.balance)}</small>
        //                 `;
        //             }
        //         }, {
        //             targets: 2,
        //             searchable: false,
        //             sortable: false,
        //             render: function (row, type, data, meta) {
        //                 return '-';
        //                 const showLimit = 2;
        //                 let showMore = true;
        //                 let walletList = [];
        //                 data.wallet_group_list.forEach((wgl, row) => {
        //                     if(row < showLimit){
        //                         let walletName = wgl.name;
        //                         if(wgl.parent_id){
        //                             walletName = `${wgl.parent.name} - ${wgl.name}`;
        //                         }
        //                         walletList.push(`<small class=" bg-primary tw__px-2 tw__py-1 tw__rounded tw__text-white">${walletName}</small>`);
        //                     } else if(showMore) {
        //                         showMore = false;
        //                         walletList.push(`<small class=" tw__bg-gray-400 tw__px-2 tw__py-1 tw__rounded tw__text-white">and ${(data.wallet_group_list).length - showLimit} more..</small>`);
        //                     }
        //                 });

        //                 return `
        //                     <small class=" tw__flex tw__items-center tw__gap-2 tw__mt-2 tw__flex-wrap">
        //                         ${walletList.join('')}
        //                     </small>
        //                 `;
        //             }
        //         }, {
        //             targets: 3,
        //             searchable: false,
        //             sortable: false,
        //             render: function (row, type, data, meta) {
        //                 return '-';
        //                 return `
        //                     <div class="">
        //                         <a href="{{ route('sys.wallet.group.index') }}/${data.uuid}" class="btn btn-sm btn-primary">
        //                             <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-show"></i>Detail</span>
        //                         </a>
        //                         <button type="button" class="btn btn-sm btn-warning" x-on:click="$wire.emitTo('sys.component.wallet-group-modal', 'editAction', '${data.uuid}')">
        //                             <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-edit"></i>Edit</span>
        //                         </button>
        //                     </div>
        //                 `;
        //             }
        //         }, 
        //     ],
        //     responsive: true
        // });
        // let tableSkeletonDraw = false;
        // table.on('processing.dt', (e, settings, processing) => {
        //     if(processing){
        //         console.log("Show skeleton");

        //         if(tableSkeletonDraw){
        //             tableSkeletonDraw = false;
        //         } else {
        //             tableSkeletonDraw = true;
        //             table.row.add([
        //                 '<span>-</span>',
        //                 '<span>-</span>',
        //                 '<span>-</span>',
        //                 '<span>-</span>',
        //             ]).draw(false);
        //         }
        //         // // Show Processing
        //         // table.row.add([
        //         //     '<span>-</span>',
        //         //     '<span>-</span>',
        //         //     '<span>-</span>',
        //         //     '<span>-</span>',
        //         // ]).draw();
        //     } else {
        //         // Load complete
        //         console.log("Hide skeleton");
        //     }
        // });

        let loadSkeleton = false;
        const loadDataSkeleton = () => {
            let container = document.getElementById('wallet_group-container');

            if(container){
                // Check if child element exists
                if(container.querySelectorAll('.group-list').length > 0){
                    container.querySelectorAll('.group-list').forEach((el, index) => {
                        el.innerHTML = `
                            <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-1 lg:tw__grid-cols-3 tw__items-center tw__gap-2 lg:tw__gap-4">
                                <div class="">
                                    <span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-36 tw__h-5"></span>
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

                        if(container.querySelector(`.group-list[data-index="${index}"]`)){
                            let items = [];
                            for(j = 0; j < Math.floor(Math.random() * 15) + 1; j++){
                                items.push(`<span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-12 tw__h-5"></span>`);
                            }

                            (container.querySelector(`.group-list[data-index="${index}"]`)).querySelector('.list-item').innerHTML = items.join('');
                        }
                    });
                } else {
                    // Child not yet exists, create new data instead using existing data
                    for(i = 0; i < 15; i++){
                        let el = document.createElement('div');
                        el.classList.add('group-list', 'tw__p-4', 'first:tw__border-t', 'tw__border-b', 'tw__transition-all', 'hover:tw__bg-slate-100', 'hover:tw__bg-opacity-70');
                        el.dataset.index = i;
                        el.innerHTML = `
                            <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-1 lg:tw__grid-cols-3 tw__items-center tw__gap-2 lg:tw__gap-4">
                                <div class="">
                                    <span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-36 tw__h-5"></span>
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
                        container.appendChild(el);

                        if(container.querySelector(`.group-list[data-index="${i}"]`)){
                            let items = [];
                            for(j = 0; j < Math.floor(Math.random() * 15) + 1; j++){
                                items.push(`<span class=" tw__block tw__bg-gray-300 tw__rounded tw__animate-pulse tw__w-12 tw__h-5"></span>`);
                            }

                            (container.querySelector(`.group-list[data-index="${i}"]`)).querySelector('.list-item').innerHTML = items.join('');
                        }
                    }
                }
            }
        };
        const loadData = () => {
            console.log("Load data");
            loadSkeleton = false;
            let container = document.getElementById('wallet_group-container');

            if(container){
                let data = @this.get('dataWalletGroup');
                console.log(data);
                if(data.length > 0){
                    let existingItem = container.querySelectorAll('.group-list');
                    if(existingItem.length > 0){
                        data.forEach((val, index) => {
                            // console.log(val);
                            let wrapper = container.querySelector(`.group-list[data-index="${index}"]`);
                            if(!wrapper){
                                let wrapperTemp = document.createElement(`div`);
                                wrapperTemp.classList.add('group-list', 'tw__p-4', 'first:tw__border-t', 'tw__border-b', 'tw__transition-all', 'hover:tw__bg-slate-100', 'hover:tw__bg-opacity-70');
                                wrapperTemp.dataset.index = index;
                                container.appendChild(wrapperTemp);

                                wrapper = container.querySelector(`.group-list[data-index="${index}"]`);
                            }

                            wrapper.innerHTML = `
                                <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-1 lg:tw__grid-cols-3 tw__items-center tw__gap-2 lg:tw__gap-4">
                                    <div class="">
                                        <span class="">${val.name}</span>
                                        <small class="tw__block tw__italic text-muted">${formatRupiah(val.balance)}</small>
                                    </div>
                                    <div class=" tw__flex tw__flex-wrap tw__gap-2 list-item">
                                    </div>
                                    <div class=" tw__flex tw__gap-2 lg:tw__justify-end">
                                        <div class="">
                                            <a href="{{ route('sys.wallet.group.index') }}/${val.uuid}" class="btn btn-sm btn-primary">
                                                <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-show"></i>Detail</span>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-warning" x-on:click="$wire.emitTo('sys.component.wallet-group-modal', 'editAction', '${val.uuid}')">
                                                <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-edit"></i>Edit</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;

                            let items = [];
                            let selectedWallet = val.wallet_group_list.length;
                            if(selectedWallet > 0){
                                (val.wallet_group_list).some((lis, index) => {
                                    // console.log(lis);
                                    let stopper = 4;
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

                        let extra = [].filter.call(container.querySelectorAll('.group-list'), (el) => {
                            return el.dataset.index >= data.length;
                        });
                        extra.forEach((el) => {
                            el.remove();
                        });
                    } else {

                    }
                } else {
                    // Data not found
                }
            }
        }

        Livewire.hook('message.sent', (message, component) => {
            if(component.el.id && component.el.id === 'walletGroupIndex'){
                loadSkeleton = true;

                setTimeout(() => {
                    if(loadSkeleton){
                        loadDataSkeleton();
                    }
                }, 250);
            }
        });

        loadDataSkeleton();
        window.addEventListener('wallet_group_index_wire-init', () => {
            loadData();
        });
        document.addEventListener('DOMContentLoaded', () => {
            loadData();
        });

        if(document.getElementById('modal-wallet_group')){
            document.getElementById('modal-wallet_group').addEventListener('hide.bs.offcanvas', (e) => {
                console.log("Refresh datatable");
                // table.ajax.reload(null, false);
            });
        }
    </script>
@endsection