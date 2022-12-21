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
    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-body">
                    {{-- Summary --}}
                    <div class=" tw__grid tw__grid-cols-1 md:tw__grid-cols-2 tw__gap-2">
                        {{-- Type --}}
                        <div class=" tw__grid tw__grid-flow-row tw__gap-1">
                            <strong>Type</strong>
                            <span class=" tw__mr-auto badge bg-label-{{ ($recordData->type === 'income' ? 'success' : 'danger') }}">{{ (!empty($recordData->to_wallet_id) ? 'Transfer - ' : '').ucwords($recordData->type) }}</span>
                        </div>
                        {{-- Category --}}
                        <div class=" tw__grid tw__grid-flow-row tw__gap-1">
                            <strong>Category</strong>
                            <span>
                                @if ($recordData->category()->exists())
                                    <a href="{{ route('sys.category.index') }}">{{ ($recordData->category->parent()->exists() ? $recordData->category->parent->name.' - ' : '').$recordData->category->name }}</a>
                                @else
                                    <span>No Category</span>
                                @endif
                            </span>
                        </div>
                        {{-- Wallet --}}
                        <div class=" tw__grid tw__grid-flow-row tw__gap-1">
                            <strong>Wallet</strong>
                            <a href="{{ route('sys.wallet.list.show', $recordData->wallet->uuid) }}">{{ ($recordData->wallet->parent()->exists() ? $recordData->wallet->parent->name.' - ' : '').$recordData->wallet->name }}</a>
                        </div>
                        {{-- Wallet --}}
                        <div class=" tw__grid tw__grid-flow-row tw__gap-1">
                            <strong>To Wallet</strong>
                            @if (!empty($recordData->to_wallet_id))
                                <a href="{{ route('sys.wallet.list.show', $recordData->walletTransferTarget->uuid) }}">{{ ($recordData->walletTransferTarget->parent()->exists() ? $recordData->walletTransferTarget->parent->name.' - ' : '').$recordData->walletTransferTarget->name }}</a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                        {{-- Date --}}
                        <div class=" tw__grid tw__grid-flow-row tw__gap-1">
                            <strong>Date / Time</strong>
                            <span data-period="{{ $recordData->datetime }}">-</span>
                        </div>
                    </div>
                    <hr/>
                    <div class="">
                        <strong class=" tw__mb-1">Record Note</strong>
                        <div class=" tw__w-full tw__p-4 tw__rounded-lg tw__border-2 tw__border-dashed">
                            {{ $recordData->note ? $recordData->note : 'No description' }}
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class=" table border-top m-0">
                        <tbody>
                            <tr x-data="{toggle: false}">
                                <th>Base Amount</th>
                                <td data-orig="{{ formatRupiah($recordData->amount) }}" data-short="{{ formatRupiah($recordData->amount, 'Rp', true) }}" x-on:click="toggle = !toggle;$el.innerHTML = `${toggle ? $el.dataset.orig : $el.dataset.short}`">
                                    <span>{{ formatRupiah($recordData->amount, 'Rp', true) }}</span>
                                </td>
                            </tr>
                            <tr x-data="{toggle: false}">
                                <th>Extra Amount</th>
                                <td>
                                    <span class=" tw__block" data-orig="{{ formatRupiah($recordData->extra_amount) }}" data-short="{{ formatRupiah($recordData->extra_amount, 'Rp', true) }}" x-on:click="toggle = !toggle;$el.innerHTML = `${toggle ? $el.dataset.orig : $el.dataset.short}`">{{ formatRupiah($recordData->extra_amount, 'Rp', true) }}</span>
                                    @if ($recordData->extra_amount > 0)
                                        <small class="badge bg-secondary">{{ ucwords($recordData->extra_type) }}</small>
                                    @endif
                                </td>
                            </tr>
                            <tr x-data="{toggle: false}">
                                <th>Total</th>
                                <td data-orig="{{ formatRupiah($recordData->amount + $recordData->extra_amount) }}" data-short="{{ formatRupiah($recordData->amount + $recordData->extra_amount, 'Rp', true) }}" x-on:click="toggle = !toggle;$el.innerHTML = `${toggle ? $el.dataset.orig : $el.dataset.short}`">
                                    <strong>{{ formatRupiah($recordData->amount + $recordData->extra_amount, 'Rp', true) }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <div class=" tw__grid tw__grid-cols-1 md:tw__grid-cols-2 tw__gap-2">
                        <div class=" tw__grid tw__grid-flow-row tw__gap-1">
                            <strong>Tags</strong>
                            @if ($recordData->recordTags()->exists())
                                <span>{{ implode(', ', $recordData->recordTags->pluck('name')->toArray()) }}</span>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                        <div class=" tw__grid tw__grid-flow-row tw__gap-1">
                            <strong>Receipt</strong>
                            @if (!empty($recordData->receipt))
                                <a href="{{ asset($recordData->receipt) }}" class=" tw__flex tw__items-center tw__gap-2 tw__rounded-lg tw__py-2 tw__px-4 tw__border tw__mr-auto" data-fslightbox>
                                    <i class="bx bx-paperclip bx-rotate-90 tw__text-2xl"></i>
                                    <strong>Preview File</strong>
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top">
                    <small>
                        <strong>Note</strong>, record was made at <span data-period="{{ $recordData->created_at }}">-</span>. {!! $recordData->created_at != $recordData->updated_at ? ('Last updated at <span data-period="'.$recordData->updated_at.'">-</span>.') : '' !!}
                    </small>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-3 order-first order-lg-last tw__mb-4 lg:tw__mb-0">
            <div class="card lg:tw__sticky lg:tw__top-[6.5rem]">
                <div class="card-body tw__grid md:tw__inline-flex md:tw__self-start lg:tw__self-auto lg:tw__grid tw__grid-flow-row md:tw__grid-flow-col lg:tw__grid-flow-row tw__gap-4">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary tw__mr-0 md:tw__mr-auto lg:tw__mr-0">
                        <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-arrow-back'></i>Back</span>
                    </a>
                    <button type="button" class="btn btn-warning tw__mr-0 md:tw__mr-auto lg:tw__mr-0" data-uuid="{{ $recordData->uuid }}" x-on:click="$wire.emitTo('sys.component.record-modal', 'editAction', @this.get('recordUuid'))">
                        <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-edit'></i>Edit</span>
                    </button>
                    <button type="button" class="btn btn-danger tw__mr-0 md:tw__mr-auto lg:tw__mr-0" data-uuid="{{ $recordData->uuid }}" x-on:click="removeRecord('{{ $recordData->uuid }}')">
                        <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-trash'></i>Remove</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js_plugins')
    <script src="{{ mix('assets/js/format-record.js') }}"></script>
