<div class="card">
    <div class="row row-bordered g-0">
        <div class="col-md-8" wire:ignore>
            <h5 class="card-header m-0 me-2 pb-3">Cash Flow</h5>
            <div id="cashFlowChart" class="px-2"></div>
        </div>
        <div class="col-md-4 tw__flex tw__flex-col">
            <div class=" tw__p-6">
                <div class=" tw__flex tw__items-center tw__justify-between">
                    <div class="dropdown" x-data="{
                        selectedYear: '{{ date("Y") }}'
                    }">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="growthReportId" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" x-text="selectedYear"></button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="growthReportId">
                            @for ($i = date("Y-01-01"); $i >= date("Y-01-01", strtotime(\Auth::user()->getFirstYearRecord().'-01-01')); $i = date("Y-01-01", strtotime($i.' -1 years')))
                                <a href="javascript:void(0)" class="dropdown-item" x-on:click="selectedYear = '{{ date("Y", strtotime($i)) }}'">{{ date("Y", strtotime($i)) }}</a>
                                {{-- <option value="{{ date("Y", strtotime($i)) }}" {{ $dataSelectedYear == date("Y", strtotime($i)) ? 'selected' : '' }}>{{ date("Y", strtotime($i)) }}</option> --}}
                            @endfor
                        </div>
                    </div>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="orederStatistics" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-cog"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="orederStatistics" style="">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" tw__my-auto tw__flex tw__justify-center" wire:ignore>
                <div id="orderStatisticsChart"></div>
            </div>
            {{-- Sum of Income / Expense --}}
            <div class=" tw__grid tw__grid-cols-1 tw__gap-2 tw__p-6">    
                <div class=" tw__flex tw__items-center tw__gap-2">
                    <span class="badge bg-label-primary p-2"><i class="bx bx-dollar text-primary"></i></span>
                    <div class=" tw__flex tw__flex-col tw__gap-1">
                        <small class=" tw__leading-none">Income</small>
                        <h6 class=" tw__mb-0 tw__leading-none">{{ formatRupiah($cashFlowIncomeSum / 1000) }}k</h6>
                    </div>
                </div>
                <div class=" tw__flex tw__items-center tw__gap-2">
                    <span class="badge bg-label-info p-2"><i class="bx bx-wallet text-info"></i></span>
                    <div class=" tw__flex tw__flex-col tw__gap-1">
                        <small class=" tw__leading-none">Expense</small>
                        <h6 class=" tw__mb-0 tw__leading-none">{{ formatRupiah($cashFlowExpenseSum / 1000) }}k</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>