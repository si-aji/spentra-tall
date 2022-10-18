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
    <div class=" tw__mb-4">
        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-recordTemplate">
            <span class=" tw__flex tw__items-center tw__gap-2"><i class="bx bx-plus"></i>Add new</span>
        </a>
    </div>
    <div class="card tw__mt-4" wire:ignore>
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
</div>

@section('js_plugins')
    @include('layouts.plugins.jquery.js')
    @include('layouts.plugins.datatable.js')
@endsection

@section('js_inline')
    <script>
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
                                <a href="{{ route('sys.record.template.index') }}/${data.uuid}" class="btn btn-sm tw__bg-blue-400">
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
    </script>
@endsection