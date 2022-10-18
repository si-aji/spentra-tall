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

<div id="record-detail">
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-arrow-back'></i>Back</span>
        </a>
        <button type="button" class="btn btn-warning" data-uuid="{{ $recordData->uuid }}" x-on:click="$wire.emitTo('sys.component.record-modal', 'editAction', @this.get('recordUuid'))">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-edit'></i>Edit</span>
        </button>
    </div>

    <div class="card tw__mt-4">
        <div class="card-body">
            <table class="table table-hover">
                <tr>
                    <th>Date</th>
                    <td data-period="{{ $recordData->datetime }}">-</td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $recordData->category()->exists() ? ($recordData->category->parent()->exists() ? $recordData->category->parent->name.' - ' : '').$recordData->category->name : '-' }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>
                        <span class="badge bg-label-{{ !empty($recordData->to_wallet_id) ? 'secondary' : ($recordData->type === 'income' ? 'success' : 'danger') }}">{{ (!empty($recordData->to_wallet_id) ? 'Transfer - ' : '').ucwords($recordData->type) }}</span>
                    </td>
                </tr>
                <tr>
                    <th>{{ !empty($recordData->to_wallet_id) ? 'From' : 'Wallet' }}</th>
                    <td>
                        @if (!empty($recordData->to_wallet_id) && $recordData->type === 'income')
                            {{ $recordData->walletTransferTarget()->exists() ? ($recordData->walletTransferTarget->parent()->exists() ? $recordData->walletTransferTarget->parent->name.' - ' : '').$recordData->walletTransferTarget->name : '-' }}
                        @else
                            {{ $recordData->wallet()->exists() ? ($recordData->wallet->parent()->exists() ? $recordData->wallet->parent->name.' - ' : '').$recordData->wallet->name : '-' }}
                        @endif
                    </td>
                </tr>
                @if (!empty($recordData->to_wallet_id))
                    <tr>
                        <th>To</th>
                        <td>
                            @if (!empty($recordData->to_wallet_id) && $recordData->type === 'income')
                                {{ $recordData->wallet()->exists() ? ($recordData->wallet->parent()->exists() ? $recordData->wallet->parent->name.' - ' : '').$recordData->wallet->name : '-' }}
                            @else
                                {{ $recordData->walletTransferTarget()->exists() ? ($recordData->walletTransferTarget->parent()->exists() ? $recordData->walletTransferTarget->parent->name.' - ' : '').$recordData->walletTransferTarget->name : '-' }}
                            @endif
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>{{ empty($recordData->to_wallet_id) ? 'Base ' : '' }}Amount</th>
                    <td>{{ formatRupiah($recordData->amount) }}</td>
                </tr>
                @if (empty($recordData->to_wallet_id))
                    <tr>
                        <th>Extra Amount</th>
                        <td>
                            <span>
                                <span class="badge bg-label-secondary">{{ ucwords($recordData->extra_type) }}</span>
                                <span>{{ $recordData->extra_type === 'amount' ? formatRupiah($recordData->extra_amount) : $recordData->extra_percentage.'%' }}</span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Final Amount</th>
                        <td>{{ formatRupiah($recordData->amount + $recordData->extra_amount) }}</td>
                    </tr>
                @endif
                <tr>
                    <th>Note</th>
                    <td>{{ $recordData->note ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Receipt</th>
                    <td>
                        @if ($recordData->receipt)
                            <a href="{{ asset($recordData->receipt) }}" data-fslightbox>
                                <span><i class="bx bx-paperclip bx-rotate-90 tw__mr-1"></i>Receipt</span>
                            </a>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>

    @if (!empty($recordData->to_wallet_id) && $recordData->getRelatedTransferRecord())
        <div class="card tw__mt-2" id="related-record">
            <div class="card-header tw__pb-0">
                <h5 class="card-title">Related Record</h5>
            </div>
            <div class="card-body">
                <div class="">

                </div>
            </div>
        </div>
    @endif
</div>

@section('js_plugins')
    <script src="{{ mix('assets/js/format-record.js') }}"></script>
@endsection

@section('js_inline')
    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            refreshFsLightbox();

            let container = document.getElementById('record-detail');
            container.querySelectorAll('[data-period]').forEach((el) => {
                el.innerHTML = momentDateTime(el.dataset.period, 'DD MMM, YYYY / HH:mm', true);
            });

            if(document.getElementById('modal-record')){
                document.getElementById('modal-record').addEventListener('hide.bs.modal', (e) => {
                    @this.emit('refreshComponent');
                });
            }
        });
    </script>

    @if (!empty($recordData->to_wallet_id) && $recordData->getRelatedTransferRecord())
        <script>
            document.addEventListener('DOMContentLoaded', (e) => {
                let container = document.getElementById('related-record');
                let bodyModal = container.querySelector('.card-body');
                let val = @js($recordData->getRelatedTransferRecord());
                let action = [];

                if(bodyModal){
                    // Detail Action
                    action.push(`
                        <li>
                            <a class="dropdown-item tw__text-blue-400" href="{{ route('sys.record.index') }}/${val.uuid}">
                                <span class=" tw__flex tw__items-center"><i class="bx bx-show tw__mr-2"></i>Detail</span>
                            </a>
                        </li>
                    `);
                    
                    bodyModal.innerHTML = `
                        <div class=" tw__bg-gray-50 tw__rounded-lg tw__w-full content-list tw__p-4">
                            ${recordContentFormat(val, 0, action)}
                        </div>
                    `;
                }
            });
        </script>
    @endif
@endsection