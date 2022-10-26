<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    {{-- <form id="record-form" wire:submit.prevent="store()"> --}}
    <form id="record-form">
        <div class="modal fade" wire:init="openModal()" wire:ignore.self id="modal-record" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" x-data="{
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
                        <h5 class="modal-title" id="modalCenterTitle">{{ $recordTitle }}</h5>
                        <button type="button" class="btn-close" aria-label="Close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body tw__p-0">
                        <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-2 lg:tw__grid-cols-4">
                            {{-- Left Side --}}
                            <div class=" tw__p-6 tw__col-span-2 tw__self-center">
                                {{-- Record Template --}}
                                <div class="form-group tw__mb-4" wire:ignore>
                                    <label for="input_record-template">Template</label>
                                    <select class="form-control" id="input_record-template_id" name="template_id" placeholder="Search for Template Data" x-on:change="@this.fetchDataTemplate($event.target.value)">
                                        <option value="" {{ $recordTemplate == '' ? 'selected' : '' }}>Search for Template Data</option>
                                        @foreach ($listTemplate as $template)
                                            <option value="{{ $template->uuid }}" {{ !empty($recordTemplate) && $template->uuid === $recordTemplate ? 'selected' : '' }}>{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Record Type --}}
                                <div class=" tw__text-center tw__mb-4">
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" class="record-type btn" data-value="income" x-on:click="selectedRecordType = 'income'" :class="[(selectedRecordType === 'income' ? 'btn-secondary' : 'btn-outline-secondary'), (is_mobile ? 'btn-sm' : '')]">Income</a>
                                        <a href="javascript:void(0)" class="record-type btn" data-value="transfer" x-on:click="selectedRecordType = 'transfer'" :class="[(selectedRecordType === 'transfer' ? 'btn-secondary' : 'btn-outline-secondary'), (is_mobile ? 'btn-sm' : '')]">Transfer</a>
                                        <a href="javascript:void(0)" class="record-type btn" data-value="expense" x-on:click="selectedRecordType = 'expense'" :class="[(selectedRecordType === 'expense' ? 'btn-secondary' : 'btn-outline-secondary'), (is_mobile ? 'btn-sm' : '')]">Expense</a>
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="form-group tw__mb-4" x-show="selectedRecordType !== 'transfer' ? true : false" wire:ignore>
                                    <label for="input_record-category_id">Category</label>
                                    <select class="form-control" id="input_record-category_id" name="category_id" placeholder="Search for Category Data">
                                        <option value="" {{ $recordCategory == '' ? 'selected' : '' }}>Search for Category Data</option>
                                        @foreach ($listCategory as $category)
                                            <optgroup label="{{ $category->name }}">
                                                <option value="{{ $category->uuid }}" {{ !empty($recordCategory) && $category->uuid === $recordCategory ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @if ($category->child()->exists())
                                                    @foreach ($category->child as $child)
                                                        <option value="{{ $child->uuid }}" {{ !empty($recordCategory) && $child->uuid === $recordCategory ? 'selected' : '' }}>{{ $category->name }} - {{ $child->name }}</option>
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                        @endforeach
                                    </select>

                                    @error('recordCategory')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Wallet --}}
                                <div class="form-group tw__mb-4" wire:ignore>
                                    <label for="input_record-wallet_id" x-text="selectedRecordType === 'income' || selectedRecordType === 'expense' ? 'Wallet' : 'From'"></label>
                                    <select class="form-control" id="input_record-wallet_id" name="wallet_id" placeholder="Search for Wallet Data">
                                        <option value="" {{ $recordWallet == '' ? 'selected' : '' }}>Search for Wallet Data</option>
                                        @foreach ($listWallet as $wallet)
                                            <optgroup label="{{ $wallet->name }}">
                                                <option value="{{ $wallet->uuid }}" {{ !empty($recordWallet) && $wallet->uuid === $recordWallet ? 'selected' : '' }}>{{ $wallet->name }}</option>
                                                @if ($wallet->child()->exists())
                                                    @foreach ($wallet->child as $child)
                                                        <option value="{{ $child->uuid }}" {{ !empty($recordWallet) && $child->uuid === $recordWallet ? 'selected' : '' }}>{{ $wallet->name }} - {{ $child->name }}</option>
                                                    @endforeach
                                                @endif
                                            </optgroup>
                                        @endforeach
                                    </select>

                                    @error('recordWallet')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Wallet Transfer --}}
                                <div class="" x-show="selectedRecordType === 'transfer' ? true : false">
                                    <div class=" tw__mb-4">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="btn_record-switch">
                                            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-transfer-alt bx-rotate-90' ></i>Switch</span>
                                        </a>
                                    </div>

                                    <div class="form-group tw__mb-4" id="form-transfer" wire:ignore.self>
                                        <label for="input_record-target">To</label>
                                        <select class="form-control" id="input_record-wallet_transfer_id" name="wallet_transfer_id" placeholder="Search for Wallet Target Data">
                                            <option value="" {{ $recordWalletTransfer == '' ? 'selected' : '' }}>Search for Wallet Target Data</option>
                                            @foreach ($listWallet as $wallet)
                                                <optgroup label="{{ $wallet->name }}">
                                                    <option value="{{ $wallet->uuid }}" {{ !empty($recordWalletTransfer) && $wallet->uuid === $recordWalletTransfer ? 'selected' : '' }}>{{ $wallet->name }}</option>
                                                    @if ($wallet->child()->exists())
                                                        @foreach ($wallet->child as $child)
                                                            <option value="{{ $child->uuid }}" {{ !empty($recordWalletTransfer) && $child->uuid === $recordWalletTransfer ? 'selected' : '' }}>{{ $wallet->name }} - {{ $child->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </optgroup>
                                            @endforeach
                                        </select>

                                        @error('recordWalletTransfer')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Amount --}}
                                <div class="form-group tw__mb-4" id="form-amount">
                                    <label for="input_record-amount">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="input_group-amount">
                                            <i class="bx" :class="selectedRecordType === 'income' ? 'bx-plus' : (selectedRecordType === 'expense' ? 'bx-minus' : 'bx-transfer')"></i>
                                        </span>
                                        <input type="text" inputmode="numeric" class="form-control @error('recordAmount') is-invalid @enderror" name="amount" id="input_record-amount" placeholder="Amount" @input.debounce="calculateFinal(selectedExtraType)">
                                    </div>

                                    @error('recordAmount')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Extra Amount --}}
                                <div class="row" x-show="selectedRecordType !== 'transfer' ? true : false">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input_record-extra">Extra Amount</label>
                                            <input type="text" inputmode="numeric" class="form-control" name="extra" id="input_record-extra" placeholder="Extra Amount" @input.debounce="calculateFinal(selectedExtraType)">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input_record-final">Final Amount</label>
                                            <input type="text" inputmode="numeric" class="form-control" name="final" id="input_record-final" placeholder="Final Amount" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">
                                            <span>(</span>
                                            <a href="javascript:void(0)" class="record_extra-type" data-value="amount" x-on:click="selectedExtraType = 'amount';calculateFinal(selectedExtraType)" :class="selectedExtraType !== 'amount' ? 'tw__text-slate-400' : 'active'">Amount</a>
                                            <span>/</span>
                                            <a href="javascript:void(0)" class="record_extra-type" data-value="percentage" x-on:click="selectedExtraType = 'percentage';calculateFinal(selectedExtraType)" :class="selectedExtraType !== 'percentage' ? 'tw__text-slate-400' : 'active'">Percentage</a>
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
                                        <label for="input_record-period">Date Time</label>
                                        <input type="text" class="form-control flatpickr @error('recordPeriod') is-invalid @enderror" name="period" id="input_record-period" placeholder="Record Date Time">
                                        @error('recordPeriod')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Note --}}
                                    <div class="form-group tw__mb-4">
                                        <label for="input_record-note">Note</label>
                                        <textarea class="form-control @error('recordNote') is-invalid @enderror" name="note" id="input_record-note" placeholder="Record notes..." rows="6" wire:model.defer="recordNote"></textarea>
                                        @error('recordNote')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Receipt --}}
                                    <div class="form-group tw__mb-4" x-on:livewire-upload-start="uploadState = true;uploadProgress = 0;$wire.removeReceipt()" x-on:livewire-upload-progress="uploadProgress = $event.detail.progress" x-on:livewire-upload-finish="uploadState = false">
                                        <label for="input_record-receipt">Receipt</label>
        
                                        <div class="d-flex">
                                            <input type="file" class="tw__hidden" id="input_record-receipt" name="receipt" accept=".jpeg,.jpg,.png,.pdf" max="512" wire:model.defer="recordReceipt">
            
                                            @if ($recordReceipt || $recordReceiptTemp)
                                                <label for="input_record-receipt" id="input_record-receipt_label" class="tw__cursor-pointer">
                                                    <div class="d-flex tw__items-center">
                                                        <i class="bx bx-paperclip bx-rotate-90 tw__text-4xl"></i>
                                                        {{-- <i class="bi bi-paperclip tw__text-3xl"></i> --}}
                                                        <div class="d-md-block text-left tw__ml-2">
                                                            <div class="fw-normal text-dark mb-1" id="input_record-receipt_label_helper">
                                                                @php
                                                                    $previewFileName = !empty($recordReceiptTemp) && empty($recordReceipt) ? basename($recordReceiptTemp) : $recordReceipt->getClientOriginalName();
                                                                    $previewFileUrl = !empty($recordReceiptTemp) && empty($recordReceipt)  ? asset($recordReceiptTemp) : $recordReceipt->temporaryUrl();
                                                                @endphp

                                                                <span class=" tw__break-all" data-original="{{ $recordReceiptTemp }}">{{ $previewFileName }}</span>
                                                                <small class="tw__block">
                                                                    <span>(</span>

                                                                    @if (empty($recordReceiptTemp) || (!empty($recordReceiptTemp) && basename($recordReceiptTemp) !== $previewFileName))
                                                                        <a href="javascript:void(0)" onclick="recordRemoveReceiptUpload()" class="tw__text-red-400 hover:tw__text-red-700 hover:tw__underline">Remove</a>
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
                                                <label for="input_record-receipt" id="input_record-receipt_label" class="tw__cursor-pointer">
                                                    <div class="d-flex tw__items-center">
                                                        <i class="bx bx-paperclip bx-rotate-90 tw__text-4xl"></i>
                                                        {{-- <i class="bi bi-paperclip tw__text-3xl"></i> --}}
                                                        <div class="d-md-block text-left tw__ml-2">
                                                            <div class="fw-normal text-dark mb-1" id="input_record-receipt_label_helper">Choose Image</div>
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

                                        @error('recordReceipt')
                                            @if ($recordReceipt)
                                                <span class="invalid-feedback tw__block">{{ $message }}</span>
                                            @endif
                                        @enderror
                                    </div>

                                    {{-- Add more State --}}
                                    <div class="form-group">
                                        <div class="form-check tw__flex tw__items-center tw__gap-2">
                                            <input class="form-check-input tw__mt-0" type="checkbox" value="" id="input_record-more" wire:model.defer="recordMoreState">
                                            <label class="form-check-label" for="input_record-more">
                                                Add more record
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" wire:click="closeModal">
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
        var amountMask = null;
        var extraAmountMask = null;
        var finalAmountMask = null;

        let recordModalTemplateChoice = null;
        let recordModalCategoryChoice = null;
        let recordModalWalletChoice = null;
        let recordModalWalletTransferChoice = null;

        window.addEventListener('recordModal_wire-init', (event) => {
            refreshFsLightbox();

            // iMask
            if(document.getElementById('input_record-amount')){
                amountMask = IMask(document.getElementById('input_record-amount'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }
            if(document.getElementById('input_record-extra')){
                extraAmountMask = IMask(document.getElementById('input_record-extra'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }
            if(document.getElementById('input_record-final')){
                finalAmountMask = IMask(document.getElementById('input_record-final'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }

            // Flatpickr
            let defaultDate = moment().format('YYYY-MM-DD HH:mm');
            if(@this.get('recordPeriod')){
                if (@this.get('recordUuid')) {
                    let originalDate = momentDateTime(@this.get('recordPeriodTemp'), 'YYYY-MM-DD HH:mm');
                    let selectedDate = moment(@this.get('recordPeriod')).format('YYYY-MM-DD HH:mm');

                    defaultDate = originalDate;
                    if(@this.get('recordPeriodChanged')){
                        defaultDate = selectedDate;
                    }
                } else {
                    defaultDate = moment(`${@this.get('recordPeriod')}`).format('YYYY-MM-DD HH:mm');
                }
            }
            flatpickr(document.getElementById('input_record-period'), {
                enableTime: true,
                altInput: true,
                altFormat: "F j, Y / H:i",
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                minuteIncrement: 1,
                allowInput: true,
                defaultDate: defaultDate,
                // onClose: function(selectedDates, dateStr, instance){
                //     @this.localUpdate('recordPeriod', document.getElementById('input_record-period').value);
                //     @this.localUpdate('recordPeriodChanged', true);
                // }
            });

            document.getElementById('btn_record-switch').addEventListener('click', (e) => {
                let wallet = document.getElementById('input_record-wallet_id').value;
                let walletTransfer = document.getElementById('input_record-wallet_transfer_id').value;

                walletChoice.setChoiceByValue(walletTransfer);
                walletTransferChoice.setChoiceByValue(wallet);
            });

            document.getElementById('modal-record').addEventListener('hidden.bs.modal', (e) => {
                @this.removeReceipt();
            });
        });

        document.addEventListener('DOMContentLoaded', (e) => {
            // Choices
            if(document.getElementById('input_record-template_id')){
                const templateEl = document.getElementById('input_record-template_id');
                recordModalTemplateChoice = new Choices(templateEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Template Data",
                    placeholder: true,
                    placeholderValue: 'Search for Template Data',
                    shouldSort: false
                });
            }
            if(document.getElementById('input_record-category_id')){
                const categoryEl = document.getElementById('input_record-category_id');
                recordModalCategoryChoice = new Choices(categoryEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false,
                    renderChoiceLimit: 5
                });
            }
            if(document.getElementById('input_record-wallet_id')){
                const walletEl = document.getElementById('input_record-wallet_id');
                recordModalWalletChoice = new Choices(walletEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false
                });
            }
            if(document.getElementById('input_record-wallet_transfer_id')){
                const walletTransferEl = document.getElementById('input_record-wallet_transfer_id');
                recordModalWalletTransferChoice = new Choices(walletTransferEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Target Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Target Data',
                    shouldSort: false
                });
            }
            
            document.getElementById('record-form').addEventListener('submit', (e) => {
                e.preventDefault();

                @this.set('user_timezone', document.getElementById('user_timezone').value);
                @this.set('recordType', document.querySelector('.record-type.btn.btn-secondary').dataset.value);
                @this.set('recordCategory', document.getElementById('input_record-category_id').value);
                @this.set('recordWallet', document.getElementById('input_record-wallet_id').value);
                @this.set('recordWalletTransfer', document.getElementById('input_record-wallet_transfer_id').value)
                @this.set('recordAmount', amountMask.unmaskedValue);
                @this.set('recordExtraType', document.querySelector('.record_extra-type.active').dataset.value);
                @this.set('recordExtraAmount', extraAmountMask.unmaskedValue);
                @this.set('recordPeriod', document.getElementById('input_record-period').value);
                @this.set('recordFinalAmount', finalAmountMask.unmaskedValue);
                @this.set('recordMoreState', document.getElementById('input_record-more').checked);
                
                @this.save();
            });

            // Receipt Change
            document.getElementById('input_record-receipt').addEventListener('change', (e) => {
                if(document.getElementById('input_record-receipt').closest('.form-group') && document.getElementById('input_record-receipt').closest('.form-group').querySelector('.invalid-feedback')){
                    document.getElementById('input_record-receipt').closest('.form-group').querySelector('.invalid-feedback').remove();
                }
            });
        });
        window.addEventListener('open-modal', (event) => {
            var myModalEl = document.getElementById('modal-record')
            var modal = new bootstrap.Modal(myModalEl)
            modal.show();
        });
        window.addEventListener('close-modal', (event) => {
            var myModalEl = document.getElementById('modal-record')
            var modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();
        });
        window.addEventListener('trigger-event', (event) => {
            let el = event.detail;
            if(el.hasOwnProperty('recordType')){
                let data = el.recordType;
                document.querySelectorAll('a.record-type').forEach((el) => {
                    if(data.toUpperCase() === el.textContent.toUpperCase()){
                        // Trigger Event Click
                        el.dispatchEvent(new Event('click'));
                    }
                });
            }
            if(el.hasOwnProperty('recordAmount')){
                amountMask.value = (el.recordAmount).toString();
            }
            if(el.hasOwnProperty('recordExtraAmount')){
                extraAmountMask.value = (el.recordExtraAmount).toString();
            }
            if(el.hasOwnProperty('recordExtraType')){
                let data = el.recordExtraType;
                document.querySelectorAll('a.record_extra-type').forEach((el) => {
                    if(data.toUpperCase() === el.textContent.toUpperCase()){
                        // Trigger Event Click
                        el.dispatchEvent(new Event('click'));
                    }
                });
            }
            if(el.hasOwnProperty('recordWallet')){
                recordModalWalletChoice.setChoiceByValue(el.recordWallet);
            }
            if(el.hasOwnProperty('recordWalletTransfer')){
                recordModalWalletTransferChoice.setChoiceByValue(el.recordWalletTransfer);
            }
        });

        // Calculate Final after adding extra amount
        function calculateFinal(type){
            let amount = parseFloat(amountMask.unmaskedValue);
            if(isNaN(amount)){
                amount = 0;
            }
            let extraAmount = parseFloat(extraAmountMask.unmaskedValue);
            if(isNaN(extraAmount)){
                extraAmount = 0;
            }

            let extra = (amount * extraAmount) / 100;
            if(type === 'amount'){
                extra = extraAmount;
            }

            let final = amount + extra;
            finalAmountMask.value = final.toString();
        }
        // Remove receipt
        function recordRemoveReceiptUpload(){
            @this.removeReceipt();

            document.getElementById('input_record-receipt').value = null;
            document.getElementById('input_record-receipt_label_helper').textContent = 'Choose Image';
            document.getElementById('input_record-receipt').dispatchEvent(new Event('change'))
        }
    </script>
@endpush