@endsection

@section('js_inline')
    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            refreshFsLightbox();

            window.dispatchEvent(new Event('fetchPeriodDate'));
            if(document.getElementById('modal-record')){
                document.getElementById('modal-record').addEventListener('hide.bs.modal', (e) => {
                    @this.emit('refreshComponent');

                    setTimeout(() => {
                        window.dispatchEvent(new Event('fetchPeriodDate'));
                    }, 1000);
                });
            }
        });

        // Fetch Period Date
        window.addEventListener('fetchPeriodDate', (e) => {
            let container = document.getElementById('record-detail');
            container.querySelectorAll('[data-period]').forEach((el) => {
                el.innerHTML = momentDateTime(el.dataset.period, 'DD MMM, YYYY / HH:mm', true);
            });
        });

        // Remove  Action
        function removeRecord(uuid){
            Swal.fire({
                title: 'Warning',
                icon: 'warning',
                text: `You'll perform remove action, this action cannot be undone and will affect your related Wallet Balance. If this data had related record, it'll also be deleted!`,
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: 'Remove',
                showLoaderOnConfirm: true,
                preConfirm: (request) => {
                    return @this.call('removeData', uuid).then((e) => {
                        Swal.fire({
                            'title': 'Action: Success',
                            'icon': 'success',
                            'text': 'Record data successfully deleted'
                        }).then((e) => {
                            location.href = "{{ route('sys.record.index') }}";
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        }
    </script>
@endsection