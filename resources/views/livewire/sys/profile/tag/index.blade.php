@section('title', 'Tag')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>Profile</span>
        <span class="active">Tag</span>
    </h4>
@endsection

@section('css_plugins')
    @include('layouts.plugins.datatable.css')
@endsection

<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills flex-column flex-md-row">
                @foreach ($extraMenu as $menu)
                    <li class="nav-item">
                        <a class="nav-link {{ $submenuState === $menu['state'] ? 'active' : '' }}" href="{{ isset($menu['route']) && !empty($menu['route']) ? route($menu['route']) : 'javascript:void(0);' }}"><i class="{{ $menu['icon'] }} me-1"></i> {{ $menu['name'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class=" tw__mt-4">
        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#modal-tag">
            <span class=" tw__flex tw__items-center tw__gap-2"><i class="bx bx-plus"></i>Add new</span>
        </a>
    </div>
    {{-- Be like water. --}}
    <div class="card tw__mt-4">
        <div class="card-body datatable">
            <table class="table table-hover table-striped table-bordered" id="table-tag">
                <thead>
                    <th>#</th>
                    <th>Name</th>
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
        let table = new DataTable('#table-tag', {
            order: [1, 'asc'],
            pagingType: 'numbers',
            lengthMenu: [5, 10, 25],
            stateSave: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('api.sys.v0.tag.list') }}",
                type: "GET",
                data: function(d){
                    d.is_datatable = true;
                }
            },
            columns: [
                { "data": "created_at" },
                { "data": "name" },
                { "data": null },
            ],
            columnDefs: [
                {
                    targets: 0,
                    render: function (row, type, data, meta) {
                        return parseInt(meta.row) + 1;
                    }
                }, {
                    targets: 1,
                    render: function (row, type, data, meta) {
                        // console.log(data);
                        let tagName = `${data.name}`;
                        return tagName;
                    }
                }, {
                    targets: 2,
                    searchable: false,
                    sortable: false,
                    render: function (row, type, data, meta) {
                        return `
                            <div class="">
                                <button type="button" class="btn btn-sm btn-warning" x-on:click="$wire.emitTo('sys.component.tag-modal', 'editAction', '${data.uuid}')">
                                    <span class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-edit"></i>Edit</span>    
                                </button>
                            </div>
                        `;
                    }
                }, 
            ],
            responsive: true
        });

        if(document.getElementById('modal-tag')){
            document.getElementById('modal-tag').addEventListener('hide.bs.offcanvas', (e) => {
                console.log("Refresh datatable");
                table.ajax.reload(null, false);
            });
        }
    </script>
@endsection