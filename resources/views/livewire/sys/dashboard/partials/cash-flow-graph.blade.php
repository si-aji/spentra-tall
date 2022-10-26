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