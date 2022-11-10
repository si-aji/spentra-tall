@section('title', 'Record')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span class="active">Record: List</span>
    </h4>
@endsection

@section('css_plugins')
    @include('layouts.plugins.datatable.css')
@endsection

<div>
    <div class=" tw__mb-4">
        <a href="javascript:void(0)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-record">
            <span class=" tw__flex tw__items-center tw__gap-2"><i class="bx bx-plus"></i>Add new</span>
        </a>
    </div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="card">
        <div class="card-header tw__flex tw__items-center tw__justify-between">
            <h5 class="card-title tw__mb-0">Filter</h5>

            <div class="btn-group" wire:ignore>
                <button type="button" class="btn btn-secondary tw__flex tw__items-center tw__gap-2" id="recordFilter-btn" disabled><i class='bx bx-refresh'></i>Reset</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Filter - Year --}}
                <div class="col-12 col-lg-3 tw__mb-4">
                    <label for="filter-year">Year</label>
                    <div wire:ignore>
                        <select class="form-control" id="filter-year" placeholder="Search for Year Filter" x-on:change="detectFilter()">
                            @for ($i = date("Y-01-01"); $i >= date("Y-01-01", strtotime(\Auth::user()->getFirstYearRecord().'-01-01')); $i = date("Y-01-01", strtotime($i.' -1 years')))
                                <option value="{{ date("Y", strtotime($i)) }}" {{ $dataSelectedYear == date("Y", strtotime($i)) ? 'selected' : '' }}>{{ date("Y", strtotime($i)) }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                {{-- Filter - Type --}}
                <div class="col-12 col-lg-3 tw__mb-4">
                    <label for="filter-type">Type</label>
                    <div wire:ignore>
                        <select class="form-control" id="filter-type" placeholder="Search for Type Filter" x-on:change="detectFilter()">
                            <option value="">Search for Record Type</option>
                            <option value="income" {{ $dataSelectedType === 'income' ? 'selected' : '' }}>Income</option>
                            <option value="expense" {{ $dataSelectedType === 'expense' ? 'selected' : '' }}>Expense</option>
                            <option value="transfer" {{ $dataSelectedType === 'transfer' ? 'selected' : '' }}>Transfer</option>
                        </select>
                    </div>
                </div>

                {{-- Filter - Wallet --}}
                <div class="col-12 col-lg-3 tw__mb-4">
                    <label for="filter-wallet">Wallet</label>
                    <div wire:ignore>
                        <select class="form-control" id="filter-wallet" placeholder="Search for Wallet Data" multiple x-on:change="detectFilter()">
                            <option value="">Search for Wallet Data</option>
                            @foreach ($listWallet as $wallet)
                                <optgroup label="{{ $wallet->name }}">
                                    <option value="{{ $wallet->uuid }}">{{ $wallet->name }}</option>
                                    @if ($wallet->child()->exists())
                                        @foreach ($wallet->child as $child)
                                            <option value="{{ $child->uuid }}">{{ $wallet->name }} - {{ $child->name }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Filter - Category --}}
                <div class="col-12 col-lg-3 tw__mb-4">
                    <label for="filter-category">Category</label>
                    <div wire:ignore>
                        <select class="form-control" id="filter-category" placeholder="Search for Category Data" multiple x-on:change="detectFilter()">
                            <option value="">Search for Category Data</option>
                            @foreach ($listCategory as $category)
                                <optgroup label="{{ $category->name }}">
                                    <option value="{{ $category->uuid }}">{{ $category->name }}</option>
                                    @if ($category->child()->exists())
                                        @foreach ($category->child as $child)
                                            <option value="{{ $child->uuid }}">{{ $category->name }} - {{ $child->name }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Filter - Keyword --}}
                <div class="col-12">
                    <label for="filter-note">Notes Keyword</label>
                    <input type="text" class="form-control" name="filter_keyword" id="input_record-filter_keyword" placeholder="Search notes keyword" @input.debounce="detectFilter()">
                </div>
            </div>
        </div>
    </div>

    <div class="card tw__mt-4">
        <div class="card-body tw__px-0 tw__pb-0">
            <nav>
                <div class=" tw__w-full tw__flex tw__overflow-x-auto tw__pb-2">
                    <div class=" nav nav-tabs tw__flex-nowrap tw__flex-row-reverse md:tw__flex-row md:tw__min-w-full" id="monthly-key" role="tablist">
                        @for ($i = date('Y-01-01', strtotime($dataSelectedYear.'-01-01')); $i <= date('Y-m-01', strtotime($dataSelectedYear."-".($dataSelectedYear !== date("Y") ? '12' : date("m"))."-01")); $i = date("Y-m-01", strtotime($i.' +1 months')))
                            <button type="button" class="tabbed-month nav-link {{ date("Y-m-01", strtotime($dataSelectedMonth)) === date("Y-m-01", strtotime($i)) ? 'active' : '' }}" data-date="{{ date("Y-m-01", strtotime($i)) }}" data-bs-toggle="tab" role="tab" wire:click="monthChanged" x-on:click="$wire.localUpdate('dataSelectedMonth', $event.target.dataset.date)">{{ date('M', strtotime($i)) }}</button>
                        @endfor
                    </div>
                </div>
            </nav>

            <div class="tab-content tw__pt-4 tw__px-4" id="monthly-record">
                <div wire:loading.block wire:target="monthChanged">
                    @for ($i = 0; $i < 3; $i++)
                        <div class=" tw__px-4 tw__flex tw__flex-col">
                            <div class="list-wrapper tw__flex tw__gap-2 tw__mb-4 last:tw__mb-0">
                                <div class=" tw__py-4 md:tw__px-4 tw__text-center">
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

                <div wire:loading.remove wire:target="monthChanged" id="record-container">
                    <div>
                        @for ($i = 0; $i < 3; $i++)
                            <div class=" tw__flex tw__flex-col">
                                <div class="list-wrapper tw__flex tw__gap-2 tw__mb-4 last:tw__mb-0">
                                    <div class=" tw__py-4 md:tw__px-4 tw__text-center">
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

