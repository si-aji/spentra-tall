<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <form id="plannedPaymentRecord-form">
        <div class="modal fade" wire:init="openModal()" wire:ignore.self id="modal-plannedPaymentRecord" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" x-data="{
            init(){
                this.selectedRecordType = 'income';
                this.selectedExtraType = 'amount';
                this.is_mobile = navigator.userAgent.toLowerCase().match(/mobile/i) ? true : false;
                this.uploadState = false;
                this.uploadProgress = 0;
            }
        }">
            <div class="modal-dialog modal-dialog-centered modal-lg" :class="{'modal-dialog-scrollable': is_mobile}" role="document">
                <div class="modal-content">
                    <div class="modal-header tw__pb-2">
                        <h5 class="modal-title" id="modalCenterTitle">{{ $plannedPaymentRecordTitle }}</h5>
                        <button type="button" class="btn-close" aria-label="Close" x-on:click="@this.closeModal()"></button>
                    </div>
                    <div class="modal-body tw__p-0">
                        <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-2 lg:tw__grid-cols-4">
                            {{-- Left Side --}}
                            <div class=" tw__p-6 tw__col-span-2 tw__self-center">
                                {{-- Record Type --}}
                                <div class=" tw__text-center tw__mb-4">
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" class="planned_payment_record-type btn" x-on:click="selectedRecordType = 'income';@this.set('plannedPaymentRecordType', 'income')" :class="[(selectedRecordType === 'income' ? 'btn-secondary' : 'btn-outline-secondary'), (is_mobile ? 'btn-sm' : '')]">Income</a>
                                        <a href="javascript:void(0)" class="planned_payment_record-type btn" x-on:click="selectedRecordType = 'transfer';@this.set('plannedPaymentRecordType', 'transfer')" :class="[selectedRecordType === 'transfer' ? 'btn-secondary' : 'btn-outline-secondary', (is_mobile ? 'btn-sm' : '')]">Transfer</a>
                                        <a href="javascript:void(0)" class="planned_payment_record-type btn" x-on:click="selectedRecordType = 'expense';@this.set('plannedPaymentRecordType', 'expense')" :class="[selectedRecordType === 'expense' ? 'btn-secondary' : 'btn-outline-secondary', (is_mobile ? 'btn-sm' : '')]">Expense</a>
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="form-group tw__mb-4" x-show="selectedRecordType !== 'transfer' ? true : false">
                                    <label for="input_planned_payment_record-category_id">Category</label>
                                    <select class="form-control" id="input_planned_payment_record-category_id" name="category_id" placeholder="Search for Category Data" x-on:change="@this.set('plannedPaymentRecordCategory', $event.target.value)">
                                        <option value="" {{ $plannedPaymentRecordCategory == '' ? 'selected' : '' }}>Search for Category Data</option>
                                        @foreach ($listCategory as $category)
                                            <optgroup label="{{ $category->name }}">
                                                <option value="{{ $category->uuid }}" {{ !empty($plannedPaymentRecordCategory) && $category->uuid === $plannedPaymentRecordCategory ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @if ($category->child()->exists())
                                                    @foreach ($category->child as $child)
                                                        <option value="{{ $child->uuid }}" {{ !empty($plannedPaymentRecordCategory) && $child->uuid === $plannedPaymentRecordCategory ? 'selected' : '' }}>{{ $category->name }} - {{ $child->name }}</option>
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                        @endforeach
                                    </select>

                                    @error('plannedPaymentRecordCategory')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Wallet --}}
                                <div class="form-group tw__mb-4">
                                    <label for="input_planned_payment_record-wallet_id" x-text="selectedRecordType === 'income' || selectedRecordType === 'expense' ? 'Wallet' : 'From'"></label>
                                    <select class="form-control" id="input_planned_payment_record-wallet_id" name="wallet_id" placeholder="Search for Wallet Data" x-on:change="@this.set('plannedPaymentRecordWallet', $event.target.value)">
                                        <option value="" {{ $plannedPaymentRecordWallet == '' ? 'selected' : '' }}>Search for Wallet Data</option>
                                        @foreach ($listWallet as $wallet)
                                            <optgroup label="{{ $wallet->name }}">
                                                <option value="{{ $wallet->uuid }}" {{ !empty($plannedPaymentRecordWallet) && $wallet->uuid === $plannedPaymentRecordWallet ? 'selected' : '' }}>{{ $wallet->name }}</option>
                                                @if ($wallet->child()->exists())
                                                    @foreach ($wallet->child as $child)
                                                        <option value="{{ $child->uuid }}" {{ !empty($plannedPaymentRecordWallet) && $child->uuid === $plannedPaymentRecordWallet ? 'selected' : '' }}>{{ $wallet->name }} - {{ $child->name }}</option>
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                        @endforeach
                                    </select>

                                    @error('plannedPaymentRecordWallet')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Wallet Transfer --}}
                                <div class="" x-show="selectedRecordType === 'transfer' ? true : false">
                                    <div class=" tw__mb-4">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" x-on:click="@this.set('plannedPaymentRecordWallet', document.getElementById('input_planned_payment_record-wallet_transfer_id').value);@this.set('plannedPaymentRecordWalletTransfer', document.getElementById('input_planned_payment_record-wallet_id').value);">
                                            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-transfer-alt bx-rotate-90' ></i>Switch</span>
                                        </a>
                                    </div>

                                    <div class="form-group tw__mb-4" id="form-transfer">
                                        <label for="input_planned_payment_record-target">To</label>
                                        <select class="form-control" id="input_planned_payment_record-wallet_transfer_id" name="wallet_transfer_id" placeholder="Search for Wallet Target Data" x-on:change="@this.set('plannedPaymentRecordWalletTransfer', $event.target.value)">
                                            <option value="" {{ $plannedPaymentRecordWalletTransfer == '' ? 'selected' : '' }}>Search for Wallet Target Data</option>
                                            @foreach ($listWallet as $wallet)
                                                <optgroup label="{{ $wallet->name }}">
                                                    <option value="{{ $wallet->uuid }}" {{ !empty($plannedPaymentRecordWalletTransfer) && $wallet->uuid === $plannedPaymentRecordWalletTransfer ? 'selected' : '' }}>{{ $wallet->name }}</option>
                                                    @if ($wallet->child()->exists())
                                                        @foreach ($wallet->child as $child)
                                                            <option value="{{ $child->uuid }}" {{ !empty($plannedPaymentRecordWalletTransfer) && $child->uuid === $plannedPaymentRecordWalletTransfer ? 'selected' : '' }}>{{ $wallet->name }} - {{ $child->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </optgroup>
                                            @endforeach
                                        </select>

                                        @error('plannedPaymentRecordWalletTransfer')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Amount --}}
                                <div class="form-group tw__mb-4" id="form-amount">
                                    <label for="input_planned_payment_record-amount">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="input_group-amount">
                                            <i class="bx" :class="selectedRecordType === 'income' ? 'bx-plus' : (selectedRecordType === 'expense' ? 'bx-minus' : 'bx-transfer')"></i>
                                        </span>
                                        <input type="text" inputmode="numeric" class="form-control @error('plannedPaymentAmount') is-invalid @enderror" name="amount" id="input_planned_payment_record-amount" placeholder="Amount" @input.debounce="plannedPaymentRecordCalculateFinal(selectedExtraType)">
                                    </div>

                                    @error('plannedPaymentAmount')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Extra Amount --}}
                                <div class="row" x-show="selectedRecordType !== 'transfer' ? true : false">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input_planned_payment_record-extra">Extra Amount</label>
                                            <input type="text" inputmode="numeric" class="form-control" name="extra" id="input_planned_payment_record-extra" placeholder="Extra Amount" @input.debounce="plannedPaymentRecordCalculateFinal(selectedExtraType)">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input_planned_payment_record-final">Final Amount</label>
                                            <input type="text" inputmode="numeric" class="form-control" name="final" id="input_planned_payment_record-final" placeholder="Final Amount" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">
                                            <span>(</span>
                                            <a href="javascript:void(0)" class="planned_payment_record_extra-type" x-on:click="selectedExtraType = 'amount';plannedPaymentRecordCalculateFinal(selectedExtraType);@this.set('plannedPaymentRecordExtraType', 'amount')" :class="selectedExtraType !== 'amount' ? 'tw__text-slate-400' : ''">Amount</a>
                                            <span>/</span>
                                            <a href="javascript:void(0)" class="planned_payment_record_extra-type" x-on:click="selectedExtraType = 'percentage';plannedPaymentRecordCalculateFinal(selectedExtraType);@this.set('plannedPaymentRecordExtraType', 'percentage')" :class="selectedExtraType !== 'percentage' ? 'tw__text-slate-400' : ''">Percentage</a>
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
                                        <label for="input_planned_payment_record-period">Date Time</label>
                                        <input type="text" class="form-control flatpickr @error('plannedPaymentRecordPeriod') is-invalid @enderror" name="period" id="input_planned_payment_record-period" placeholder="Date Time">
                                        @error('plannedPaymentRecordPeriod')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Note --}}
                                    <div class="form-group tw__mb-4">
                                        <label for="input-note">Note</label>
                                        <textarea class="form-control @error('plannedPaymentRecordNote') is-invalid @enderror" name="note" id="input-note" placeholder="Record notes..." rows="6" wire:model.defer="plannedPaymentRecordNote"></textarea>
                                        @error('plannedPaymentRecordNote')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Receipt --}}
                                    <div class="form-group tw__mb-4" x-on:livewire-upload-start="uploadState = true;uploadProgress = 0;$wire.removeReceipt()" x-on:livewire-upload-progress="uploadProgress = $event.detail.progress" x-on:livewire-upload-finish="uploadState = false">
                                        <label for="input_planned_payment_record-receipt">Receipt</label>
        
                                        <div class="d-flex">
                                            <input type="file" class="tw__hidden" id="input_planned_payment_record-receipt" name="receipt" accept=".jpeg,.jpg,.png,.pdf" max="512" wire:model.defer="plannedPaymentRecordReceipt">
            
                                            @if ($plannedPaymentRecordReceipt || $plannedPaymentRecordReceiptTemp)
                                                <label for="input_planned_payment_record-receipt" id="input_planned_payment_record-receipt_label" class="tw__cursor-pointer">
                                                    <div class="d-flex tw__items-center">
                                                        <i class="bx bx-paperclip bx-rotate-90 tw__text-4xl"></i>
                                                        {{-- <i class="bi bi-paperclip tw__text-3xl"></i> --}}
                                                        <div class="d-md-block text-left tw__ml-2">
                                                            <div class="fw-normal text-dark mb-1" id="input_planned_payment_record-receipt_label_helper">
                                                                @php
                                                                    $previewFileName = !empty($plannedPaymentRecordReceiptTemp) && empty($plannedPaymentRecordReceipt) ? basename($plannedPaymentRecordReceiptTemp) : $plannedPaymentRecordReceipt->getClientOriginalName();
                                                                    $previewFileUrl = !empty($plannedPaymentRecordReceiptTemp) && empty($plannedPaymentRecordReceipt)  ? asset($plannedPaymentRecordReceiptTemp) : $plannedPaymentRecordReceipt->temporaryUrl();
                                                                @endphp

                                                                <span class=" tw__break-all" data-original="{{ $plannedPaymentRecordReceiptTemp }}">{{ $previewFileName }}</span>
                                                                <small class="tw__block">
                                                                    <span>(</span>

                                                                    @if (empty($plannedPaymentRecordReceiptTemp) || (!empty($plannedPaymentRecordReceiptTemp) && basename($plannedPaymentRecordReceiptTemp) !== $previewFileName))
                                                                        <a href="javascript:void(0)" onclick="removeReceiptUpload()" class="tw__text-red-400 hover:tw__text-red-700 hover:tw__underline">Remove</a>
                                                                        <span>or</span>
                                                                    @endif
                                                                    
                                                                    @if (strpos($previewFileUrl, '.pdf') !== false)
                                                                        <a data-fslightbox href="#pdf-container" class="tw__text-blue-400 hover:tw__text-blue-700 hover:tw__underline">Preview</a>
                                                                    @else
                                                                        <a data-fslightbox href="{{ $previewFileUrl }}" class="tw__text-blue-400 hover:tw__text-blue-700 hover:tw__underline">Preview</a>
                                                                    @endif
                                                                    <span>)</span>
                                                                </small>
                                                                @if (strpos($previewFileUrl, '.pdf') !== false)
                                                                    <div class=" tw__hidden">
                                                                        <iframe
                                                                            class=" tw__w-full tw__min-h-[350px]"
                                                                            src="{{ $previewFileUrl }}#view=fitH"
                                                                            id="pdf-container"
                                                                            width="100%"
                                                                            height="100%"
                                                                            allow="autoplay; fullscreen"
                                                                            allowFullScreen>
                                                                        </iframe>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="text-gray small">JPG/JPEG or PNG. Max size of 1M</div>
                                                        </div>
                                                    </div>
                                                </label>
                                            @else
                                                <label for="input_planned_payment_record-receipt" id="input_planned_payment_record-receipt_label" class="tw__cursor-pointer">
                                                    <div class="d-flex tw__items-center">
                                                        <i class="bx bx-paperclip bx-rotate-90 tw__text-4xl"></i>
                                                        {{-- <i class="bi bi-paperclip tw__text-3xl"></i> --}}
                                                        <div class="d-md-block text-left tw__ml-2">
                                                            <div class="fw-normal text-dark mb-1" id="input_planned_payment_record-receipt_label_helper">Choose Image</div>
                                                            <div class="text-gray small">JPG/JPEG or PNG. Max size of 1M</div>
                                                        </div>
                                                    </div>
                                                </label>
                                            @endif
                                        </div>

                                        <div class=" tw__mt-2" x-show="uploadState">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 20%" x-bind:style="{width: `${uploadProgress}%`}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>

                                        @error('plannedPaymentRecordReceipt')
                                            @if ($plannedPaymentRecordReceipt)
                                                <span class="invalid-feedback tw__block">{{ $message }}</span>
                                            @endif
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" x-on:click="@this.closeModal()">
                            <span>Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary" x-bind:disabled="uploadState">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('javascript')
    <script>
        var plannedPaymentRecordAmountMask = null;
        var plannedPaymentRecordExtraAmountMask = null;
        var plannedPaymentRecordFinalAmountMask = null;
        window.addEventListener('plannedPaymentRecord_wire-init', (event) => {
            refreshFsLightbox();

            // iMask
            if(document.getElementById('input_planned_payment_record-amount')){
                plannedPaymentRecordAmountMask = IMask(document.getElementById('input_planned_payment_record-amount'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }
            if(document.getElementById('input_planned_payment_record-extra')){
                plannedPaymentRecordExtraAmountMask = IMask(document.getElementById('input_planned_payment_record-extra'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }
            if(document.getElementById('input_planned_payment_record-final')){
                plannedPaymentRecordFinalAmountMask = IMask(document.getElementById('input_planned_payment_record-final'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }

            // Choices
            let categoryChoice = null;
            let walletChoice = null;
            let walletTransferChoice = null;
            if(document.getElementById('input_planned_payment_record-category_id')){
                const categoryEl = document.getElementById('input_planned_payment_record-category_id');
                categoryChoice = new Choices(categoryEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false,
                    renderChoiceLimit: 5
                });
            }
            if(document.getElementById('input_planned_payment_record-wallet_id')){
                const walletEl = document.getElementById('input_planned_payment_record-wallet_id');
                walletChoice = new Choices(walletEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false
                });
            }
            if(document.getElementById('input_planned_payment_record-wallet_transfer_id')){
                const walletTransferEl = document.getElementById('input_planned_payment_record-wallet_transfer_id');
                walletTransferChoice = new Choices(walletTransferEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Target Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Target Data',
                    shouldSort: false
                });
            }

            // Flatpickr
            let defaultDate = moment().format('YYYY-MM-DD HH:mm');
            flatpickr(document.getElementById('input_planned_payment_record-period'), {
                enableTime: true,
                altInput: true,
                altFormat: "F j, Y / H:i",
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                minuteIncrement: 1,
                allowInput: true,
                defaultDate: defaultDate,
                onClose: function(selectedDates, dateStr, instance){
                    @this.set('plannedPaymentRecordPeriod', document.getElementById('input_planned_payment_record-period').value);
                    @this.set('plannedPaymentRecordPeriodChanged', true);
                }
            });

            document.getElementById('modal-plannedPaymentRecord').addEventListener('hidden.bs.modal', (e) => {
                @this.removeReceipt();
            });
        });

        // Calculate Final after adding extra amount
        function plannedPaymentRecordCalculateFinal(type){
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
            @this.set('plannedPaymentRecordFinalAmount', final);
            plannedPaymentRecordFinalAmountMask.value = final.toString();
        }

        document.addEventListener('DOMContentLoaded', (e) => {
            document.getElementById('plannedPaymentRecord-form').addEventListener('submit', (e) => {
                e.preventDefault();

                @this.set('user_timezone', document.getElementById('user_timezone').value);
                @this.set('plannedPaymentRecordAmount', plannedPaymentRecordAmountMask.unmaskedValue);
                @this.set('plannedPaymentRecordExtraAmount', plannedPaymentRecordExtraAmountMask.unmaskedValue);
                @this.set('plannedPaymentRecordPeriod', document.getElementById('input_planned_payment_record-period').value);
                
                @this.store();
            });

            // Receipt Change
            document.getElementById('input_planned_payment_record-receipt').addEventListener('change', (e) => {
                if(document.getElementById('input_planned_payment_record-receipt').closest('.form-group') && document.getElementById('input_planned_payment_record-receipt').closest('.form-group').querySelector('.invalid-feedback')){
                    document.getElementById('input_planned_payment_record-receipt').closest('.form-group').querySelector('.invalid-feedback').remove();
                }
            });
        });

        window.addEventListener('open-modalPlannedPaymentRecord', (event) => {
            var myModalEl = document.getElementById('modal-plannedPaymentRecord')
            var modal = new bootstrap.Modal(myModalEl)
            modal.show();
        });
        window.addEventListener('close-modalPlannedPaymentRecord', (event) => {
            var myModalEl = document.getElementById('modal-plannedPaymentRecord')
            var modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();

            setTimeout(() => {
                let onDetailPage = "{{ \Route::currentRouteName() === 'sys.planned-payment.show' }}";
                if(onDetailPage === "1"){
                    Livewire.emitTo('sys.planned-payment.show', 'refreshComponent');
                }
            }, 0);
        });

        window.addEventListener('trigger-eventPlannedPaymentRecord', (event) => {
            let el = event.detail;
            if(el.hasOwnProperty('plannedPaymentRecordType')){
                let data = el.plannedPaymentRecordType;
                document.querySelectorAll('a.planned_payment_record-type').forEach((el) => {
                    if(data.toUpperCase() === el.textContent.toUpperCase()){
                        // Trigger Event Click
                        el.dispatchEvent(new Event('click'));
                    }
                });
            }
            if(el.hasOwnProperty('plannedPaymentRecordAmount')){
                plannedPaymentRecordAmountMask.value = (el.plannedPaymentRecordAmount).toString();
            }
            if(el.hasOwnProperty('plannedPaymentRecordExtraAmount')){
                plannedPaymentRecordExtraAmountMask.value = (el.plannedPaymentRecordExtraAmount).toString();
            }
            if(el.hasOwnProperty('plannedPaymentRecordExtraType')){
                let data = el.plannedPaymentRecordExtraType;
                document.querySelectorAll('a.planned_payment_record_extra-type').forEach((el) => {
                    if(data.toUpperCase() === el.textContent.toUpperCase()){
                        // Trigger Event Click
                        el.dispatchEvent(new Event('click'));
                    }
                });
            }
        });

        // Remove receipt
        function removeReceiptUpload(){
            document.getElementById('input_planned_payment_record-receipt').value = null;
            document.getElementById('input_planned_payment_record-receipt_label_helper').textContent = 'Choose Image';
            document.getElementById('input_planned_payment_record-receipt').dispatchEvent(new Event('change'))

            @this.removeReceipt();
        }
    </script>
@endpush