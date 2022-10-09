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
    <div class="">
        <a href="javascript:void(0)" class="btn btn-primary"><i class="bx bx-plus"></i>Add new</a>
    </div>
    {{-- Be like water. --}}
    <div class="card tw__mt-4">
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
    </div>
</div>

@section('js_plugins')
    @include('layouts.plugins.jquery.js')
    @include('layouts.plugins.datatable.js')
@endsection

@section('js_inline')
    <script>
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
                        console.log(data);
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
                        return '-';
                    }
                }, 
            ],
            responsive: true
        });
    </script>
@endsection