<div>
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Hi <strong>{{ \Auth::user()->name }}</strong> 👋, how's doing?</h5>
                            <p class="mb-4">
                                You don't have any planned payment today
                            </p>

                            <a href="javascript:void(0);" class="btn btn-sm btn-outline-primary">View Planned Payment</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="{{ asset('assets/themes/sneat/img/illustrations/man-with-laptop-light.png') }}"
                                height="140"
                                alt="View Badge User"
                                data-app-dark-img="{{ asset('assets/themes/sneat/img/illustrations/man-with-laptop-dark.png') }}"
                                data-app-light-img="{{ asset('assets/themes/sneat/img/illustrations/man-with-laptop-light.png') }}"
                                class=" tw__h-[140px]"
                                style="display: unset !important"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cash Flow -->
        <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
            <div class="card">
                <div class="row row-bordered g-0">
                    <div class="col-md-8">
                        <h5 class="card-header m-0 me-2 pb-3">Cash Flow</h5>
                        <div id="cashFlowChart" class="px-2"></div>
                    </div>
                    <div class="col-md-4 tw__flex tw__flex-col">
                        <div class=" tw__p-6">
                            <div class="text-center">
                                <div class="dropdown">
                                    <button
                                    class="btn btn-sm btn-outline-primary dropdown-toggle"
                                    type="button"
                                    id="growthReportId"
                                    data-bs-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    >
                                    2022
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                                    <a class="dropdown-item" href="javascript:void(0);">Income</a>
                                    <a class="dropdown-item" href="javascript:void(0);">Expense</a>
                                    <a class="dropdown-item" href="javascript:void(0);">2019</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class=" tw__my-auto">
                            <div class="text-center fw-bold">
                                <span class=" tw__text-xl">Rp 2.000.000</span>
                            </div>
                            <div class="text-center fw-semibold pt-3 mb-2">Balance</div>
                        </div>
                        <div class=" tw__grid tw__grid-cols-1 tw__gap-2 tw__p-6">    
                            <div class="d-flex tw__items-center">
                                <div class="me-2">
                                    <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>Income</small>
                                    <h6 class="mb-0">{{ formatRupiah($cashFlowIncomeSum / 1000) }}k</h6>
                                </div>
                            </div>
                            <div class="d-flex tw__items-center">
                                <div class="me-2">
                                    <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                                </div>
                                <div class="d-flex flex-column">
                                    <small>Expense</small>
                                    <h6 class="mb-0">{{ formatRupiah($cashFlowExpenseSum / 1000) }}k</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Cash Flow -->
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
                        <div id="orderStatisticsChart"></div>
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

        <!-- Expense Overview -->
        <div class="col-md-6 col-lg-4 order-1 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <ul class="nav nav-pills" role="tablist">
                        <li class="nav-item">
                            <button
                                type="button"
                                class="nav-link active"
                                role="tab"
                                data-bs-toggle="tab"
                                data-bs-target="#navs-tabs-line-card-income"
                                aria-controls="navs-tabs-line-card-income"
                                aria-selected="true"
                            >
                                Income
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab">Expenses</button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab">Profit</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body px-0">
                    <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-tabs-line-card-income" role="tabpanel">
                            <div class="d-flex p-4 pt-3">
                                <div class="avatar flex-shrink-0 me-3">
                                    <img src="{{ asset('assets/themes/sneat/img/icons/unicons/wallet.png') }}" alt="User" />
                                </div>
                                <div>
                                    <small class="text-muted d-block">Total Balance</small>
                                    <div class="d-flex align-items-center">
                                        <h6 class="mb-0 me-1">$459.10</h6>
                                        <small class="text-success fw-semibold">
                                            <i class="bx bx-chevron-up"></i>
                                            42.9%
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div id="incomeChart"></div>
                            <div class="d-flex justify-content-center pt-4 gap-2">
                                <div class="flex-shrink-0">
                                    <div id="expensesOfWeek"></div>
                                </div>
                                <div>
                                <p class="mb-n1 mt-1">Expenses This Week</p>
                                    <small class="text-muted">$39 less than last week</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Expense Overview -->

        <!-- Transactions -->
        <div class="col-md-6 col-lg-4 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Transactions</h5>
                    <div class="dropdown">
                        <button
                            class="btn p-0"
                            type="button"
                            id="transactionID"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="transactionID">
                            <a class="dropdown-item" href="javascript:void(0);">Last 28 Days</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Month</a>
                            <a class="dropdown-item" href="javascript:void(0);">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/themes/sneat/img/icons/unicons/paypal.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Paypal</small>
                                    <h6 class="mb-0">Send money</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+82.6</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/themes/sneat/img/icons/unicons/wallet.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Wallet</small>
                                    <h6 class="mb-0">Mac'D</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+270.69</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/themes/sneat/img/icons/unicons/chart.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Transfer</small>
                                    <h6 class="mb-0">Refund</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+637.91</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/themes/sneat/img/icons/unicons/cc-success.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Credit Card</small>
                                    <h6 class="mb-0">Ordered Food</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">-838.71</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/themes/sneat/img/icons/unicons/wallet.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Wallet</small>
                                    <h6 class="mb-0">Starbucks</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">+203.33</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex">
                            <div class="avatar flex-shrink-0 me-3">
                                <img src="{{ asset('assets/themes/sneat/img/icons/unicons/cc-warning.png') }}" alt="User" class="rounded" />
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <small class="text-muted d-block mb-1">Mastercard</small>
                                    <h6 class="mb-0">Ordered Food</h6>
                                </div>
                                <div class="user-progress d-flex align-items-center gap-1">
                                    <h6 class="mb-0">-92.45</h6>
                                    <span class="text-muted">USD</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--/ Transactions -->
    </div>
