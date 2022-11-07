@section('title', 'Wallet Share')

<div class=" tw__min-h-screen tw__min-w-full tw__flex tw__items-center tw__my-4 tw__py-4">
    {{-- The whole world belongs to you. --}}
    <div class="container-xxl">
        <div class="row tw__justify-center">
            <div class="col-12 col-lg-10">
                <div class="card">
                    <div class="card-body tw__p-0">
                        <div class=" tw__p-4">
                            {{-- Alert --}}
                            <div class="alert bg-primary tw__text-white" role="alert">
                                <div class=" tw__flex tw__items-center tw__gap-1">
                                    <i class='bx bx-info-circle'></i>
                                    <div class="tw__block tw__font-bold tw__uppercase">
                                        Attention - Wallet List!
                                    </div>
                                </div>
                                <span class="tw__block">You can <strong>click/toggle</strong> on <strong>related wallet</strong> to know specific record on related wallet</span>
                            </div>

                            {{-- Wallet Filter --}}
                            <ul class="list-group" id="wallet-list" wire:ignore>
                                @foreach ($shareData->walletShareDetail as $key => $wallet)
                                    <li class="list-group-item" data-uuid="{{ $wallet->uuid }}" wire:click="monthChanged">
                                        <span class=" tw__flex tw__flex-col lg:tw__flex-row lg:tw__items-center lg:tw__justify-between">
                                            <span>{{ ($wallet->parent()->exists() ? $wallet->parent->name.' - ' : '').$wallet->name }}</span>
                                            <small class=" text-muted">{{ formatRupiah($wallet->getBalance()) }}</small>
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class=" tw__px-4">
                            <div class="row">
                                <div class="col-12 col-lg-2">
                                    <div wire:ignore>
                                        <select class="form-control" id="filter-year" placeholder="Search for Year Filter">
                                            @for ($i = date("Y-01-01"); $i >= date("Y-01-01", strtotime($shareData->user->getFirstYearRecord().'-01-01')); $i = date("Y-01-01", strtotime($i.' -1 years')))
                                                <option value="{{ date("Y", strtotime($i)) }}" {{ $filterYear == date("Y", strtotime($i)) ? 'selected' : '' }}>{{ date("Y", strtotime($i)) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-10 tw__flex tw__items-center lg:tw__text-right lg:tw__justify-end">
                                    <span>Total Balance, <strong>{{ formatRupiah((new \App\Models\WalletGroup)->getBalance($selectedWallet)) }}</strong></span>
                                </div>
                            </div>
                        </div>
                        {{-- Record List --}}
                        <div class=" tw__mt-4">
                            <nav>
                                <div class=" tw__w-full tw__flex tw__overflow-x-auto tw__pb-4">
                                    <div class=" nav nav-tabs tw__flex-nowrap tw__flex-row-reverse md:tw__flex-row md:tw__min-w-full" id="monthly-key" role="tablist">
                                        @for ($i = date('Y-01-01', strtotime($filterYear.'-01-01')); $i <= date('Y-m-01', strtotime($filterYear."-".($filterYear !== date("Y") ? '12' : date("m"))."-01")); $i = date("Y-m-01", strtotime($i.' +1 months')))
                                            <button type="button" class="tabbed-month nav-link {{ date("Y-m-01", strtotime($filterMonth)) === date("Y-m-01", strtotime($i)) ? 'active' : '' }}" data-date="{{ date("Y-m-01", strtotime($i)) }}" data-bs-toggle="tab" role="tab" wire:click="monthChanged">{{ date('M', strtotime($i)) }}</button>
                                        @endfor
                                    </div>
                                </div>
                            </nav>

                            <div wire:loading.delay wire:target="monthChanged">
                                @for ($i = 0; $i < 3; $i++)
                                    <div class=" tw__px-4 tw__flex tw__flex-col">
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

                            <div wire:loading.remove wire:target="monthChanged" class=" tw__px-4 tw__pb-4" id="record-container">
                                <div>
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
                        </div>
                    </div>
                    <div class="card-footer tw__pt-0 tw__p-4">
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
        </div>
    </div>
</div>

@section('js_plugins')
    <script src="{{ mix('assets/js/format-record.js') }}"></script>
@endsection

@section('js_inline')
    <script>
        let recordFilterYearChoice = null;

        document.addEventListener('DOMContentLoaded', (e) => {
            window.dispatchEvent(new Event('recordLoadData'));

            if(document.getElementById('filter-year')){
                const filterYearEl = document.getElementById('filter-year');
                recordFilterYearChoice = new Choices(filterYearEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Year Filter",
                    placeholder: true,
                    placeholderValue: 'Search for Year Filter',
                    shouldSort: false,
                    itemSelectText: '',
                });
                filterYearEl.addEventListener('change', (e) => {
                    if(e.target.value == ''){
                        recordFilterYearChoice.setChoiceByValue(moment().format('YYYY'));
                    }

                    let currentMonth = moment().format('MM');
                    if(moment(e.target.value).format('YYYY') < moment().format('YYYY')){
                        currentMonth = moment('2022-12-01').format('MM');
                    }
                    @this.set('filterYear', e.target.value);
                    @this.set('filterMonth', `${e.target.value}-${currentMonth}-01`);
                });
            }

            // Wallet Filter
            if(document.getElementById('wallet-list') && document.getElementById('wallet-list').querySelectorAll('.list-group-item').length > 0){
                document.getElementById('wallet-list').querySelectorAll('.list-group-item').forEach((el) => {
                    el.addEventListener('click', (e) => {
                        e.target.closest('.list-group-item').classList.toggle('active');

                        let selected = [...document.getElementById('wallet-list').querySelectorAll('.list-group-item.active')].map((e) => {
                            return e.dataset.uuid;
                        });
                        @this.set('filterShare', selected);
                    });
                });
            }

            // Monthly Tab
            if(document.getElementById('monthly-key')){
                let tabTriggerEl = document.querySelectorAll('[data-bs-toggle="tab"]');
                tabTriggerEl.forEach((el) => {
                    var tab = bootstrap.Tab.getOrCreateInstance(el);
                    el.addEventListener('show.bs.tab', (e) => {
                        @this.set('filterMonth', e.target.dataset.date);
                    });
                });
            }
        });
        window.addEventListener('recordLoadData', (e) => {
            generateList();
        });

        const generateList = () => {
            if(document.getElementById('record-container')){
                document.getElementById('record-container').innerHTML = ``;
            }

            let data = @this.get('recordData');
            let paneEl = document.getElementById('record-container');
            console.log(data);
            if(data.length > 0){
                if(!paneEl.querySelector(`.content-wrapper`)){
                    recordContent = document.createElement('div');
                    recordContent.classList.add('content-wrapper');
                    recordContent.classList.add('tw__flex', 'tw__gap-4');
                    paneEl.appendChild(recordContent);
                } else {
                    recordContent = paneEl.querySelector('.content-wrapper');
                }

                let prevDate = null;
                data.forEach((val, index) => {
                    let date = val.datetime;
                    let original = val.datetime;
                    let recordDate = momentDateTime(val.datetime, 'YYYY-MM-DD');

                    if(recordDate != prevDate){
                        let listContainer = document.createElement('div');
                        listContainer.classList.add('list-wrapper', 'tw__flex', 'tw__gap-4', 'tw__mb-4', 'last:tw__mb-0');
                        listContainer.innerHTML = recordContainerFormat(val, index);
                        // Date not same with previous, generate new list
                        recordContent.appendChild(listContainer);
                        prevDate = recordDate;
                    }

                    // Append Record Item
                    let contentContainer = recordContent.querySelector(`.content-list[data-date="${momentDateTime(val.datetime, 'YYYY-MM-DD')}"]`);
                    if(contentContainer){
                        // console.log(contentContainer);
                        let item = document.createElement('div');
                        item.classList.add('tw__border-b', 'last:tw__border-b-0', 'tw__py-4', 'first:tw__pt-0', 'last:tw__pb-0');

                        // Append Action
                        let action = [];
                        // Detail Action
                        // action.push(`
                        //     <li>
                        //         <a class="dropdown-item tw__text-blue-400" href="{{ route('sys.record.index') }}/${val.uuid}">
                        //             <span class=" tw__flex tw__items-center"><i class="bx bx-show tw__mr-2"></i>Detail</span>
                        //         </a>
                        //     </li>
                        // `);

                        // Append Item
                        item.innerHTML = recordContentFormat(val, index, action);
                        contentContainer.appendChild(item);
                    }
                });
            } else {
                // Data is empty
                recordContent = document.createElement('div');
                recordContent.classList.add('alert', 'alert-primary', 'tw__mb-0');
                recordContent.setAttribute('role', 'alert');
                recordContent.innerHTML = `
                    <div class=" tw__flex tw__items-center">
                        <i class="bx bx-error tw__mr-2"></i>
                        <div class="tw__block tw__font-bold tw__uppercase">
                            Attention!
                        </div>
                    </div>
                    <span class="tw__block tw__italic">No data found</span>
                `;

                paneEl.appendChild(recordContent);
            }
        };
    </script>
@endsection