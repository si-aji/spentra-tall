<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <form id="budget-form">
        <div class="offcanvas offcanvas-end" tabindex="-1" id="modal-budget" aria-labelledby="offcanvasLabel" wire:init="" wire:ignore.self x-data="">
            <div class="offcanvas-header">
                <h5 id="offcanvasLabel" class="offcanvas-title">Budget: {{ $budgetTitle }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                {{-- Name --}}
                <div class="form-group tw__mb-4">
                    <label for="input_budget-name">Name</label>
                    <input type="text" class="form-control @error('budgetName') is-invalid @enderror" name="name" id="input_budget-name" placeholder="Name" wire:model.defer="budgetName">
                    @error('budgetName')
                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Period --}}
                <div class="form-group tw__mb-4">
                    <label for="input_budget-period">Period</label>
                    <div wire:ignore>
                        <select class="form-control @error('budgetPeriod') is-invalid @enderror" id="input_budget-period" name="period" placeholder="Search for Budget Period Data">
                            <option value="">Search for Repeat Type Data</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>
                    @error('budgetPeriod')
                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Amount --}}
                <div class="form-group tw__mb-4">
                    <label for="input_budget-amount">Amount</label>
                    <input type="text" inputmode="numeric" class="form-control @error('budgetAmount') is-invalid @enderror" name="amount" id="input_budget-amount" placeholder="Budget Amount">
                    @error('budgetAmount')
                        <small class="invalid-feedback">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Included Section --}}
                <div class=" tw__bg-gray-50 tw__p-4 tw__rounded tw__mb-4">
                    <div class="alert alert-secondary" role="alert">
                        <h1 class=" tw__text-base tw__font-bold tw__mb-0 tw__flex tw__items-center tw__gap-1"><i class="bx bx-info-circle"></i>Include Condition</h1>
                        <span class=" tw__leading-none">All record with data maching the configuration below, will be <strong>included</strong> on related budget</span>
                    </div>

                    {{-- Wallet --}}
                    <div class="form-group tw__mb-4">
                        <label for="input_budget-included_wallet">Wallet</label>
                        <div wire:ignore>
                            <select class="form-control" id="input_budget-included_wallet" name="included_wallet" placeholder="Search for Wallet Data" multiple>
                                <option value="">Search for Wallet Data</option>
                            </select>
                        </div>
                        @error('budgetIncludedWallet')
                            <small class="invalid-feedback tw__block">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- Category --}}
                    <div class="form-group tw__mb-4">
                        <label for="input_budget-included_category">Category</label>
                        <div wire:ignore>
                            <select class="form-control" id="input_budget-included_category" name="included_category" placeholder="Search for Category Data" multiple>
                                <option value="">Search for Category Data</option>
                            </select>
                        </div>
                        @error('budgetIncludedCategory')
                            <small class="invalid-feedback tw__block">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- Tags --}}
                    <div class="form-group">
                        <label for="input_budget-included_tags">Tags</label>
                        <div wire:ignore>
                            <select class="form-control" id="input_budget-included_tags" name="included_tags" placeholder="Search for Tags Data" multiple>
                                <option value="">Search for Tags Data</option>
                            </select>
                        </div>
                        @error('budgetIncludedTags')
                            <small class="invalid-feedback tw__block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                {{-- Exclude Section --}}
                <div class=" tw__bg-gray-50 tw__p-4 tw__rounded tw__mb-4">
                    <div class="alert alert-danger" role="alert">
                        <h1 class=" tw__text-base tw__font-bold tw__mb-0 tw__flex tw__items-center tw__gap-1"><i class="bx bx-info-circle"></i>Exclude Condition</h1>
                        <span class=" tw__leading-none">All record with data maching the configuration below, will be <strong>excluded</strong> on related budget (<strong>This configuration will override Include Condition</strong>)</span>
                    </div>

                    {{-- Wallet --}}
                    <div class="form-group tw__mb-4">
                        <label for="input_budget-excluded_wallet">Wallet</label>
                        <div wire:ignore>
                            <select class="form-control" id="input_budget-excluded_wallet" name="excluded_wallet" placeholder="Search for Wallet Data" multiple>
                                <option value="">Search for Wallet Data</option>
                            </select>
                        </div>
                        @error('budgetExcludedWallet')
                            <small class="invalid-feedback tw__block">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- Category --}}
                    <div class="form-group tw__mb-4">
                        <label for="input_budget-excluded_category">Category</label>
                        <div wire:ignore>
                            <select class="form-control" id="input_budget-excluded_category" name="excluded_category" placeholder="Search for Category Data" multiple>
                                <option value="">Search for Category Data</option>
                            </select>
                        </div>
                        @error('budgetExcludedCategory')
                            <small class="invalid-feedback tw__block">{{ $message }}</small>
                        @enderror
                    </div>
                    {{-- Tags --}}
                    <div class="form-group">
                        <label for="input_budget-excluded_tags">Tags</label>
                        <div wire:ignore>
                            <select class="form-control" id="input_budget-excluded_tags" name="excluded_tags" placeholder="Search for Tags Data" multiple>
                                <option value="">Search for Tags Data</option>
                            </select>
                        </div>
                        @error('budgetExcludedTags')
                            <small class="invalid-feedback tw__block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
    
                <button type="submit" class="btn btn-primary mb-2 d-grid w-100">Submit</button>
                <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
                    Cancel
                </button>
            </div>
        </div>

        @if (isset($budgetModalState) && $budgetModalState === 'show')
            <div class="offcanvas-backdrop fade show"></div>
        @endif
    </form>
