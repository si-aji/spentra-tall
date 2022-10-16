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
                    <th>Account</th>
                    <td>
                        <small class=" tw__flex tw__items-center tw__gap-2 tw__mt-2">
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

            <div class="card tw__mt-4" wire:ignore>
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
        let table = null;
        const initDatatable = () => {
            console.log("Initialize Datatable");
            if(table != null){
                table.destroy();
                console.log(table);
            }
            table = new DataTable('#table-wallet_group_list', {
                order: [0, 'asc'],
                pagingType: 'numbers',
                lengthMenu: [5, 10, 25],
                stateSave: true,
                processing: true,
                serverSide: true,
                retrieve: true,
                ajax: {
                    url: "{{ route('api.sys.v0.wallet.list') }}",
                    type: "GET",
                    data: function(d){
                        d.is_datatable = true;
                        d.wallet_group = "{{ $walletGroup->uuid }}"
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
        }
        document.addEventListener('wallet_group_wire-init', (event) => {
            initDatatable();
        });

        if(document.getElementById('modal-wallet_group')){
            document.getElementById('modal-wallet_group').addEventListener('hide.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.wallet.group.show', 'refreshComponent');
            });
        }
        if(document.getElementById('modal-wallet_balance')){
            document.getElementById('modal-wallet_balance').addEventListener('hide.bs.modal', (e) => {
                table.ajax.reload(null, false);
                Livewire.emitTo('sys.wallet.group.show', 'refreshComponent');
            });
        }
    </script>
@endsection