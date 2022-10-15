@section('title', 'Record: Detail')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>
            <a href="{{ route('sys.record.index') }}">Record: List</a>
        </span>
        <span class="active">Detail</span>
    </h4>
@endsection

<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-arrow-back'></i>Back</span>
        </a>
        <button type="button" class="btn btn-warning" data-uuid="{{ $recordData->uuid }}" x-on:click="$wire.emitTo('sys.component.record-modal', 'editAction', @this.get('recordUuid'))">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-edit'></i>Edit</span>
        </button>
    </div>
</div>
