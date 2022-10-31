@section('title', 'Wallet Share')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span class="active">Wallet Share: List</span>
    </h4>
@endsection

@section('css_plugins')
    @include('layouts.plugins.datatable.css')
@endsection

<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="">
        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#modal-wallet_share">
            <span class=" tw__flex tw__items-center tw__gap-2"><i class="bx bx-plus"></i>Add new</span>
        </a>
    </div>
</div>
