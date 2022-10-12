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
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <div class="card">
        <div class="card-header tw__flex tw__items-center tw__justify-between">
            <h5 class="card-title tw__mb-0">Filter</h5>

            <div class="btn-group">
                <button type="button" class="btn btn-secondary tw__flex tw__items-center tw__gap-2"><i class='bx bx-refresh'></i>Reset</button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-4 tw__mb-4">
                    <label for="filter-year">Year</label>
                </div>
                <div class="col-12 col-lg-4 tw__mb-4">
                    <label for="filter-wallet">Wallet</label>
                    <select class="form-control" id="filter-wallet" placeholder="Search for Wallet Data" multiple>
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
                <div class="col-12 col-lg-4 tw__mb-4">
                    <label for="filter-category">Category</label>
                    <select class="form-control" id="filter-category" placeholder="Search for Category Data">
                        <option value="">Search for Category Data</option>
                        @foreach ($listCategory as $category)
                            <optgroup label="{{ $wallet->name }}">
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
                <div class="col-12">
                    <label for="filter-note">Notes keyword</label>
                    <input type="text" class="form-control" name="filter_keyword" placeholder="Search notes keyword">
                </div>
            </div>
        </div>
    </div>

    <div class="card tw__mt-4">
        <div class="card-body tw__px-0">
            <nav>
                <div class=" tw__w-full tw__flex tw__overflow-x-auto tw__pb-2">
                    <div class=" nav nav-tabs tw__flex-nowrap tw__flex-row-reverse md:tw__flex-row md:tw__min-w-full" id="monthly-key" role="tablist">
                        @for ($i = date('Y-01-01'); $i <= date('Y-m-01'); $i = date("Y-m-01", strtotime($i.' +1 months')))
                            <button type="button" class="tabbed-month nav-link {{ date("Y-m-01") === date("Y-m-01", strtotime($i)) ? 'active' : '' }}" data-bs-toggle="tab" role="tab">{{ date('F', strtotime($i)) }}</button>
                        @endfor
                    </div>
                </div>
                <div class="tab-content tw__pt-4 tw__px-4" id="monthly-record">
                    <div class=" tw__px-4">
                        @for ($i = date("Y-m-d"); $i >= date("Y-m-d", strtotime('-'.(rand(30, 100)).' days')); $i = date("Y-m-d", strtotime($i.' -'.(rand(1, 5)).' days')))
                            <div data-date="{{ $i }}" class="content-wrapper tw__flex tw__flex-row tw__gap-4 tw__mb-4 last:tw__mb-0">
                                {{-- Date Container --}}
                                <div class=" tw__p-4 tw__pt-0 tw__text-center">
                                    <div class="tw__sticky tw__top-24">
                                        <span class="tw__font-semibold">{{ date('D', strtotime($i)) }}</span>
                                        <div class=" tw__min-h-[40px] tw__min-w-[40px] tw__bg-[#696cff] tw__bg-opacity-60 tw__rounded-full tw__flex tw__leading-none tw__items-center tw__justify-center tw__align-middle">
                                            <p class="tw__mb-0 tw__font-bold tw__text-xl tw__text-white">{{ date('d', strtotime($i)) }}</p>
                                        </div>
                                        <small>{{ date('M', strtotime($i)) }} '{{ date("y", strtotime($i)) }}</small>
                                    </div>
                                </div>
                                
                                {{-- Record Item --}}
                                <div class=" tw__bg-gray-50 tw__rounded-lg tw__w-full content-list tw__p-4">
                                    @for ($j = 3; $j < rand(5, 15); $j++)
                                        <div class="tw__border-b last:tw__border-b-0 tw__py-4 first:tw__pt-0 last:tw__pb-0">
                                            ...
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>

@section('js_inline')
    <script>
        document.addEventListener('record_wire-init', (e) => {
            let walletChoice =null;
            if(document.getElementById('filter-wallet')){
                const walletEl = document.getElementById('filter-wallet');
                walletChoice = new Choices(walletEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false
                });
            }
            let categoryChoice =null;
            if(document.getElementById('filter-category')){
                const categoryEl = document.getElementById('filter-category');
                categoryChoice = new Choices(categoryEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Category Data",
                    placeholder: true,
                    placeholderValue: 'Search for Category Data',
                    shouldSort: false
                });
            }
        });
    </script>
@endsection