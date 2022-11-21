@section('title', 'Dashboard')
<div>
    <div class="row">
        <div class="col-lg-8 col-12">
            <div class=" tw__mb-4">
                {{-- Planned Payment --}}
                @include('livewire.sys.dashboard.partials.planned-payment-summary')
            </div>

            <div class=" tw__mb-4">
                {{-- Cash Flow --}}
                @include('livewire.sys.dashboard.partials.cash-flow-graph')
            </div>
        </div>
        <div class="col-lg-4 col-12">
            <div class=" tw__mb-4">
                {{-- Balance --}}
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Balance</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <span>-</span>
                    </div>
                </div>
            </div>
            <div class=" tw__mb-4">
                {{-- Budget --}}
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between pb-0">
                        <div class="card-title mb-0">
                            <h5 class="m-0 me-2">Budget</h5>
                        </div>
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <span>-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Statistics -->
        <div class="col-md-6 col-lg-4 col-xl-4 order-0 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between pb-0">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Order Statistics</h5>
                        <small class="text-muted">42.82k Total Sales</small>
                    </div>
                    <div class="dropdown">
                        <button
                            class="btn p-0"
                            type="button"
                            id="orederStatistics"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-column align-items-center gap-1">
                            <h2 class="mb-2">8,258</h2>
                            <span>Total Orders</span>
                        </div>
                    </div>
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class="bx bx-mobile-alt"></i>
                                </span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Electronic</h6>
                                    <small class="text-muted">Mobile, Earbuds, TV</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">82.5k</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-closet"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Fashion</h6>
                                    <small class="text-muted">T-shirt, Jeans, Shoes</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">23.8k</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-home-alt"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Decor</h6>
                                    <small class="text-muted">Fine Art, Dining</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">849k</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-secondary"
                                ><i class="bx bx-football"></i
                                ></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Sports</h6>
                                    <small class="text-muted">Football, Cricket Kit</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">99</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Order Statistics -->

        <!-- Weekly Overview -->
        <div class="col-md-6 col-lg-4 order-1 mb-4">
            <div class="card h-100" x-data="{
                selectedRecordType: 'Income'
            }">
                <div class="card-header">
                    <div class=" tw__flex tw__justify-between">
                        <ul class="nav nav-pills tw__justify-center" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link" x-on:click="selectedRecordType = 'Income';@this.set('weeklyRecordType', 'income');" :class="selectedRecordType === 'Income' ? 'active' : ''">
                                    Income
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" x-on:click="selectedRecordType = 'Expense';@this.set('weeklyRecordType', 'expense');" :class="selectedRecordType === 'Expense' ? 'active' : ''">
                                    Expense
                                </button>
                            </li>
                        </ul>
                        
                        <div class="dropdown">
                            <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics">
                                <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                                <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                                <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 tw__pt-24 tw__relative">
                    <div class=" tw__absolute tw__top-4 tw__w-full tw__px-4">
                        <div class=" tw__flex tw__justify-between">
                            <div class=" tw__flex tw__flex-col">
                                <small>Last Week</small>
                                <span class="weekly-report" data-date="{{ $prevWeeklyStart }}">-</span>
                                @if ($prevWeeklyEnd !== $prevWeeklyStart)
                                    <span class="weekly-report" data-date="{{ $prevWeeklyEnd }}">-</span>
                                @endif
                            </div>
                            <div class=" tw__flex tw__flex-col">
                                <small>This week</small>
                                <span class="weekly-report" data-date="{{ $weeklyStart }}">-</span>
                                @if ($weeklyEnd !== $weeklyStart)
                                    <span class="weekly-report" data-date="{{ $weeklyEnd }}">-</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex p-4 pt-3">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('assets/themes/sneat/img/icons/unicons/wallet-info.png') }}" alt="User" />
                        </div>
                        <div>
                            <small class="text-muted d-block">This Week Amount</small>
                            <div class="d-flex align-items-center" x-data="{toggle: false}">
                                <h6 class="mb-0 me-1" data-orig="{{ formatRupiah($weeklyAmount) }}" data-short="{{ formatRupiah($weeklyAmount, 'Rp', true) }}" x-on:click="toggle = !toggle;$el.innerHTML = `${toggle ? $el.dataset.orig : $el.dataset.short}`">{{ formatRupiah($weeklyAmount, 'Rp', true) }}</h6>
                                <small class="text-{{ $weeklyRecordType === 'expense' ? ($weeklyAmount < $prevWeeklyAmount ? 'success' : 'danger') : ($weeklyAmount < $prevWeeklyAmount ? 'danger' : 'success') }} fw-semibold">
                                    <i class="bx bx-chevron-{{ $weeklyAmount < $prevWeeklyAmount ? 'down' : 'up' }}"></i>
                                    {{ number_format((float)$weeklyPercentage, 2, '.', '') }}%
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex p-4 pt-3">
                        <div class="avatar flex-shrink-0 me-3">
                            <img src="{{ asset('assets/themes/sneat/img/icons/unicons/wallet-info.png') }}" alt="User" />
                        </div>
                        <div>
                            <small class="text-muted d-block">Last Week Amount</small>
                            <div class="d-flex align-items-center" x-data="{toggle: false}">
                                <h6 class="mb-0 me-1" data-orig="{{ formatRupiah($prevWeeklyAmount) }}" data-short="{{ formatRupiah($prevWeeklyAmount, 'Rp', true) }}" x-on:click="toggle = !toggle;$el.innerHTML = `${toggle ? $el.dataset.orig : $el.dataset.short}`">{{ formatRupiah($prevWeeklyAmount, 'Rp', true) }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center pt-4 gap-2">
                        <div x-data="{toggle: false}">
                                {{-- <h6 class="mb-0 me-1" data-orig="{{ formatRupiah($weeklyAmount) }}" data-short="{{ formatRupiah($weeklyAmount, 'Rp', true) }}" x-on:click="toggle = !toggle;$el.innerHTML = `${toggle ? $el.dataset.orig : $el.dataset.short}`">{{ formatRupiah($weeklyAmount, 'Rp', true) }}</h6> --}}
                            <p class="mb-n1 mt-1 tw__text-center" x-text="`${selectedRecordType} This Week`"></p>
                            <small class="text-muted">{{ $weeklyAmount !== $prevWeeklyAmount ? ($weeklyAmount > $prevWeeklyAmount ? formatRupiah($weeklyAmount - $prevWeeklyAmount, 'Rp', true) : formatRupiah($prevWeeklyAmount - $weeklyAmount, 'Rp', true)) : '' }}{{ ($weeklyAmount === $prevWeeklyAmount ? 'same with' : ($weeklyAmount > $prevWeeklyAmount ? ' more than' : ' less than')) }} last week</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Weekly Overview -->

        <!-- Wallet List -->
        <div class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">
                        <span>{{ count($walletData) }} Wallet(s)</span>
                    </h5>
                </div>
                <div class="card-body tw__overflow-y-auto tw__max-h-[335px]">
                    <ul class="p-0 m-0">
                        @foreach ($walletData as $wallet)
                            <li class="d-flex mb-4 pb-1">
                                <div class="avatar flex-shrink-0 me-3">
                                    <span class=" tw__w-full tw__h-full tw__flex tw__items-center tw__justify-center tw__rounded {{ $wallet->type === 'general' ? 'tw__bg-slate-200' : ($wallet->type === 'saving' ? 'tw__bg-green-200' : 'tw__bg-purple-200') }}">
                                        <i class="bx bx-wallet-alt"></i>
                                    </span>
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <small class="text-muted d-block mb-1">{{ ucwords($wallet->type) }}</small>
                                        <h6 class="mb-0">{{ ($wallet->parent()->exists() ? $wallet->parent->name.' - ' : '').$wallet->name }}</h6>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <a href="{{ route('sys.wallet.list.show', $wallet->uuid) }}" class=" tw__text-black"><i class="bx bx-dots-vertical-rounded"></i></a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Wallet List -->
    </div>
</div>

@section('js_inline')
    {{-- Cashflow Chart --}}
    <script>
        // JS global variables
        let config = {
            colors: {
                primary: '#696cff',
                secondary: '#8592a3',
                success: '#71dd37',
                info: '#03c3ec',
                warning: '#ffab00',
                danger: '#ff3e1d',
                dark: '#233446',
                black: '#000',
                white: '#fff',
                body: '#f4f5fb',
                headingColor: '#566a7f',
                axisColor: '#a1acb8',
                borderColor: '#eceef1'
            }
        };

        let cardColor, headingColor, axisColor, shadeColor, borderColor;
        cardColor = config.colors.white;
        headingColor = config.colors.headingColor;
        axisColor = config.colors.axisColor;
        borderColor = config.colors.borderColor;

        // Cash Flow Report Chart - Bar Chart
        // --------------------------------------------------------------------
        const cashFlowChartEl = document.querySelector('#cashFlowChart'),
            cashFlowChartOptions = {
                series: [
                    {
                        name: 'Income',
                        data: @json($cashFlowIncome)
                    }, {
                        name: 'Expense',
                        data: @json($cashFlowExpense)
                    }
                ],
                chart: {
                    height: 300,
                    stacked: true,
                    type: 'bar',
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '20%',
                        borderRadius: 5,
                        startingShape: 'rounded',
                        endingShape: 'rounded'
                    }
                },
                colors: [config.colors.primary, config.colors.info],
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: true,
                    horizontalAlign: 'left',
                    position: 'top',
                    markers: {
                        height: 8,
                        width: 8,
                        radius: 12,
                        offsetX: -3
                    },
                    labels: {
                        colors: axisColor
                    },
                    itemMargin: {
                        horizontal: 10
                    }
                },
                grid: {
                    borderColor: borderColor,
                    padding: {
                        top: 0,
                        bottom: -8,
                        left: 20,
                        right: 20
                    }
                },
                xaxis: {
                    categories: @json($cashFlowLabel),
                    labels: {
                        style: {
                            fontSize: '13px',
                            colors: axisColor
                        }
                    },
                    axisTicks: {
                        show: false
                    },
                    axisBorder: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            fontSize: '13px',
                            colors: axisColor
                        },
                        formatter: (value) => {
                            return formatRupiah(value);
                        },
                    }
                },
                states: {
                    hover: {
                        filter: {
                            type: 'none'
                        }
                    },
                    active: {
                        filter: {
                            type: 'none'
                        }
                    }
                },
                tooltip: {
                    shared: true,
                    intersect: false
                },
                responsive: [
                    {
                        breakpoint: 425,
                        options: {
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '30%',
                                    borderRadius: 3,
                                    startingShape: 'rounded',
                                    endingShape: 'rounded'
                                }
                            },
                            xaxis: {
                                categories: @js($cashFlowLabel).map((e) => {
                                    return `${moment().month(e).format('M')}`;
                                }),
                            }
                        }
                    }
                ]
            };
        if (typeof cashFlowChartEl !== undefined && cashFlowChartEl !== null) {
            const cashFlowChart = new ApexCharts(cashFlowChartEl, cashFlowChartOptions);
            cashFlowChart.render();
        }
    </script>
    {{-- Category --}}
    <script>
        // Order Statistics Chart
        // --------------------------------------------------------------------
        let dataset = @js($categoryGraphData);
        const chartOrderStatistics = document.querySelector('#orderStatisticsChart'),
            orderChartConfig = {
                chart: {
                    type: 'donut'
                },
                labels: @js($categoryGraphLabel),
                series: dataset,
                colors: @js($categoryGraphColor),
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return formatRupiah(value, 'Rp', true);
                        }
                    }
                },
                stroke: {
                    width: 5,
                    colors: cardColor
                },
                dataLabels: {
                    enabled: false,
                    formatter: function (val, opt) {
                        return parseInt(val) + '%';
                    }
                },
                legend: {
                    show: false
                },
                grid: {
                    padding: {
                        top: 0,
                        bottom: 0,
                        right: 15
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                value: {
                                    fontSize: '1.5rem',
                                    fontFamily: 'Public Sans',
                                    offsetY: -15,
                                    formatter: function (val) {
                                        return !(isNaN(val)) ? formatRupiah(val, 'Rp', true) : val;
                                    }
                                },
                                name: {
                                    offsetY: 20,
                                    fontFamily: 'Public Sans',
                                },
                                total: {
                                    show: true,
                                    fontSize: '0.8125rem',
                                    color: axisColor,
                                    label: 'by Category',
                                    formatter: function (w) {
                                        return 'Cashflow';
                                    }
                                }
                            },
                        }
                    }
                }
            };

        if (typeof chartOrderStatistics !== undefined && chartOrderStatistics !== null) {
            const statisticsChart = new ApexCharts(chartOrderStatistics, orderChartConfig);
            statisticsChart.render();
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            // Weekly Report
            window.dispatchEvent(new Event('dashboardWireInit'));
        });

        window.addEventListener('dashboardWireInit', (e) => {
            if(document.querySelectorAll('.weekly-report').length > 0){
                document.querySelectorAll('.weekly-report').forEach((el) => {
                    let date = el.dataset.date;
                    el.innerHTML = momentDateTime(date, 'DD MMM, YYYY');
                });
            }
        });
    </script>
@endsection