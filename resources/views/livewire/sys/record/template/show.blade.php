@section('title', 'Record Template: Detail')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>
            <a href="{{ route('sys.record.index') }}">Record: List</a>
        </span>
        <span>
            <a href="{{ route('sys.record.template.index') }}">Record Template</a>
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
        <button type="button" class="btn btn-warning" data-uuid="{{ $recordTemplateData->uuid }}" x-on:click="$wire.emitTo('sys.component.record-template-modal', 'editAction', @this.get('recordTemplateUuid'))">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-edit'></i>Edit</span>
        </button>
    </div>

    <div class="card tw__mt-4">
        <div class="card-body">
            <table class="table table-hover">
                <tr>
                    <th>Name</th>
                    <td>{{ $recordTemplateData->name }}</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $recordTemplateData->category()->exists() ? ($recordTemplateData->category->parent()->exists() ? $recordTemplateData->category->parent->name.' - ' : '').$recordTemplateData->category->name : '-' }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>
                        <span class="badge bg-label-{{ $recordTemplateData->type === 'income' ? 'success' : ($recordTemplateData->type === 'expense' ? 'danger' : 'secondary') }}">{{ ucwords($recordTemplateData->type) }}</span>
                    </td>
                </tr>
                <tr>
                    <th>{{ $recordTemplateData->type === 'transfer' ? 'From' : 'Wallet' }}</th>
                    <td>{{ $recordTemplateData->wallet()->exists() ? ($recordTemplateData->wallet->parent()->exists() ? $recordTemplateData->wallet->parent->name.' - ' : '').$recordTemplateData->wallet->name : '-' }}</td>
                </tr>
                @if ($recordTemplateData->type === 'transfer')
                    <tr>
                        <th>To</th>
                        <td>{{ $recordTemplateData->walletTransferTarget()->exists() ? ($recordTemplateData->walletTransferTarget->parent()->exists() ? $recordTemplateData->walletTransferTarget->parent->name.' - ' : '').$recordTemplateData->walletTransferTarget->name : '-' }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Amount</th>
                    <td>{{ formatRupiah($recordTemplateData->amount) }}</td>
                </tr>
                @if ($recordTemplateData->type !== 'transfer')
                    <tr>
                        <th>Extra Amount</th>
                        <td>
                            <span>
                                <span class="badge bg-label-secondary">{{ ucwords($recordTemplateData->extra_type) }}</span>
                                <span>{{ $recordTemplateData->extra_type === 'amount' ? formatRupiah($recordTemplateData->extra_amount) : $recordTemplateData->extra_percentage.'%' }}</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Final Amount</th>
                        <td>{{ formatRupiah($recordTemplateData->amount + $recordTemplateData->extra_amount) }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Note</th>
                    <td>{{ $recordTemplateData->note ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@section('js_inline')
    <script>
        if(document.getElementById('modal-recordTemplate')){
            document.getElementById('modal-recordTemplate').addEventListener('hide.bs.modal', (e) => {
                @this.emit('refreshComponent');
            });
        }
    </script>
@endsection