@section('js_plugins')
    <script src="{{ mix('assets/js/format-record.js') }}"></script>
@endsection

@section('js_inline')
    <script>
        // Choices
        let recordFilterYearChoice = null;
        let recordFilterTypeChoice = null;
        let recordFilterWalletChoice = null;
        let recordFilterCategoryChoice = null;

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
                    itemSelectText: ''
                });
            }
            if(document.getElementById('filter-type')){
                const filterTypeEl = document.getElementById('filter-type');
                recordFilterTypeChoice = new Choices(filterTypeEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Record Type Filter",
                    placeholder: true,
                    placeholderValue: 'Search for Record Type Filter',
                    shouldSort: false,
                    itemSelectText: ''
                });
            }
            if(document.getElementById('filter-wallet')){
                const walletFilterEl = document.getElementById('filter-wallet');
                recordFilterWalletChoice = new Choices(walletFilterEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false,
                    itemSelectText: ''
                });
            }
            if(document.getElementById('filter-category')){
                const categoryFilterEl = document.getElementById('filter-category');
                recordFilterCategoryChoice = new Choices(categoryFilterEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Category Data",
                    placeholder: true,
                    placeholderValue: 'Search for Category Data',
                    shouldSort: false,
                    itemSelectText: ''
                });
            }
        });
        window.addEventListener('recordLoadData', (e) => {
            generateList();
        });

        if(document.getElementById('modal-record')){
            document.getElementById('modal-record').addEventListener('hide.bs.modal', (e) => {
                window.dispatchEvent(new Event('recordLoadData'));
            });
        }

        const generateList = () => {
            if(document.getElementById('record-container')){
                document.getElementById('record-container').innerHTML = ``;
            }

            let data = @this.get('dataRecord');
            let paneEl = document.getElementById('record-container');
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
                        // Edit Action
                        action.push(`
                            <li>
                                <a class="dropdown-item tw__text-yellow-400" href="javascript:void(0)" data-uuid="${val.uuid}" onclick="Livewire.emitTo('sys.component.record-modal', 'editAction', '${val.uuid}')">
                                    <span class=" tw__flex tw__items-center"><i class="bx bx-edit tw__mr-2"></i>Edit</span>
                                </a>
                            </li>
                        `);
                        // Detail Action
                        action.push(`
                            <li>
                                <a class="dropdown-item tw__text-blue-400" href="{{ route('sys.record.index') }}/${val.uuid}">
                                    <span class=" tw__flex tw__items-center"><i class="bx bx-show tw__mr-2"></i>Detail</span>
                                </a>
                            </li>
                        `);
                        // Delete Action
                        action.push(`
                            <li>
                                <a class="dropdown-item tw__text-red-400" href="javascript:void(0)" onclick="removeRecord('${val.uuid}')">
                                    <span class=" tw__flex tw__items-center"><i class="bx bx-trash tw__mr-2"></i>Remove</span>
                                </a>
                            </li>
                        `);

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
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        }

        // Filter
        function detectFilter(){
            console.log("Detect Filter");

            let button = document.getElementById('recordFilter-btn');
            let filterButtonDisabledState = true;
            let stateCount = 0;

            // Year Filter
            let currentYear = moment().format('YYYY');
            let year = currentYear;
            if(recordFilterYearChoice.getValue()){
                year = recordFilterYearChoice.getValue().value;
            } else {
                recordFilterYearChoice.setChoiceByValue(currentYear);
            }
            @this.set('dataSelectedYear', year);
            if(year !== currentYear){
                stateCount += 1;
            }
            // Type Filter
            let type = '';
            if(recordFilterTypeChoice.getValue()){
                type = recordFilterTypeChoice.getValue().value;
            } else {
                recordFilterTypeChoice.removeActiveItems();
            }
            @this.set('dataSelectedType', type);
            if(type !== ''){
                stateCount += 1;
            }
            // Wallet Filter
            let wallet = [];
            if(recordFilterWalletChoice.getValue()){
                recordFilterWalletChoice.getValue().forEach((e, key) => {
                    wallet.push(e.value);
                });
            } else {
                recordFilterWalletChoice.removeActiveItems();
            }
            @this.set('dataSelectedWallet', wallet);
            if(wallet.length > 0){
                stateCount += 1;
            }
            // Category Filter
            let category = [];
            if(recordFilterCategoryChoice.getValue()){
                recordFilterCategoryChoice.getValue().forEach((e, key) => {
                    category.push(e.value);
                });
            } else {
                recordFilterCategoryChoice.removeActiveItems();
            }
            @this.set('dataSelectedCategory', category);
            if(category.length > 0){
                stateCount += 1;
            }
            // Note
            if(document.getElementById('input_record-filter_keyword').value !== ''){
                stateCount += 1;
            }
            @this.set('dataSelectedNote', document.getElementById('input_record-filter_keyword').value);

            if(stateCount > 0){
                filterButtonDisabledState = false;
            }
            button.disabled = filterButtonDisabledState;
        }
        if(document.getElementById('recordFilter-btn')){
            document.getElementById('recordFilter-btn').addEventListener('click', (e) => {
                console.log("Filter Reset");
                // Year
                recordFilterYearChoice.setChoiceByValue(moment().format('YYYY'));
                // Type
                recordFilterTypeChoice.setChoiceByValue('');
                // Wallet
                recordFilterWalletChoice.removeActiveItems();
                // Category
                recordFilterCategoryChoice.removeActiveItems();
                // Note
                document.getElementById('input_record-filter_keyword').value = '';

                detectFilter();
            });
        }
    </script>
@endsection