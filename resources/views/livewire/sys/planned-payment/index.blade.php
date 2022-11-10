@section('title', 'Planned Payment List')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span class="active">Planned Payment: List</span>
    </h4>
@endsection

<div wire:init="loadListData()">
    {{-- The Master doesn't talk, he acts. --}}

    {{-- Filter --}}
    <div class="card tw__mt-4"  wire:ignore>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-5 tw__mb-4 lg:tw__mb-0">
                    <div class="form-group">
                        <label>Sort by</label>
                        <div class="row">
                            <div class="col-12 col-lg-6 tw__mb-4 lg:tw__mb-0">
                                <select class="form-control" id="input_planned_payment-sort_key" name="sort_key" placeholder="Search for Sort Key" x-on:change="$wire.set('sortKey', $event.target.value)">
                                    <option value="">Search for Sort Key</option>
                                    <option value="name">Name</option>
                                    <option value="next_date">Period</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6">
                                <select class="form-control" id="input_planned_payment-sort_type" name="sort_type" aria-placeholder="Search for Sort Type" x-on:change="$wire.set('sortType', $event.target.value)">
                                    <option value="">Search for Sort Type</option>
                                    <option value="asc">Ascending</option>
                                    <option value="desc">Descending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="form-group">
                        <label>Search by Name</label>
                        <input type="text" class="form-control" placeholder="Search Planned Payment based on it's Name" wire:model.debounce.500ms="filterName">
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- List --}}
    <div class="card mt-4">
        <div class="card-body">
            <div class=" tw__mb-4">
                <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-plannedPayment">
                    <span class=" tw__flex tw__items-center tw__gap-2"><i class="bx bx-plus"></i>Add new</span>
                </a>
            </div>
            <div id="plannedPayment-container">
                @for ($i = 0; $i < 3; $i++)
                    <div class=" tw__flex tw__flex-col tw__mb-4 last:tw__mb-0">
                        <div class="list-wrapper">
                            <div class=" tw__bg-gray-300 tw__rounded-lg tw__w-full content-list tw__p-4 tw__animate-pulse tw__self-center">
                                <div class=" tw__flex tw__justify-between">
                                    <div class="tw__flex tw__gap-4">
                                        <span class=" tw__bg-gray-400 tw__rounded tw__h-6 tw__w-24"></span>
                                        <span class=" tw__bg-gray-400 tw__rounded tw__h-6 tw__w-12"></span>
                                    </div>
                                    <div class=" tw__flex tw__gap-4">
                                        <span class=" tw__bg-gray-400 tw__rounded tw__h-6 tw__w-16"></span>
                                        <span class=" tw__bg-gray-400 tw__rounded tw__h-6 tw__w-4"></span>
                                    </div>
                                </div>
                                <div class=" tw__flex tw__gap-4 tw__mt-2 tw__items-center">
                                    <span class=" tw__bg-gray-400 tw__w-11 tw__h-11 tw__rounded-full"></span>
                                    <div class=" tw__flex tw__flex-col tw__gap-2">
                                        <span class=" tw__bg-gray-400 tw__rounded tw__w-20 tw__h-5"></span>
                                        <span class=" tw__bg-gray-400 tw__rounded tw__w-14 tw__h-3"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div class="card-footer tw__pt-0">
            <div class=" tw__flex tw__items-center tw__justify-between">
                <button wire:loading.remove wire:target="loadMore" type="button" class="btn btn-primary disabled:tw__cursor-not-allowed" {{ $paginate->hasMorePages() ? '' : 'disabled' }} wire:click="loadMore">
                    <span>Load more</span>
                </button>
                <button wire:loading.block wire:target="loadMore" type="button" class="btn btn-primary disabled:tw__cursor-not-allowed" disabled>
                    <span class=" tw__flex tw__items-center tw__gap-2">
                        <i class="bx bx-loader-alt bx-spin"></i>
                        <span>Loading</span>
                    </span>
                </button>
                <span>Showing {{ $paginate->count() }} of {{ $paginate->total() }} entries</span>
            </div>
        </div>
    </div>
</div>

