<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <form id="plannedPayment-form">
        <div class="modal fade" wire:init="openModal()" wire:ignore.self id="modal-plannedPayment" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" x-data="{
            init(){
                this.selectedRecordType = 'income';
                this.selectedExtraType = 'amount';
                this.is_mobile = navigator.userAgent.toLowerCase().match(/mobile/i) ? true : false;
            }
        }">
            <div class="modal-dialog modal-dialog-centered modal-lg" :class="{'modal-dialog-scrollable': is_mobile}" role="document">
                <div class="modal-content">
                    <div class="modal-header tw__pb-2">
                        <h5 class="modal-title" id="modalCenterTitle">{{ $plannedPaymentTitle }}</h5>
                        <button type="button" class="btn-close" aria-label="Close" x-on:click="@this.closeModal()"></button>
                    </div>
                    <div class="modal-body tw__p-0">
                        <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-2 lg:tw__grid-cols-4">
                            {{-- Left Side --}}
                            <div class=" tw__p-6 tw__col-span-2 tw__self-center">
                                {{-- Name --}}
                                <div class="form-group tw__mb-4">
                                    <label for="input_planned_payment-name">Plan Name</label>
                                    <input type="text" class="form-control @error('plannedPaymentName') is-invalid @enderror" name="plannedPaymentName" id="input_planned_payment-name" placeholder="Planned Payment Name" wire:model.defer="plannedPaymentName"/>
                                    @error('plannedPaymentName')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Record Type --}}
                                <div class=" tw__text-center tw__mb-4">
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" class="planned_payment-type btn" data-value="income" x-on:click="selectedRecordType = 'income'" :class="[(selectedRecordType === 'income' ? 'btn-secondary' : 'btn-outline-secondary'), (is_mobile ? 'btn-sm' : '')]">Income</a>
                                        <a href="javascript:void(0)" class="planned_payment-type btn" data-value="transfer" x-on:click="selectedRecordType = 'transfer'" :class="[selectedRecordType === 'transfer' ? 'btn-secondary' : 'btn-outline-secondary', (is_mobile ? 'btn-sm' : '')]">Transfer</a>
                                        <a href="javascript:void(0)" class="planned_payment-type btn" data-value="expense" x-on:click="selectedRecordType = 'expense'" :class="[selectedRecordType === 'expense' ? 'btn-secondary' : 'btn-outline-secondary', (is_mobile ? 'btn-sm' : '')]">Expense</a>
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="form-group tw__mb-4" x-show="selectedRecordType !== 'transfer' ? true : false">
                                    <label for="input_planned_payment-category_id">Category</label>
                                    <div wire:ignore>
                                        <select class="form-control" id="input_planned_payment-category_id" name="category_id" placeholder="Search for Category Data">
                                            <option value="" {{ $plannedPaymentCategory == '' ? 'selected' : '' }}>Search for Category Data</option>
                                            @foreach ($listCategory as $category)
                                                <optgroup label="{{ $category->name }}">
                                                    <option value="{{ $category->uuid }}" {{ !empty($plannedPaymentCategory) && $category->uuid === $plannedPaymentCategory ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @if ($category->child()->exists())
                                                        @foreach ($category->child as $child)
                                                            <option value="{{ $child->uuid }}" {{ !empty($plannedPaymentCategory) && $child->uuid === $plannedPaymentCategory ? 'selected' : '' }}>{{ $category->name }} - {{ $child->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('plannedPaymentCategory')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Wallet --}}
                                <div class="form-group tw__mb-4">
                                    <label for="input_planned_payment-wallet_id" x-text="selectedRecordType === 'income' || selectedRecordType === 'expense' ? 'Wallet' : 'From'"></label>
                                    <div wire:ignore>
                                        <select class="form-control" id="input_planned_payment-wallet_id" name="wallet_id" placeholder="Search for Wallet Data">
                                            <option value="" {{ $plannedPaymentWallet == '' ? 'selected' : '' }}>Search for Wallet Data</option>
                                            @foreach ($listWallet as $wallet)
                                                <optgroup label="{{ $wallet->name }}">
                                                    <option value="{{ $wallet->uuid }}" {{ !empty($plannedPaymentWallet) && $wallet->uuid === $plannedPaymentWallet ? 'selected' : '' }}>{{ $wallet->name }}</option>
                                                    @if ($wallet->child()->exists())
                                                        @foreach ($wallet->child as $child)
                                                            <option value="{{ $child->uuid }}" {{ !empty($plannedPaymentWallet) && $child->uuid === $plannedPaymentWallet ? 'selected' : '' }}>{{ $wallet->name }} - {{ $child->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('plannedPaymentWallet')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Wallet Transfer --}}
                                <div class="" x-show="selectedRecordType === 'transfer' ? true : false">
                                    <div class=" tw__mb-4">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="btn_plannedPayment-switch">
                                            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-transfer-alt bx-rotate-90' ></i>Switch</span>
                                        </a>
                                    </div>

                                    <div class="form-group tw__mb-4" id="form-transfer">
                                        <label for="input_planned_payment-target">To</label>
                                        <div wire:ignore>
                                            <select class="form-control" id="input_planned_payment-wallet_transfer_id" name="wallet_transfer_id" placeholder="Search for Wallet Target Data">
                                                <option value="" {{ $plannedPaymentWalletTransfer == '' ? 'selected' : '' }}>Search for Wallet Target Data</option>
                                                @foreach ($listWallet as $wallet)
                                                    <optgroup label="{{ $wallet->name }}">
                                                        <option value="{{ $wallet->uuid }}" {{ !empty($plannedPaymentWalletTransfer) && $wallet->uuid === $plannedPaymentWalletTransfer ? 'selected' : '' }}>{{ $wallet->name }}</option>
                                                        @if ($wallet->child()->exists())
                                                            @foreach ($wallet->child as $child)
                                                                <option value="{{ $child->uuid }}" {{ !empty($plannedPaymentWalletTransfer) && $child->uuid === $plannedPaymentWalletTransfer ? 'selected' : '' }}>{{ $wallet->name }} - {{ $child->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>

                                        @error('plannedPaymentWalletTransfer')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Amount --}}
                                <div class="form-group tw__mb-4" id="form-amount">
                                    <label for="input_planned_payment-amount">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="input_group-amount">
                                            <i class="bx" :class="selectedRecordType === 'income' ? 'bx-plus' : (selectedRecordType === 'expense' ? 'bx-minus' : 'bx-transfer')"></i>
                                        </span>
                                        <input type="text" inputmode="numeric" class="form-control @error('plannedPaymentAmount') is-invalid @enderror" name="amount" id="input_planned_payment-amount" placeholder="Amount" @input.debounce="plannedPaymentCalculateFinal(selectedExtraType)">
                                    </div>

                                    @error('plannedPaymentAmount')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Extra Amount --}}
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input_planned_payment-extra">Extra Amount</label>
                                            <input type="text" inputmode="numeric" class="form-control" name="extra" id="input_planned_payment-extra" placeholder="Extra Amount" @input.debounce="plannedPaymentCalculateFinal(selectedExtraType)">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input_planned_payment-final">Final Amount</label>
                                            <input type="text" inputmode="numeric" class="form-control" name="final" id="input_planned_payment-final" placeholder="Final Amount" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">
                                            <span>(</span>
                                            <a href="javascript:void(0)" class="planned_payment_extra-type" data-value="amount" x-on:click="selectedExtraType = 'amount';plannedPaymentCalculateFinal(selectedExtraType)" :class="selectedExtraType !== 'amount' ? 'tw__text-slate-400' : 'active'">Amount</a>
                                            <span>/</span>
                                            <a href="javascript:void(0)" class="planned_payment_extra-type" data-value="percentage" x-on:click="selectedExtraType = 'percentage';plannedPaymentCalculateFinal(selectedExtraType)" :class="selectedExtraType !== 'percentage' ? 'tw__text-slate-400' : 'active'">Percentage</a>
                                            <span>)</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            {{-- Right Side --}}
                            <div class=" tw__p-6 tw__col-span-2 tw__bg-slate-100 tw__flex tw__items-center">
                                <div class=" tw__w-full">
                                    {{-- Period --}}
                                    <div class="form-group tw__mb-4">
                                        <label for="input_planned_payment-period">Date Time</label>
                                        <input type="text" class="form-control flatpickr @error('plannedPaymentPeriod') is-invalid @enderror" name="period" id="input_planned_payment-period" placeholder="Planned Payment Start Date Time">
                                        @error('plannedPaymentPeriod')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Repeat --}}
                                    <div class="form-group tw__mb-4">
                                        <label>Repeat every</label>
                                        <div class="row">
                                            <div class="col-12 col-lg-4 tw__mb-4 lg:tw__mb-0">
                                                <input type="text" inputmode="numeric" class="form-control @error('plannedPaymentRepeat') is-invalid @enderror" placeholder="Repetition" id="input_planned_payment-repeat" wire:model.defer="plannedPaymentRepeat">
                                                @error('plannedPaymentRepeat')
                                                    <span class="invalid-feedback tw__block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-lg-8">
                                                <div wire:ignore>
                                                    <select class="form-control @error('plannedPaymentRepeatType') is-invalid @enderror" id="input_planned_payment-repeat_type" name="repeat_type" placeholder="Search for Repeat Type Data">
                                                        <option value="" {{ $plannedPaymentRepeatType === '' ? 'selected' : '' }}>Search for Repeat Type Data</option>
                                                        <option value="daily" {{ $plannedPaymentRepeatType === 'daily' ? 'selected' : '' }}>Daily</option>
                                                        <option value="weekly" {{ $plannedPaymentRepeatType === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                                        <option value="monthly" {{ $plannedPaymentRepeatType === 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                        <option value="yearly" {{ $plannedPaymentRepeatType === 'yearly' ? 'selected' : '' }}>Yearly</option>
                                                    </select>
                                                </div>
                                                @error('plannedPaymentRepeatType')
                                                    <span class="invalid-feedback tw__block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Note --}}
                                    <div class="form-group tw__mb-4">
                                        <label for="input_planned_payment-note">Note</label>
                                        <textarea class="form-control @error('plannedPaymentNote') is-invalid @enderror" name="note" id="input_planned_payment-note" placeholder="Planned Payment Notes..." rows="6" wire:model.defer="plannedPaymentNote"></textarea>
                                        @error('plannedPaymentNote')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Tags --}}
                                    <div class="form-group tw__mb-4">
                                        <label>Tags</label>
                                        <div wire:ignore>
                                            <select class="form-control" id="input_planned_payment-tag_id" name="tag_id" placeholder="Search for Tag Data" multiple>
                                                <option value="">Search for Tag Data</option>
                                                @foreach ($listTag as $tag)
                                                    <option value="{{ $tag->uuid }}" {{ !empty($plannedPaymentTag) && $tag->uuid === $plannedPaymentTag ? 'selected' : '' }}>{{ $tag->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('plannedPaymentTag')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Add more State --}}
                                    <div class="form-group">
                                        <div class="form-check tw__flex tw__items-center tw__gap-2">
                                            <input class="form-check-input tw__mt-0" type="checkbox" value="" id="input_planned_payment-more" wire:model.defer="plannedPaymentMoreState">
                                            <label class="form-check-label" for="input_planned_payment-more">
                                                Add more Planned Payment
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" x-on:click="@this.closeModal()">
                            <span>Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('javascript')
    <script>
        // IMask
        var plannedPaymentAmountMask = null;
        var plannedPaymentExtraAmountMask = null;
        var plannedPaymentFinalAmountMask = null;
        // Choices
        let plannedPaymentModalCategoryChoice = null;
        let plannedPaymentModalWalletChoice = null;
        let plannedPaymentModalWalletTransferChoice = null;
        let plannedPaymentModalRepeatTypeChoice = null;
        let plannedPaymentModalTagChoice = null;

        document.addEventListener('DOMContentLoaded', (e) => {
            // iMask
            if(document.getElementById('input_planned_payment-amount')){
                plannedPaymentAmountMask = IMask(document.getElementById('input_planned_payment-amount'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }
            if(document.getElementById('input_planned_payment-extra')){
                plannedPaymentExtraAmountMask = IMask(document.getElementById('input_planned_payment-extra'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }
            if(document.getElementById('input_planned_payment-final')){
                plannedPaymentFinalAmountMask = IMask(document.getElementById('input_planned_payment-final'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }
            // Choices
            if(document.getElementById('input_planned_payment-category_id')){
                const categoryEl = document.getElementById('input_planned_payment-category_id');
                plannedPaymentModalCategoryChoice = new Choices(categoryEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false,
                    renderChoiceLimit: 5
                });
            }
            if(document.getElementById('input_planned_payment-wallet_id')){
                const walletEl = document.getElementById('input_planned_payment-wallet_id');
                plannedPaymentModalWalletChoice = new Choices(walletEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false
                });
            }
            if(document.getElementById('input_planned_payment-wallet_transfer_id')){
                const walletTransferEl = document.getElementById('input_planned_payment-wallet_transfer_id');
                plannedPaymentModalWalletTransferChoice = new Choices(walletTransferEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Target Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Target Data',
                    shouldSort: false
                });
            }
            if(document.getElementById('input_planned_payment-repeat_type')){
                const repeatTypeEl = document.getElementById('input_planned_payment-repeat_type');
                plannedPaymentModalRepeatTypeChoice = new Choices(repeatTypeEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Repeat Type Data",
                    placeholder: true,
                    placeholderValue: 'Search for Repeat Type Data',
                    shouldSort: false
                });
            }
            if(document.getElementById('input_planned_payment-tag_id')){
                const tagEl = document.getElementById('input_planned_payment-tag_id');
                plannedPaymentModalTagChoice = new Choices(tagEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Tag Data",
                    placeholder: true,
                    placeholderValue: 'Search for Tag Data',
                    shouldSort: false
                });
            }

            if(document.getElementById('modal-plannedPayment')){
                document.getElementById('modal-plannedPayment').addEventListener('hidden.bs.modal', (e) => {
                    Livewire.emitTo('sys.component.search-feature', 'refreshComponent');
                });
            }
        });

        window.addEventListener('plannedPaymentModal_wire-init', (event) => {
            // Flatpickr
            let defaultDate = moment().format('YYYY-MM-DD');
            if(@this.get('plannedPaymentPeriod')){
                if (@this.get('recordUuid')) {
                    let originalDate = momentDateTime(@this.get('plannedPaymentPeriodTemp'), 'YYYY-MM-DD');
                    let selectedDate = moment(@this.get('plannedPaymentPeriod')).format('YYYY-MM-DD');

                    defaultDate = originalDate;
                    if(@this.get('plannedPaymentPeriodChanged')){
                        defaultDate = selectedDate;
                    }
                } else {
                    defaultDate = moment(`${@this.get('plannedPaymentPeriod')}`).format('YYYY-MM-DD');
                }
            }
            flatpickr(document.getElementById('input_planned_payment-period'), {
                altInput: true,
                altFormat: "F j, Y",
                dateFormat: "Y-m-d",
                allowInput: true,
                defaultDate: defaultDate,
            });

            document.getElementById('btn_plannedPayment-switch').addEventListener('click', (e) => {
                let wallet = document.getElementById('input_planned_payment-wallet_id').value;
                let walletTransfer = document.getElementById('input_planned_payment-wallet_transfer_id').value;

                plannedPaymentModalWalletChoice.setChoiceByValue(walletTransfer);
                plannedPaymentModalWalletTransferChoice.setChoiceByValue(wallet);
            });
        });

        // Calculate Final after adding extra amount
        function plannedPaymentCalculateFinal(type){
            let amount = parseFloat(plannedPaymentAmountMask.unmaskedValue);
            if(isNaN(amount)){
                amount = 0;
            }
            let extraAmount = parseFloat(plannedPaymentExtraAmountMask.unmaskedValue);
            if(isNaN(extraAmount)){
                extraAmount = 0;
            }

            let extra = (amount * extraAmount) / 100;
            if(type === 'amount'){
                extra = extraAmount;
            }

            let final = amount + extra;
            plannedPaymentFinalAmountMask.value = final.toString();
        }

        document.addEventListener('DOMContentLoaded', (e) => {
            document.getElementById('plannedPayment-form').addEventListener('submit', (e) => {
                e.preventDefault();
                if(e.target.querySelector('button[type="submit"]')){
                    e.target.querySelector('button[type="submit"]').innerHTML = `
                        <span class=" tw__flex tw__items-center tw__gap-2">
                            <i class="bx bx-loader-alt bx-spin"></i>
                            <span>Loading</span>    
                        </span>
                    `;
                    e.target.querySelector('button[type="submit"]').disabled = true;
                }
                // Get Tags Data
                let selectedTags = [];
                plannedPaymentModalTagChoice.getValue().forEach((e, key) => {
                    selectedTags.push(e.value);
                });

                @this.set('user_timezone', document.getElementById('user_timezone').value);
                @this.set('plannedPaymentType', document.querySelector('.planned_payment-type.btn.btn-secondary').dataset.value);
                @this.set('plannedPaymentCategory', document.getElementById('input_planned_payment-category_id').value);
                @this.set('plannedPaymentWallet', document.getElementById('input_planned_payment-wallet_id').value);
                @this.set('plannedPaymentWalletTransfer', document.getElementById('input_planned_payment-wallet_transfer_id').value);
                @this.set('plannedPaymentAmount', plannedPaymentAmountMask.unmaskedValue);
                @this.set('plannedPaymentExtraAmount', plannedPaymentExtraAmountMask.unmaskedValue);
                @this.set('plannedPaymentFinalAmount', plannedPaymentFinalAmountMask.unmaskedValue);
                @this.set('plannedPaymentPeriod', document.getElementById('input_planned_payment-period').value);
                @this.set('plannedPaymentRepeatType', document.getElementById('input_planned_payment-repeat_type').value);
                @this.set('plannedPaymentExtraType', document.querySelector('.planned_payment_extra-type.active').dataset.value);
                @this.set('plannedPaymentMoreState', document.getElementById('input_planned_payment-more').checked);
                @this.set('plannedPaymentTag', selectedTags);
                
                @this.save();
            });
        });

        window.addEventListener('open-modalPlannedPayment', (event) => {
            var myModalEl = document.getElementById('modal-plannedPayment')
            var modal = new bootstrap.Modal(myModalEl)
            modal.show();
        });
        window.addEventListener('close-modalPlannedPayment', (event) => {
            var myModalEl = document.getElementById('modal-plannedPayment')
            var modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();
        });
        window.addEventListener('trigger-eventPlannedPayment', (event) => {
            let el = event.detail;
            if(el.hasOwnProperty('plannedPaymentType')){
                let data = el.plannedPaymentType;
                document.querySelectorAll('a.planned_payment-type').forEach((el) => {
                    if(data.toUpperCase() === el.textContent.toUpperCase()){
                        // Trigger Event Click
                        el.dispatchEvent(new Event('click'));
                    }
                });
            }
            if(el.hasOwnProperty('plannedPaymentAmount')){
                plannedPaymentAmountMask.value = (el.plannedPaymentAmount).toString();
            }
            if(el.hasOwnProperty('plannedPaymentExtraAmount')){
                plannedPaymentExtraAmountMask.value = (el.plannedPaymentExtraAmount).toString();
            }
            if(el.hasOwnProperty('plannedPaymentExtraType')){
                let data = el.plannedPaymentExtraType;
                document.querySelectorAll('a.planned_payment_extra-type').forEach((el) => {
                    if(data.toUpperCase() === el.textContent.toUpperCase()){
                        // Trigger Event Click
                        el.dispatchEvent(new Event('click'));
                    }
                });
            }
            if(el.hasOwnProperty('plannedPaymentCategory')){
                plannedPaymentModalCategoryChoice.setChoiceByValue(el.plannedPaymentCategory);
            }
            if(el.hasOwnProperty('plannedPaymentWallet')){
                plannedPaymentModalWalletChoice.setChoiceByValue(el.plannedPaymentWallet);
            }
            if(el.hasOwnProperty('plannedPaymentWalletTransfer')){
                plannedPaymentModalWalletTransferChoice.setChoiceByValue(el.plannedPaymentWalletTransfer);
            }
            if(el.hasOwnProperty('plannedPaymentRepeatType')){
                plannedPaymentModalRepeatTypeChoice.setChoiceByValue(el.plannedPaymentRepeatType);
            }
            if(el.hasOwnProperty('plannedPaymentTag')){
                plannedPaymentModalTagChoice.removeActiveItems();
                if(el.plannedPaymentTag){
                    (el.plannedPaymentTag).forEach((tag) => {
                        plannedPaymentModalTagChoice.setChoiceByValue(tag);
                    });
                }
            }
        });
    </script>
@endpush