</div>

@section('js_inline')
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
            // stroke: {
            //     curve: 'smooth',
            //     width: 0,
            //     lineCap: 'round',
            //     colors: [cardColor]
            // },
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
                    }
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
        };
        if (typeof cashFlowChartEl !== undefined && cashFlowChartEl !== null) {
            const cashFlowChart = new ApexCharts(cashFlowChartEl, cashFlowChartOptions);
            cashFlowChart.render();
        }

        // Growth Chart - Radial Bar Chart
        // --------------------------------------------------------------------
        const growthChartEl = document.querySelector('#growthChart'),
        growthChartOptions = {
            series: [78],
            labels: ['Growth'],
            chart: {
                height: 240,
                type: 'radialBar'
            },
            plotOptions: {
                radialBar: {
                size: 150,
                    offsetY: 10,
                    startAngle: -150,
                    endAngle: 150,
                    hollow: {
                        size: '55%'
                    },
                    track: {
                        background: cardColor,
                        strokeWidth: '100%'
                    },
                    dataLabels: {
                        name: {
                            offsetY: 15,
                            color: headingColor,
                            fontSize: '15px',
                            fontWeight: '600',
                            fontFamily: 'Public Sans'
                        },
                        value: {
                            offsetY: -25,
                            color: headingColor,
                            fontSize: '22px',
                            fontWeight: '500',
                            fontFamily: 'Public Sans'
                        }
                    }
                }
            },
            colors: [config.colors.primary],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    shadeIntensity: 0.5,
                    gradientToColors: [config.colors.primary],
                    inverseColors: true,
                    opacityFrom: 1,
                    opacityTo: 0.6,
                    stops: [30, 70, 100]
                }
            },
            stroke: {
                dashArray: 5
            },
            grid: {
                padding: {
                    top: -35,
                    bottom: -10
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
            }
        };
        if (typeof growthChartEl !== undefined && growthChartEl !== null) {
            const growthChart = new ApexCharts(growthChartEl, growthChartOptions);
            growthChart.render();
        }
    </script>
@endsection