@section('js_inline')
    <script>
        // Choices
        let sortKeyChoice = null;
        if(document.getElementById('input_planned_payment-sort_key')){
            const sortKeyEl = document.getElementById('input_planned_payment-sort_key');
            sortKeyChoice = new Choices(sortKeyEl, {
                allowHTML: true,
                removeItemButton: true,
                searchPlaceholderValue: "Search for Sort Key",
                placeholder: true,
                placeholderValue: 'Search for Sort Key',
                shouldSort: false
            });
        }
        let sortTypeChoice = null;
        if(document.getElementById('input_planned_payment-sort_type')){
            const sortTypeEl = document.getElementById('input_planned_payment-sort_type');
            sortTypeChoice = new Choices(sortTypeEl, {
                allowHTML: true,
                removeItemButton: true,
                searchPlaceholderValue: "Search for Sort Type",
                placeholder: true,
                placeholderValue: 'Search for Sort Type',
                shouldSort: false
            });
        }

        document.addEventListener('DOMContentLoaded', (e) => {
            window.dispatchEvent(new Event('plannedPaymentLoadData'));
        });

        if(document.getElementById('modal-plannedPayment')){
            document.getElementById('modal-plannedPayment').addEventListener('hide.bs.modal', (e) => {
                window.dispatchEvent(new Event('plannedPaymentLoadData'));
            });
        }
        if(document.getElementById('modal-plannedPaymentRecord')){
            document.getElementById('modal-plannedPaymentRecord').addEventListener('hide.bs.modal', (e) => {
                window.dispatchEvent(new Event('plannedPaymentLoadData'));
            });
        }

        // Listen to Load Event
        window.addEventListener('plannedPaymentLoadData', (e) => {
            if(document.getElementById('plannedPayment-container')){
                document.getElementById('plannedPayment-container').innerHTML = ``;
                generateList();
            }
        });

        // Generate Planned Payment List
        const generateList = () => {
            // Get data from Component
            let data = @this.get('dataPlannedPayment');
            // console.log(data);
            // Define container
            let paneEl = document.getElementById('plannedPayment-container');
            let plannedContent = null;
            if(data.length > 0){
                // Empty Container - Skeleton
                paneEl.innerHTML = ``;

                // Generate Wrapper
                if(!paneEl.querySelector(`.content-wrapper`)){
                    plannedContent = document.createElement('div');
                    plannedContent.classList.add('content-wrapper');
                    plannedContent.classList.add('tw__flex', 'tw__gap-4');
                    paneEl.appendChild(plannedContent);
                } else {
                    plannedContent = paneEl.querySelector('.content-wrapper');
                }

                // Loop through data
                let lastPeriod = null;
                data.forEach((val, index) => {
                    let currentMonthPeriod = moment(val.next_date).format('YYYY-MM');
                    if(lastPeriod !== null && lastPeriod !== currentMonthPeriod){
                        let divider = document.createElement('div');
                        divider.classList.add('divider');
                        plannedContent.appendChild(divider);
                        divider.innerHTML = `
                            <div class="divider-text">
                                <span class=" tw__flex tw__items-center tw__gap-1">
                                    <i class='bx bx-time'></i>
                                </span>
                            </div>
                        `;

                        lastPeriod = currentMonthPeriod;
                    } else if(lastPeriod !== currentMonthPeriod){
                        lastPeriod = currentMonthPeriod;
                    }

                    let listContainer = document.createElement('div');
                    listContainer.classList.add('list-wrapper', 'tw__flex', 'tw__gap-4');
                    plannedContent.appendChild(listContainer);

                    // Generate Action button
                    let action = [];
                    action.push(`
                        <li>
                            <a class="dropdown-item tw__text-yellow-400" href="javascript:void(0)" data-uuid="${val.uuid}" onclick="Livewire.emitTo('sys.component.planned-payment-modal', 'editAction', '${val.uuid}')">
                                <span class=" tw__flex tw__items-center"><i class="bx bx-edit tw__mr-2"></i>Edit</span>
                            </a>
                        </li>
                    `);
                    action.push(`
                        <li>
                            <a class="dropdown-item tw__text-blue-400" href="{{ route('sys.planned-payment.index') }}/${val.uuid}" data-uuid="${val.uuid}">
                                <span class=" tw__flex tw__items-center"><i class="bx bx-show tw__mr-2"></i>Detail</span>
                            </a>
                        </li>
                    `);
                    // Handle Action wrapper
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

                    /**
                     * Generate List Format
                     * */
                    // Wallet
                    let walletName = `${val.wallet.parent ? `${val.wallet.parent.name} - ` : ''}${val.wallet.name}`;
                    let toWalletName = val.to_wallet_id ? `${val.wallet_transfer_target.parent ? `${val.wallet_transfer_target.parent.name} - ` : ''}${val.wallet_transfer_target.name}` : null;
                    // Extra Information
                    let smallInformation = [];
                    if(val.category){
                        smallInformation.push(`<span><small class="tw__text-[#293240] tw__flex tw__items-center tw__gap-1"><i class="bx bxs-category"></i>${val.category.parent_id ? `${val.category.parent.name} - ` : ''}${val.category.name}</small></span>`);
                    }
                    if(val.receipt !== null){
                        smallInformation.push(`<span><small class="tw__text-[#293240] tw__flex tw__items-center tw__gap-1"><i class="bx bx-paperclip bx-rotate-90"></i>Receipt</small></span>`);
                    }
                    if(val.note !== null && val.note !== ''){
                        smallInformation.push(`<span><small class="tw__text-[#293240] tw__flex tw__items-center tw__gap-1"><i class="bx bx-paragraph"></i>Note</small></span>`);
                    }
                    if(val.planned_payment_tags !== null && val.planned_payment_tags !== undefined && val.planned_payment_tags.length > 0){
                        smallInformation.push(`<span><small class="tw__text-[#293240] tw__flex tw__items-center tw__gap-1"><i class="bx bxs-tag-alt"></i>Tags</small></span>`);
                    }
                    // Alert
                    let alert = '';
                    let current = moment().format('YYYY-MM-DD');
                    let nextDate = moment(val.next_date).format('YYYY-MM-DD');
                    if(moment(current).diff(moment(nextDate)) > 0){
                        // console.log(current);
                        // console.log(nextDate);
                        // console.log(moment(current).diff(moment(nextDate)));
                        alert = `
                            <small class="tw__bg-red-400 tw__bg-opacity-75 tw__px-2 tw__py-1 tw__rounded tw__mb-2 tw__text-white tw__inline-block"><span class="tw__flex tw__items-center tw__gap-2">
                                <i class='bx bx-info-circle'></i>Overdue</span>
                            </small>
                        `;
                    } else if(moment(current).diff(moment(nextDate)) === 0){
                        alert = `
                            <small class="tw__bg-blue-400 tw__bg-opacity-75 tw__px-2 tw__py-1 tw__rounded tw__mb-2 tw__text-white tw__inline-block"><span class="tw__flex tw__items-center tw__gap-2">
                                <i class='bx bx-info-circle'></i>Today</span>
                            </small>
                        `;
                    }

                    // Content
                    listContainer.innerHTML = `
                        <div class=" tw__bg-gray-50 hover:tw__bg-gray-100 tw__transition tw__transition-all tw__rounded-lg tw__w-full content-list tw__p-4">
                            <div class="tw__flex tw__items-center tw__leading-none tw__gap-1">
                                <small class="tw__flex tw__flex-col md:tw__flex-row md:tw__items-center tw__gap-1">
                                    <span class="tw__text-gray-500 tw__flex tw__items-center tw__gap-2"><i class="bx bx-time"></i>${momentDateTime(val.next_date, 'DD MMM, YYYY')}</span>
                                    <span class="tw__hidden md:tw__block"><i class="bi bi-dot"></i></span>
                                    <span class="tw__flex tw__items-center tw__leading-none tw__gap-1 tw__flex-wrap tw__text-[#293240]"><span class=""><i class="bx bx-wallet-alt"></i></span>${walletName} ${toWalletName !== null ? `<small><i class="bx bx-caret-right"></i></small>${toWalletName}` : ''}</span>
                                </small>

                                <div class="tw__ml-auto tw__flex itw__items-center tw__gap-2">
                                    <span class="${val.type === 'income' ? 'tw__text-green-600' : val.type === 'transfer' ? 'tw__text-gray-600' : 'tw__text-red-600'} tw__text-base tw__hidden md:tw__block">${val.type !== 'income' ? `(${formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))})` : formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))}</span>
                                    ${actionBtn}
                                </div>
                            </div>
                            <div class="tw__my-2 tw__mt-4 lg:tw__mt-2">
                                <div class="md:tw__hidden">
                                    ${alert}
                                </div>
                                <div class="tw__flex tw__items-center tw__gap-4">
                                    <div class="tw__min-h-[35px] tw__min-w-[35px] tw__rounded-full tw__text-white ${val.to_wallet_id ? 'tw__bg-gray-400' : (val.type === 'expense' ? 'tw__bg-red-400' : 'tw__bg-green-400')} tw__bg-opacity-75 tw__flex tw__items-center tw__justify-center">
                                        <i class="bx bx${val.to_wallet_id ? 's-arrow-to-bottom' : (val.type === 'expense' ? 's-arrow-from-bottom' : '-transfer bx-rotate-90')}"></i>
                                    </div>
                                    <div class="tw__flex tw__items-center tw__gap-4 tw__w-full">
                                        <div class="tw__mr-auto">
                                            <p class="tw__text-base tw__text-semibold tw__mb-0 tw__text-[#293240]">${val.name}</p>
                                            <small class="tw__italic tw__text-gray-500">
                                                ${ucwords(val.type)}
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
                                    <span>${val.note ? val.note : 'No description'}</span>
                                </small>
                            </div>

                            <div class="md:tw__hidden tw__mt-4">
                                <span class="${val.type === 'income' ? 'tw__text-green-600' : (val.type === 'transfer' ? 'tw__text-gray-600' : 'tw__text-red-600')} tw__text-base">${val.type === 'expense' ? `(${formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))})` : formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))}</span>
                            </div>
                            ${smallInformation.length > 0 ? `<div class=" tw__leading-none tw__flex tw__items-center tw__gap-2 tw__flex-wrap tw__mt-2 lg:tw__mt-0">${smallInformation.join('<i class="bi bi-slash"></i>')}</div>` : ''}
                        </div>
                    `;
                });
            } else {
                // Data is empty
                plannedContent = document.createElement('div');
                plannedContent.classList.add('alert', 'alert-primary', 'tw__mb-0');
                plannedContent.setAttribute('role', 'alert');
                plannedContent.innerHTML = `
                    <div class=" tw__flex tw__items-center">
                        <i class="bx bx-error tw__mr-2"></i>
                        <div class="tw__block tw__font-bold tw__uppercase">
                            Attention!
                        </div>
                    </div>
                    <span class="tw__block tw__italic">No data found</span>
                `;

                paneEl.appendChild(plannedContent);
            }
        };
    </script>
@endsection