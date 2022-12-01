@section('title', 'Record Template')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>
            <a href="{{ route('sys.record.index') }}">Record: List</a>
        </span>
        <span class="active">Template</span>
    </h4>
@endsection

@section('css_plugins')
    @include('layouts.plugins.datatable.css')
@endsection

<div>
    {{-- In work, do what you enjoy. --}}
    {{-- <div class=" tw__mb-4">
        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-recordTemplate">
            <span class=" tw__flex tw__items-center tw__gap-2"><i class="bx bx-plus"></i>Add new</span>
        </a>
    </div>
    <div class="card tw__mt-4">
        <div wire:ignore>
            <div class="card-body datatable">
                <table class="table table-hover table-striped table-bordered" id="table-recordTemplate">
                    <thead>
                        <th>#</th>
                        <th>Name</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </thead>
                </table>
            </div>
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
                    <div class="">
                        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-recordTemplate">
                            <span class=" tw__flex tw__items-center tw__gap-2"><i class="bx bx-plus"></i>Add new</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="">
                <div class=" tw__hidden lg:tw__grid tw__grid-flow-col tw__grid-cols-3 tw__items-center tw__gap-4 tw__px-4 tw__py-2 tw__border-t">
                    <span>Name</span>
                    <span>Amount</span>
                    <span class=" tw__flex tw__justify-end">Action</span>
                </div>
                <div id="recordTemplate-container" wire:ignore></div>
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
        let table = new DataTable('#table-recordTemplate', {
            order: [1, 'asc'],
            pagingType: 'numbers',
            lengthMenu: [5, 10, 25],
            stateSave: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('api.sys.v0.record.template.list') }}",
                type: "GET",
                data: function(d){
                    d.is_datatable = true;
                }
            },
            columns: [
                { "data": "created_at" },
                { "data": "name" },
                { "data": "amount" },
                { "data": null },
            ],
            columnDefs: [
                {
                    targets: 0,
                    sortable: false,
                    searchable: false,
                    render: function (row, type, data, meta) {
                        return parseInt(meta.row) + 1;
                    }
                }, {
                    targets: 1,
                    render: function (row, type, data, meta) {
                        // console.log(data);
                        return row;
                    }
                }, {
                    targets: 2,
                    sortable: false,
                    render: function (row, type, data, meta) {
                        return formatRupiah(row + data.extra_amount);
                    }
                }, {
                    targets: 3,
                    searchable: false,
                    sortable: false,
                    render: function (row, type, data, meta) {
                        return `
                            <div class="">
                                <button type="button" class="btn btn-sm btn-warning" x-on:click="$wire.emitTo('sys.component.record-template-modal', 'editAction', '${data.uuid}')">
                                    <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-edit"></i>Edit</span>    
                                </button>
                                <a href="{{ route('sys.record.template.index') }}/${data.uuid}" class="btn btn-sm btn-primary">
                                    <span class="tw__flex tw__items-center tw__gap-2 tw__text-white"><i class="bx bx-show"></i>Detail</span>    
                                </a>
                            </div>
                        `;
                    }
                }, 
            ],
            responsive: true
        });

        if(document.getElementById('modal-recordTemplate')){
            document.getElementById('modal-recordTemplate').addEventListener('hide.bs.offcanvas', (e) => {
                table.ajax.reload(null, false);
            });
        }
        if(document.getElementById('modal-recordTemplate')){
            document.getElementById('modal-recordTemplate').addEventListener('hide.bs.modal', (e) => {
                table.ajax.reload(null, false);
            });
        }
    </script> --}}
    <script>
        let loadSkeleton = false;
        const loadDataSkeleton = () => {
            let container = document.getElementById('recordTemplate-container');

            if(container){
                let template = `
                    <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-1 lg:tw__grid-cols-3 tw__items-center tw__gap-2 lg:tw__gap-4 tw__animate-pulse">
                        <div class=" ">
                            <span class=" tw__bg-gray-300 tw__rounded tw__w-20 tw__h-5 tw__flex"></span>
                            <span class=" tw__flex tw__items-center tw__gap-1 tw__mt-1">
                                <span class=" tw__bg-gray-300 tw__rounded tw__w-5 tw__h-3 tw__flex"></span>
                                <span class=" tw__bg-gray-300 tw__rounded tw__w-24 tw__h-3 tw__flex"></span>
                            </span>
                        </div>
                        <div class=" tw__flex tw__items-start tw__gap-1 tw__flex-col">
                            <span class=" tw__bg-gray-300 tw__rounded tw__w-32 tw__h-5 tw__flex"></span>
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
            window.dispatchEvent(new Event('recordTemplateLoadData'));

            document.getElementById('modal-recordTemplate').addEventListener('hidden.bs.modal', (e) => {
                loadDataSkeleton();
                Livewire.emit('refreshComponent');
            });
        });

        window.addEventListener('recordTemplateLoadData', (e) => {
            if(document.getElementById('recordTemplate-container')){
                // document.getElementById('recordTemplate-container').innerHTML = ``;
                generateList();
            }
        });

        // Generate Shopping List
        const generateList = () => {
            // Get data from Component
            let data = @this.get('dataRecordTemplate');
            console.log(data);
            let paneEl = document.getElementById('recordTemplate-container');
            let recordTemplateContent = null;

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
                            <button type="button" class="btn btn-sm btn-warning" data-uuid="${val.uuid}" x-on:click="$wire.emitTo('sys.component.record-template-modal', 'editAction', '${val.uuid}')">
                                <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-edit"></i>Edit</span>
                            </button>
                        `);
                        action.push(`
                            <a href="{{ route('sys.record.template.index') }}/${val.uuid}" class="btn btn-sm btn-primary">
                                <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-show"></i>Detail</span>
                            </a>
                        `);
                        // Delete Action
                        // action.push(`
                        //     <button type="button" class="btn btn-sm btn-danger" data-uuid="${val.uuid}" x-on:click="removeRecord('${val.uuid}')">
                        //         <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-trash"></i>Remove</span>
                        //     </button>
                        // `);
                        // Handle Action wrapper
                        let actionBtn = '';
                        if(action.length > 0){
                            actionBtn = `
                                <div class=" tw__flex tw__gap-2 lg:tw__justify-end tw__flex-wrap">
                                    ${action.join('')}
                                </div>
                            `;
                        }

                        let amount = parseFloat(val.amount) + parseFloat(val.extra_amount);
                        let typeIcon = `<i class="bx bxs-arrow-to-bottom"></i>`;
                        let typeBg = 'tw__bg-green-400';
                        if(val.type === 'expense'){
                            typeIcon = `<i class="bx bxs-arrow-from-bottom"></i>`;
                            typeBg = 'tw__bg-red-400';
                        } else if(val.type === 'transfer'){
                            typeIcon = `<i class="bx bx-transfer"></i>`;
                            typeBg = 'tw__bg-gray-400';
                        }

                        let extraInformation = [];
                        extraInformation.push(`<small class=" tw__flex tw__items-start lg:tw__items-center tw__gap-1 tw__leading-[1.25]"><i class='bx bx-time'></i>Created at ${momentDateTime(val.created_at, 'DD MMM, YYYY / HH:mm', true)}</small>`);
                        extraInformation.push(`<small class=" tw__flex tw__items-start lg:tw__items-center tw__gap-1 tw__leading-[1.25]"><i class='bx bx-timer'></i>Last Update at ${momentDateTime(val.updated_at, 'DD MMM, YYYY / HH:mm', true)}</small>`);
                        wrapper.innerHTML = `
                            <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-1 lg:tw__grid-cols-3 tw__items-center tw__gap-2 lg:tw__gap-4">
                                <div class="">
                                    <strong class="">${val.name}</strong>
                                    <small class=" tw__hidden lg:tw__flex tw__items-center tw__gap-1"><i class="bx bx-align-left"></i>${val.note ? val.note : 'No Description'}</small>
                                </div>
                                <div class="" x-data="{toggle: false}">
                                    <span class="tw__block" data-orig="${formatRupiah(amount)}" data-short="${formatRupiah(amount, 'Rp', true)}" x-on:click="toggle = !toggle;$el.innerHTML = (toggle ? $el.dataset.orig : $el.dataset.short)">${formatRupiah(amount, 'Rp', true)}</span>
                                    <small class="tw__text-white tw__gap-1 tw__px-2 tw__py-1 tw__rounded-full ${typeBg}">${typeIcon}${ucwords(val.type)}</small>
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
                document.getElementById('recordTemplate-container').innerHTML = ``;
                // Data is empty
                recordTemplateContent = document.createElement('div');
                recordTemplateContent.classList.add('list-wrapper', 'tw__p-4', 'first:tw__border-t', 'tw__border-b', 'tw__transition-all', 'hover:tw__bg-slate-100', 'hover:tw__bg-opacity-70');
                recordTemplateContent.dataset.index = '0';
                recordTemplateContent.innerHTML = `
                    <div class=" tw__grid tw__items-center tw__gap-2 lg:tw__gap-4">
                        No data available
                    </div>
                `;

                paneEl.appendChild(recordTemplateContent);
            }
        };
    </script>
@endsection