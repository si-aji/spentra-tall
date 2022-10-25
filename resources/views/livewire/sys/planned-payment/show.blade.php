@section('title', 'Planned Payment: Detail')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>
            <a href="{{ route('sys.planned-payment.index') }}">Planned Payment: List</a>
        </span>
        <span class="active">Detail</span>
    </h4>
@endsection

<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-arrow-back'></i>Back</span>
        </a>
        <button type="button" class="btn btn-warning" data-uuid="{{ $plannedPaymentData->uuid }}" x-on:click="$wire.emitTo('sys.component.planned-payment-modal', 'editAction', @this.get('plannedPaymentUuid'))">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-edit'></i>Edit</span>
        </button>
    </div>

    <div class="card tw__mt-4" id="plannedPayment-detail">
        <div class="card-body">
            <table class="table table-hover">
                <tr>
                    <th>Name</th>
                    <td>{{ $plannedPaymentData->name }}</td>
                </tr>
                <tr>
                    <th>Type</th>
                    <td>
                        <span class="badge bg-label-{{ $plannedPaymentData->type === 'transfer' ? 'secondary' : ($plannedPaymentData->type === 'income' ? 'success' : 'danger') }}">{{ ucwords($plannedPaymentData->type) }}</span>
                    </td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>{{ $plannedPaymentData->category()->exists() ? ($plannedPaymentData->category->parent()->exists() ? $plannedPaymentData->category->parent->name.' - ' : '').$plannedPaymentData->category->name : '-' }}</td>
                </tr>
                <tr>
                    <th>{{ $plannedPaymentData->type === 'transfer' ? 'From' : 'Wallet' }}</th>
                    <td>
                        {{ $plannedPaymentData->wallet()->exists() ? ($plannedPaymentData->wallet->parent()->exists() ? $plannedPaymentData->wallet->parent->name.' - ' : '').$plannedPaymentData->wallet->name : '-' }}
                    </td>
                </tr>
                @if ($plannedPaymentData->type === 'transfer')
                    <tr>
                        <th>To</th>
                        <td>
                            {{ $plannedPaymentData->walletTransferTarget()->exists() ? ($plannedPaymentData->walletTransferTarget->parent()->exists() ? $plannedPaymentData->walletTransferTarget->parent->name.' - ' : '').$plannedPaymentData->walletTransferTarget->name : '-' }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <th>{{ empty($plannedPaymentData->to_wallet_id) ? 'Base ' : '' }}Amount</th>
                    <td>{{ formatRupiah($plannedPaymentData->amount) }}</td>
                </tr>
                @if (empty($plannedPaymentData->to_wallet_id))
                    <tr>
                        <th>Extra Amount</th>
                        <td>
                            <span class=" tw__block">{{ $plannedPaymentData->extra_type === 'amount' ? formatRupiah($plannedPaymentData->extra_amount) : $plannedPaymentData->extra_percentage.'%' }}</span>
                            <span class="badge bg-label-secondary">{{ ucwords($plannedPaymentData->extra_type) }}</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Final Amount</th>
                        <td>{{ formatRupiah($plannedPaymentData->amount + $plannedPaymentData->extra_amount) }}</td>
                    </tr>
                @endif
                <tr>
                    <th class=" tw__border-b-0">Note</th>
                    <td class=" tw__border-b-0">{{ $plannedPaymentData->note ?? '-' }}</td>
                </tr>
            </table>

            <div class="divider">
                <div class="divider-text"><i class='bx bx-time'></i></div>
            </div>

            <table class="table table-hover">
                <tr>
                    <th>Start</th>
                    <td data-period="{{ $plannedPaymentData->start_date }}">-</td>
                </tr>
                <tr>
                    <th>Next</th>
                    <td data-period="{{ $plannedPaymentData->next_date }}">-</td>
                </tr>
            </table>

            <div class="card tw__mt-4">
                <div class="card-header">
                    <h5 class="card-title">Record: List</h5>
                </div>
                <div class="card-body">
                    <div class="" id="plannedPayment-recordList">
                        @for ($i = 0; $i < 3; $i++)
                            <div class=" tw__flex tw__flex-col">
                                <div class="list-wrapper tw__flex tw__gap-2 tw__mb-4 last:tw__mb-0">
                                    <div class=" tw__p-4 tw__text-center">
                                        <div class="tw__sticky tw__top-24 md:tw__top-40 tw__flex tw__items-center tw__flex-col">
                                            <span class="tw__font-semibold tw__bg-gray-300 tw__animate-pulse tw__h-4 tw__w-8 tw__block tw__rounded tw__mr-0 tw__mb-2"></span>
                                            <div class=" tw__min-h-[40px] tw__min-w-[40px] tw__bg-gray-300 tw__bg-opacity-60 tw__rounded-full tw__flex tw__leading-none tw__items-center tw__justify-center tw__align-middle tw__animate-pulse">
                                                <p class="tw__mb-0 tw__font-bold tw__text-xl tw__text-white"></p>
                                            </div>
                                            <span class="tw__font-semibold tw__bg-gray-300 tw__animate-pulse tw__h-3 tw__w-12 tw__block tw__rounded tw__mr-0 tw__mt-1"></span>
                                        </div>
                                    </div>
                                    <div class=" tw__bg-gray-300 tw__rounded-lg tw__w-full content-list tw__p-4 tw__h-20 tw__animate-pulse tw__self-center">
                                        
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="card-footer tw__pt-0">
                    <div class=" tw__flex tw__items-center tw__justify-between">
                        <button type="button" class="btn btn-primary disabled:tw__cursor-not-allowed" {{ $paginate->hasMorePages() ? '' : 'disabled' }} x-on:click="@this.loadMore()">Load more</button>
                        <span>Showing {{ $paginate->count() }} of {{ $paginate->total() }} entries</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js_inline')
    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            document.dispatchEvent(new Event('plannedPaymentShowLoadData'));
            
            let container = document.getElementById('plannedPayment-detail');
            container.querySelectorAll('[data-period]').forEach((el) => {
                el.innerHTML = moment(el.dataset.period).format('DD MMM, YYYY');
            });
        });

        document.addEventListener('plannedPaymentShowLoadData', (e) => {
            generateList();
        });

        const generateList = () => {
            let paneEl = document.getElementById('plannedPayment-recordList');
            let plannedPaymentRecordList = null;
            let data = @this.get('plannedPaymentRecordData');
            let origData = @this.get('plannedPaymentData');

            paneEl.innerHTML = '';
            if(data.length > 0){
                if(!paneEl.querySelector(`.content-wrapper`)){
                    plannedPaymentRecordList = document.createElement('div');
                    plannedPaymentRecordList.classList.add('content-wrapper');
                    plannedPaymentRecordList.classList.add('tw__flex', 'tw__gap-4');
                    paneEl.appendChild(plannedPaymentRecordList);
                } else {
                    plannedPaymentRecordList = paneEl.querySelector('.content-wrapper');
                }

                let prevDate = null;
                data.forEach((val, index) => {
                    let date = val.period;
                    let original = val.period;
                    let plannedDate = val.period;

                    if(plannedDate != prevDate){
                        let listContainer = document.createElement('div');
                        listContainer.classList.add('list-wrapper', 'tw__flex', 'tw__gap-4', 'tw__mb-4', 'last:tw__mb-0');
                        listContainer.innerHTML = `
                            <div class=" tw__p-4 tw__text-center" wire:id="${index}-${val.uuid}">
                                <!-- This is for date -->
                                <div class="tw__sticky lg:tw__top-24 tw__top-40">
                                    <span class="tw__font-semibold">${moment(val.period).format('ddd')}</span>
                                    <div class=" tw__min-h-[40px] tw__min-w-[40px] tw__bg-[#7166ef] tw__bg-opacity-60 tw__rounded-full tw__flex tw__leading-none tw__items-center tw__justify-center tw__align-middle">
                                        <p class="tw__mb-0 tw__font-bold tw__text-xl tw__text-white">${moment(val.period).format('DD')}</p>
                                    </div>
                                    <small>${moment(val.period).format('MMM')} '${moment(val.period).format('YY')}</small>
                                </div>
                            </div>
                            <div class=" tw__bg-gray-50 tw__rounded-lg tw__w-full content-list tw__p-4" data-date="${moment(val.period).format('YYYY-MM-DD')}">
                                <!-- List Goes Here -->
                            </div>
                        `;
                        // Date not same with previous, generate new list
                        plannedPaymentRecordList.appendChild(listContainer);
                        prevDate = plannedDate;
                    }

                    let contentContainer = plannedPaymentRecordList.querySelector(`.content-list[data-date="${moment(val.period).format('YYYY-MM-DD')}"]`);
                    if(contentContainer){
                        let item = document.createElement('div');
                        item.classList.add('tw__border-b', 'last:tw__border-b-0', 'tw__py-4', 'first:tw__pt-0', 'last:tw__pb-0');
                        // Wallet
                        let walletName = `${val.wallet.parent ? `${val.wallet.parent.name} - ` : ''}${val.wallet.name}`;
                        let toWalletName = val.to_wallet_id ? `${val.wallet_transfer_target.parent ? `${val.wallet_transfer_target.parent.name} - ` : ''}${val.wallet_transfer_target.name}` : null;
                        // Note
                        let note = val.note;
                        if(val.record){
                            note = val.record.note;
                        }
                        // Append Action
                        let action = [];
                        if(val.status === 'pending'){
                            action.push(`
                                <li>
                                    <a class="dropdown-item tw__text-green-400" href="javascript:void(0)" onclick="Livewire.emitTo('sys.component.planned-payment-record-modal', 'editAction', '${val.uuid}')">
                                        <span class=" tw__flex tw__items-center"><i class="bx bx-check tw__mr-2"></i>Approve</span>
                                    </a>
                                </li>
                            `);
                            action.push(`
                                <li>
                                    <a class="dropdown-item tw__text-red-400" href="javascript:void(0)" onclick="skipRecord('${val.uuid}')">
                                        <span class=" tw__flex tw__items-center"><i class="bx bx-x tw__mr-2"></i>Skip</span>
                                    </a>
                                </li>
                            `);
                        }
                        // Handle Action
                        let actionBtn = '';
                        if(action.length > 0){
                            actionBtn = `
                                <div class="dropdown tw__leading-none tw__flex">
                                    <button class="dropdown-toggle arrow-none" type="button" data-bs-auto-close="outside" id="record_dropdown-${index}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="record_dropdown-${index}">
                                        ${action.join('')}
                                    </ul>
                                </div>
                            `;
                        }
                        // Append Small Information
                        let smallInformation = [];
                        if(val.record && val.record.category){
                            smallInformation.push(`<span><small class="tw__text-[#293240]"><i class="bx bxs-category tw__mr-1"></i>${val.record.category.parent_id ? `${val.record.category.parent.name} - ` : ''}${val.record.category.name}</small></span>`);
                        } else if(val.planned_payment && val.planned_payment.category){
                            smallInformation.push(`<span><small class="tw__text-[#293240]"><i class="bx bxs-category tw__mr-1"></i>${val.planned_payment.category.parent_id ? `${val.planned_payment.category.parent.name} - ` : ''}${val.planned_payment.category.name}</small></span>`);
                        }
                        if(val.record && val.record.receipt !== null){
                            smallInformation.push(`<span><small class="tw__text-[#293240]"><i class="bx bx-paperclip bx-rotate-90 tw__mr-1"></i>Receipt</small></span>`);
                        }
                        if(note !== null){
                            smallInformation.push(`<span><small class="tw__text-[#293240]"><i class="bx bx-paragraph tw__mr-1"></i>Note</small></span>`);
                        }
                        // Alert
                        let alert = '';
                        if(val.status !== 'pending'){
                            alert = `
                                <small class="tw__bg-${val.status === 'skip' ? 'red' : 'green'}-400 tw__bg-opacity-75 tw__px-2 tw__py-1 tw__rounded tw__mb-2 tw__text-white tw__inline-block"><span class="tw__flex tw__items-center tw__gap-2">
                                    <i class='bx bx-info-circle'></i>${val.status === 'skip' ? 'Skipped' : 'Approved'}</span>
                                </small>
                            `;
                        }

                        // Append Item
                        item.innerHTML = `
                            <div class="tw__flex tw__items-center tw__leading-none tw__gap-1">
                                <small class="tw__flex tw__flex-col md:tw__flex-row md:tw__items-center tw__gap-1">
                                    <span class="tw__text-gray-500 tw__flex tw__items-center tw__gap-2"><i class="bx bx-time"></i>${val.confirmed_at ? momentDateTime(val.confirmed_at, 'DD MMM, YYYY / HH:mm', true) : 'Unconfirmed'}</span>
                                    <span class="tw__hidden md:tw__block"><i class="bi bi-dot"></i></span>
                                    <span class="tw__flex tw__items-center tw__leading-none tw__gap-1 tw__flex-wrap tw__text-[#293240]"><span class=""><i class="bx bx-wallet-alt"></i></span>${walletName} ${toWalletName !== null ? `<small><i class="bx bx-caret-${val.type === 'income' ? 'left' : 'right'} "></i></small>${toWalletName}` : ''}</span>
                                </small>

                                <div class="tw__ml-auto tw__flex itw__items-center tw__gap-2">
                                    <span class="${val.type === 'income' ? 'tw__text-green-600' : 'tw__text-red-600'} tw__text-base tw__hidden md:tw__block">${val.type === 'expense' ? `(${formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))})` : formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))}</span>
                                
                                    ${actionBtn}
                                </div>
                            </div>

                            <div class="tw__my-2 tw__mt-4 lg:tw__mt-2">
                                <div class="md:tw__hidden">
                                    ${alert}
                                </div>
                                <div class="tw__flex tw__items-center tw__gap-4">
                                    <div class="tw__min-h-[35px] tw__min-w-[35px] tw__rounded-full tw__text-white ${val.to_wallet_id ? 'tw__bg-gray-400' : (val.type === 'expense' ? 'tw__bg-red-400' : 'tw__bg-green-400')} tw__bg-opacity-75 tw__flex tw__items-center tw__justify-center">
                                        <i class="bx bxs-${val.to_wallet_id ? 'arrow-to-bottom' : (val.type === 'expense' ? 'arrow-from-bottom' : 'arrow-from-bottom')}"></i>
                                    </div>
                                    <div class="tw__flex tw__items-center tw__gap-4 tw__w-full">
                                        <div class="tw__mr-auto">
                                            <p class="tw__text-base tw__text-semibold tw__mb-0 tw__text-[#293240]">${val.to_wallet_id ? 'Transfer - ' : ''}${ucwords(val.type)}</p>
                                            <small class="tw__italic tw__text-gray-500 tw__hidden lg:tw__inline">
                                                <i class='bx bx-align-left'></i>
                                                <span>${note ? note : 'No description'}</span>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="tw__hidden md:tw__block">
                                        ${alert}
                                    </div>
                                </div>
                            </div>
                            <div class=" lg:tw__hidden">
                                <small class="tw__italic tw__text-gray-500">
                                    <i class='bx bx-align-left'></i>
                                    <span>${note ? note : 'No description'}</span>
                                </small>
                            </div>

                            <div class="md:tw__hidden tw__mt-4">
                                <span class="${val.type === 'income' ? 'tw__text-green-600' : 'tw__text-red-600'} tw__text-base">${val.type === 'expense' ? `(${formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))})` : formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))}</span>
                            </div>
                            ${smallInformation.length > 0 ? `<div class=" tw__leading-none tw__flex tw__items-center tw__gap-2 tw__flex-wrap tw__mt-2 lg:tw__mt-0">${smallInformation.join('<i class="bi bi-slash"></i>')}</div>` : ''}
                        `;
                        contentContainer.appendChild(item);
                    }
                });
            } else {
                // Data is empty
                plannedPaymentRecordList = document.createElement('div');
                plannedPaymentRecordList.classList.add('alert', 'alert-primary', 'tw__mb-0');
                plannedPaymentRecordList.setAttribute('role', 'alert');
                plannedPaymentRecordList.innerHTML = `
                    <div class=" tw__flex tw__items-center">
                        <i class="bx bx-error tw__mr-2"></i>
                        <div class="tw__block tw__font-bold tw__uppercase">
                            Attention!
                        </div>
                    </div>
                    <span class="tw__block tw__italic">No data found</span>
                `;

                paneEl.appendChild(plannedPaymentRecordList);
            }
        };

        function skipRecord(uuid){
            Swal.fire({
                title: 'Warning',
                icon: 'warning',
                text: `You'll skip current period. This action cannot be undone, proceed with this action!`,
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: 'Yes, do it!',
                showLoaderOnConfirm: true,
                preConfirm: (request) => {
                    return @this.call('skipPeriod', uuid).then((e) => {
                        Swal.fire({
                            'title': 'Action: Success',
                            'icon': 'success',
                            'text': 'Record period successfully skipped'
                        }).then((e) => {
                            // Livewire.emitTo('sys.planned-payment.show', 'refreshComponent');
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        }
    </script>
@endsection