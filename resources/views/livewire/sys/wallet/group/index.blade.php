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

<div>
    <div class="">
        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#modal-wallet_group">
            <span class=" tw__flex tw__items-center tw__gap-2"><i class="bx bx-plus"></i>Add new</span>
        </a>
    </div>
    {{-- Be like water. --}}
    <div class="card tw__mt-4">
        <div class="card-body datatable">
            <table class="table table-hover table-striped table-bordered" id="table-wallet_group">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Account</th>
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
        let table = new DataTable('#table-wallet_group', {
            order: [1, 'asc'],
            pagingType: 'numbers',
            lengthMenu: [5, 10, 25],
            stateSave: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('api.sys.v0.wallet.group.list') }}",
                type: "GET",
                data: function(d){
                    d.is_datatable = true;
                }
            },
            columns: [
                { "data": null },
                { "data": "name" },
                { "data": null },
                { "data": null },
            ],
            columnDefs: [
                {
                    targets: 0,
                    searchable: false,
                    sortable: false,
                    render: function (row, type, data, meta) {
                        return parseInt(meta.row) + 1;
                    }
                }, {
                    targets: 1,
                    render: function (row, type, data, meta) {
                        // console.log(data);
                        return `
                            ${row}
                            <small class="tw__block tw__italic text-muted">${formatRupiah(data.balance)}</small>
                        `;
                    }
                }, {
                    targets: 2,
                    searchable: false,
                    sortable: false,
                    render: function (row, type, data, meta) {
                        const showLimit = 2;
                        let showMore = true;
                        let walletList = [];
                        data.wallet_group_list.forEach((wgl, row) => {
                            if(row < showLimit){
                                let walletName = wgl.name;
                                if(wgl.parent_id){
                                    walletName = `${wgl.parent.name} - ${wgl.name}`;
                                }
                                walletList.push(`<small class=" bg-primary tw__px-2 tw__py-1 tw__rounded tw__text-white">${walletName}</small>`);
                            } else if(showMore) {
                                showMore = false;
                                walletList.push(`<small class=" tw__bg-gray-400 tw__px-2 tw__py-1 tw__rounded tw__text-white">and ${(data.wallet_group_list).length - showLimit} more..</small>`);
                            }
                        });

                        return `
                            <small class=" tw__flex tw__items-center tw__gap-2 tw__mt-2 tw__flex-wrap">
                                ${walletList.join('')}
                            </small>
                        `;
                    }
                }, {
                    targets: 3,
                    searchable: false,
                    sortable: false,
                    render: function (row, type, data, meta) {
                        return `
                            <div class="">
                                <a href="{{ route('sys.wallet.group.index') }}/${data.uuid}" class="btn btn-sm btn-primary">
                                    <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-show"></i>Detail</span>
                                </a>
                                <button type="button" class="btn btn-sm btn-warning" x-on:click="$wire.emitTo('sys.component.wallet-group-modal', 'editAction', '${data.uuid}')">
                                    <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-edit"></i>Edit</span>
                                </button>
                            </div>
                        `;
                    }
                }, 
            ],
            responsive: true
        });

        if(document.getElementById('modal-wallet_group')){
            document.getElementById('modal-wallet_group').addEventListener('hide.bs.offcanvas', (e) => {
                console.log("Refresh datatable");
                table.ajax.reload(null, false);
            });
        }
    </script>
@endsection