</div>

@push('javascript')
    <script>
        // iMask
        let budgetAmountMask = null;
        // Choices
        let budgetPeriodChoice = null;
        let budgetIncludedWalletChoice = null;
        let budgetExcludedWalletChoice = null;
        let budgetIncludedCategoryChoice = null;
        let budgetExcludedCategoryChoice = null;
        let budgetIncludedTagsChoice = null;
        let budgetExcludedTagsChoice = null;

        document.addEventListener('DOMContentLoaded', (e) => {
            document.getElementById('modal-budget').addEventListener('show.bs.offcanvas', (e) => {
                @this.set('budgetModalState', 'show');
            });
            document.getElementById('modal-budget').addEventListener('hidden.bs.offcanvas', (e) => {
                @this.set('budgetModalState', 'hide');
            });

            // Choices
            if(document.getElementById('input_budget-period')){
                const budgetPeriodEl = document.getElementById('input_budget-period');
                budgetPeriodChoice = new Choices(budgetPeriodEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Budget Period Data",
                    placeholder: true,
                    placeholderValue: 'Search for Budget Period Data',
                    shouldSort: false
                });
            }
            if(document.getElementById('input_budget-included_wallet')){
                const includedWalletEl = document.getElementById('input_budget-included_wallet');
                budgetIncludedWalletChoice = new Choices(includedWalletEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false
                });
                budgetIncludedWalletChoice.passedElement.element.addEventListener('showDropdown', (event) => {
                    // Disable Data List
                    let excluded = budgetExcludedWalletChoice.getValue();
                    let excludedUuid = excluded.length > 0 ? excluded.map(val => val.value) : [];
                    // Selected Data List
                    let included = budgetIncludedWalletChoice.getValue();
                    let includedUuid = included.length > 0 ? included.map(val => val.value) : [];

                    let selection = @js($listWallet);
                    let formated = [];
                    selection.map((val, row) => {
                        let choice = [];
                        choice.push({
                            value: val.uuid,
                            label: val.name,
                            disabled: excludedUuid.includes(val.uuid),
                            selected: includedUuid.includes(val.uuid),
                        });
                        if(val.child && val.child.length > 0){
                            let childObj = (val.child).map((child) => {
                                let choiceChild = {};
                                choiceChild.value = child.uuid;
                                choiceChild.label = `${val.name} - ${child.name}`;
                                choiceChild.disabled = excludedUuid.includes(child.uuid);
                                choiceChild.selected = includedUuid.includes(child.uuid);

                                choice.push(choiceChild);
                            });
                        }

                        formated.push({
                            label: val.name,
                            id: row,
                            choices: choice
                        });
                    });

                    budgetIncludedWalletChoice.removeActiveItems();
                    budgetIncludedWalletChoice.clearChoices();
                    budgetIncludedWalletChoice.setChoices(formated);
                }, false);
            }
            if(document.getElementById('input_budget-excluded_wallet')){
                const excludedWalletEl = document.getElementById('input_budget-excluded_wallet');
                budgetExcludedWalletChoice = new Choices(excludedWalletEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false
                });

                budgetExcludedWalletChoice.passedElement.element.addEventListener('showDropdown', (event) => {
                    let excluded = budgetIncludedWalletChoice.getValue();
                    let excludedUuid = excluded.length > 0 ? excluded.map(val => val.value) : [];
                    // Selected Data List
                    let included = budgetExcludedWalletChoice.getValue();
                    let includedUuid = included.length > 0 ? included.map(val => val.value) : [];

                    let selection = @js($listWallet);
                    let formated = [];
                    selection.forEach((val, row) => {
                        let choice = [];
                        choice.push({
                            value: val.uuid,
                            label: val.name,
                            disabled: excludedUuid.includes(val.uuid),
                            selected: includedUuid.includes(val.uuid),
                        });
                        if(val.child && val.child.length > 0){
                            (val.child).forEach((child, crow) => {
                                choice.push({
                                    value: child.uuid,
                                    label: `${val.name} - ${child.name}`,
                                    disabled: excludedUuid.includes(child.uuid),
                                    selected: includedUuid.includes(child.uuid),
                                });
                            });
                        }

                        formated.push({
                            label: val.name,
                            id: row,
                            choices: choice
                        });
                    });

                    budgetExcludedWalletChoice.removeActiveItems();
                    budgetExcludedWalletChoice.clearChoices();
                    budgetExcludedWalletChoice.setChoices(formated);
                }, false);
            }
            if(document.getElementById('input_budget-included_category')){
                const includedCategoryEl = document.getElementById('input_budget-included_category');
                budgetIncludedCategoryChoice = new Choices(includedCategoryEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Category Data",
                    placeholder: true,
                    placeholderValue: 'Search for Category Data',
                    shouldSort: false
                });
                budgetIncludedCategoryChoice.passedElement.element.addEventListener('showDropdown', (event) => {
                    // Disable Data List
                    let excluded = budgetExcludedCategoryChoice.getValue();
                    let excludedUuid = [];
                    if(excluded.length > 0){
                        excluded.forEach((val) => {
                            excludedUuid.push(val.value);
                        });
                    }
                    // Selected Data List
                    let included = budgetIncludedCategoryChoice.getValue();
                    let includedUuid = [];
                    if(included.length > 0){
                        included.forEach((val) => {
                            includedUuid.push(val.value);
                        });
                    }

                    let selection = @js($listCategory);
                    let formated = [];
                    selection.forEach((val, row) => {
                        let choice = [];
                        choice.push({
                            value: val.uuid,
                            label: val.name,
                            disabled: excludedUuid.includes(val.uuid),
                            selected: includedUuid.includes(val.uuid),
                        });
                        if(val.child && val.child.length > 0){
                            (val.child).forEach((child, crow) => {
                                choice.push({
                                    value: child.uuid,
                                    label: `${val.name} - ${child.name}`,
                                    disabled: excludedUuid.includes(child.uuid),
                                    selected: includedUuid.includes(child.uuid),
                                });
                            });
                        }

                        formated.push({
                            label: val.name,
                            id: row,
                            choices: choice
                        });
                    });

                    budgetIncludedCategoryChoice.removeActiveItems();
                    budgetIncludedCategoryChoice.clearChoices();
                    budgetIncludedCategoryChoice.setChoices(formated);
                }, false);
            }
            if(document.getElementById('input_budget-excluded_category')){
                const excludedCategoryEl = document.getElementById('input_budget-excluded_category');
                budgetExcludedCategoryChoice = new Choices(excludedCategoryEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Category Data",
                    placeholder: true,
                    placeholderValue: 'Search for Category Data',
                    shouldSort: false
                });

                budgetExcludedCategoryChoice.passedElement.element.addEventListener('showDropdown', (event) => {
                    let excluded = budgetIncludedCategoryChoice.getValue();
                    let excludedUuid = [];
                    if(excluded.length > 0){
                        excluded.forEach((val) => {
                            excludedUuid.push(val.value);
                        });
                    }
                    // Selected Data List
                    let included = budgetExcludedCategoryChoice.getValue();
                    let includedUuid = [];
                    if(included.length > 0){
                        included.forEach((val) => {
                            includedUuid.push(val.value);
                        });
                    }

                    let selection = @js($listCategory);
                    let formated = [];
                    selection.forEach((val, row) => {
                        let choice = [];
                        choice.push({
                            value: val.uuid,
                            label: val.name,
                            disabled: excludedUuid.includes(val.uuid),
                            selected: includedUuid.includes(val.uuid),
                        });
                        if(val.child && val.child.length > 0){
                            (val.child).forEach((child, crow) => {
                                choice.push({
                                    value: child.uuid,
                                    label: `${val.name} - ${child.name}`,
                                    disabled: excludedUuid.includes(child.uuid),
                                    selected: includedUuid.includes(child.uuid),
                                });
                            });
                        }

                        formated.push({
                            label: val.name,
                            id: row,
                            choices: choice
                        });
                    });

                    budgetExcludedCategoryChoice.removeActiveItems();
                    budgetExcludedCategoryChoice.clearChoices();
                    budgetExcludedCategoryChoice.setChoices(formated);
                }, false);
            }
            if(document.getElementById('input_budget-included_tags')){
                const includedTagsEl = document.getElementById('input_budget-included_tags');
                budgetIncludedTagsChoice = new Choices(includedTagsEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Tags Data",
                    placeholder: true,
                    placeholderValue: 'Search for Tags Data',
                    shouldSort: false
                });
                budgetIncludedTagsChoice.passedElement.element.addEventListener('showDropdown', (event) => {
                    // Disable Data List
                    let excluded = budgetExcludedTagsChoice.getValue();
                    let excludedUuid = [];
                    if(excluded.length > 0){
                        excluded.forEach((val) => {
                            excludedUuid.push(val.value);
                        });
                    }
                    // Selected Data List
                    let included = budgetIncludedTagsChoice.getValue();
                    let includedUuid = [];
                    if(included.length > 0){
                        included.forEach((val) => {
                            includedUuid.push(val.value);
                        });
                    }

                    let selection = @js($listTag);
                    let formated = [];
                    selection.forEach((val, row) => {
                        formated.push({
                            value: val.uuid,
                            label: val.name,
                            disabled: excludedUuid.includes(val.uuid),
                            selected: includedUuid.includes(val.uuid),
                        });
                    });

                    budgetIncludedTagsChoice.removeActiveItems();
                    budgetIncludedTagsChoice.clearChoices();
                    budgetIncludedTagsChoice.setChoices(formated);
                }, false);
            }
            if(document.getElementById('input_budget-excluded_tags')){
                const excludedTagsEl = document.getElementById('input_budget-excluded_tags');
                budgetExcludedTagsChoice = new Choices(excludedTagsEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Tags Data",
                    placeholder: true,
                    placeholderValue: 'Search for Tags Data',
                    shouldSort: false
                });

                budgetExcludedTagsChoice.passedElement.element.addEventListener('showDropdown', (event) => {
                    let excluded = budgetIncludedTagsChoice.getValue();
                    let excludedUuid = [];
                    if(excluded.length > 0){
                        excluded.forEach((val) => {
                            excludedUuid.push(val.value);
                        });
                    }
                    // Selected Data List
                    let included = budgetExcludedTagsChoice.getValue();
                    let includedUuid = [];
                    if(included.length > 0){
                        included.forEach((val) => {
                            includedUuid.push(val.value);
                        });
                    }

                    let selection = @js($listTag);
                    let formated = [];
                    selection.forEach((val, row) => {
                        formated.push({
                            value: val.uuid,
                            label: val.name,
                            disabled: excludedUuid.includes(val.uuid),
                            selected: includedUuid.includes(val.uuid),
                        });
                    });

                    budgetExcludedTagsChoice.removeActiveItems();
                    budgetExcludedTagsChoice.clearChoices();
                    budgetExcludedTagsChoice.setChoices(formated);
                }, false);
            }
            // iMask
            if(document.getElementById('input_budget-amount')){
                budgetAmountMask = IMask(document.getElementById('input_budget-amount'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: true,  // disallow negative
                    radix: '.',  // fractional delimiter
                });
            }

            if(document.getElementById('budget-form')){
                document.getElementById('budget-form').addEventListener('submit', (e) => {
                    e.preventDefault();
                    console.log('Budget form is being submited');

                    if(e.target.querySelector('button[type="submit"]')){
                        e.target.querySelector('button[type="submit"]').innerHTML = `
                            <span class=" tw__flex tw__items-center tw__gap-2">
                                <i class="bx bx-loader-alt bx-spin"></i>
                                <span>Loading</span>    
                            </span>
                        `;
                        e.target.querySelector('button[type="submit"]').disabled = true;
                    }
                });
            }
        });
    </script>
@endpush