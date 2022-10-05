@section('title', 'Wallet List')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span class="active">Wallet: List</span>
    </h4>
@endsection

<div>
    <div class="">
        <a href="javascript:void(0)" class="btn btn-primary"><i class="bx bx-plus"></i>Add new</a>
    </div>
    {{-- Be like water. --}}
    <div class="card tw__mt-4">
        <div class="card-body">
            <livewire:datatable model="App\Models\Wallet" name="all-users" />
        </div>
    </div>
</div>
