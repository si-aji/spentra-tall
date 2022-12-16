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
                                        <a href="javascript:void(0)" class="planned_payment_record-type btn" data-value="income" x-on:click="selectedRecordType = 'income'" :class="[(selectedRecordType === 'income' ? 'btn-secondary' : 'btn-outline-secondary'), (is_mobile ? 'btn-sm' : '')]">Income</a>
                                        <a href="javascript:void(0)" class="planned_payment_record-type btn" data-value="transfer" x-on:click="selectedRecordType = 'transfer'" :class="[selectedRecordType === 'transfer' ? 'btn-secondary' : 'btn-outline-secondary', (is_mobile ? 'btn-sm' : '')]">Transfer</a>
                                        <a href="javascript:void(0)" class="planned_payment_record-type btn" data-value="expense" x-on:click="selectedRecordType = 'expense'" :class="[selectedRecordType === 'expense' ? 'btn-secondary' : 'btn-outline-secondary', (is_mobile ? 'btn-sm' : '')]">Expense</a>
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="form-group tw__mb-4" x-show="selectedRecordType !== 'transfer' ? true : false">
                                    <label for="input_planned_payment_record-category_id">Category</label>
                                    <div wire:ignore>
                                        <select class="form-control" id="input_planned_payment_record-category_id" name="category_id" placeholder="Search for Category Data">
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
                                    </div>

                                    @error('plannedPaymentRecordCategory')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Wallet --}}
                                <div class="form-group tw__mb-4">
                                    <label for="input_planned_payment_record-wallet_id" x-text="selectedRecordType === 'income' || selectedRecordType === 'expense' ? 'Wallet' : 'From'"></label>
                                    <div wire:ignore>
                                        <select class="form-control" id="input_planned_payment_record-wallet_id" name="wallet_id" placeholder="Search for Wallet Data">
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
                                    </div>

                                    @error('plannedPaymentRecordWallet')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Wallet Transfer --}}
                                <div class="" x-show="selectedRecordType === 'transfer' ? true : false">
                                    <div class=" tw__mb-4">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="btn_plannedPaymentrecord-switch">
                                            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-transfer-alt bx-rotate-90' ></i>Switch</span>
                                        </a>
                                    </div>

                                    <div class="form-group tw__mb-4" id="form-transfer">
                                        <label for="input_planned_payment_record-target">To</label>
                                        <div wire:ignore>
                                            <select class="form-control" id="input_planned_payment_record-wallet_transfer_id" name="wallet_transfer_id" placeholder="Search for Wallet Target Data">
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
                                        </div>

                                        @error('plannedPaymentRecordWalletTransfer')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Amount --}}
                                <div class="form-group tw__mb-4" id="form-amount" wire:ignore>
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
                                <div class="row" wire:ignore>
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
                                            <a href="javascript:void(0)" class="planned_payment_record_extra-type" data-value="amount" x-on:click="selectedExtraType = 'amount';plannedPaymentRecordCalculateFinal(selectedExtraType)" :class="selectedExtraType !== 'amount' ? 'tw__text-slate-400' : ''">Amount</a>
                                            <span>/</span>
                                            <a href="javascript:void(0)" class="planned_payment_record_extra-type" data-value="percentage" x-on:click="selectedExtraType = 'percentage';plannedPaymentRecordCalculateFinal(selectedExtraType)" :class="selectedExtraType !== 'percentage' ? 'tw__text-slate-400' : ''">Percentage</a>
                                            <span>)</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            {{-- Right Side --}}
                            <div class=" tw__p-6 tw__col-span-2 tw__bg-slate-100 tw__flex tw__items-center">
                                <div class=" tw__w-full">
                                    {{-- Period --}}
                                    <div class="form-group tw__mb-4" wire:ignore>
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
                                                                        <a href="javascript:void(0)" onclick="plannedPaymentRecordRemoveReceipt()" class="tw__text-red-400 hover:tw__text-red-700 hover:tw__underline">Remove</a>
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

                                    {{-- Tags --}}
                                    <div class="form-group tw__mb-4">
                                        <label>Tags</label>
                                        <div wire:ignore>
                                            <select class="form-control" id="input_planned_payment_record-tag_id" name="tag_id" placeholder="Search for Tag Data" multiple>
                                                <option value="">Search for Tag Data</option>
                                                @foreach ($listTag as $tag)
                                                    <option value="{{ $tag->uuid }}" {{ !empty($plannedPaymentRecordTag) && $tag->uuid === $plannedPaymentRecordTag ? 'selected' : '' }}>{{ $tag->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('plannedPaymentRecordTag')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
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
        // IMask
        var plannedPaymentRecordAmountMask = null;
        var plannedPaymentRecordExtraAmountMask = null;
        var plannedPaymentRecordFinalAmountMask = null;
        // Choices
        let plannedPaymentRecordModalCategoryChoice = null;
        let plannedPaymentRecordModalWalletChoice = null;
        let plannedPaymentRecordModalWalletTransferChoice = null;
        let plannedPaymentRecordModalTagChoice = null;
        // Flatpickr
        let plannedPaymentRecordModalFlatpickrDateTime;
        let plannedPaymentRecordModalDefaultDate;
        let plannedPaymentRecordModalDefaultDateTemp = null;

        document.addEventListener('DOMContentLoaded', (e) => {
            plannedPaymentRecordModalDefaultDate = moment().format('YYYY-MM-DD HH:mm');
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
            if(document.getElementById('input_planned_payment_record-category_id')){
                const categoryEl = document.getElementById('input_planned_payment_record-category_id');
                plannedPaymentRecordModalCategoryChoice = new Choices(categoryEl, {
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
                plannedPaymentRecordModalWalletChoice = new Choices(walletEl, {
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
                plannedPaymentRecordModalWalletTransferChoice = new Choices(walletTransferEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Target Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Target Data',
                    shouldSort: false
                });
            }
            if(document.getElementById('input_planned_payment_record-tag_id')){
                const tagEl = document.getElementById('input_planned_payment_record-tag_id');
                plannedPaymentRecordModalTagChoice = new Choices(tagEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Tag Data",
                    placeholder: true,
                    placeholderValue: 'Search for Tag Data',
                    shouldSort: false
                });
            }
            // Flatpickr
            plannedPaymentRecordModalFlatpickrDateTime = flatpickr(document.getElementById('input_planned_payment_record-period'), {
                enableTime: true,
                altInput: true,
                altFormat: "F j, Y / H:i",
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                minuteIncrement: 1,
                allowInput: true,
                defaultDate: plannedPaymentRecordModalDefaultDate,
                maxDate: moment().format('YYYY-MM-DD 23:59'),
                onClose: function(selectedDates, dateStr, instance){
                    plannedPaymentRecordModalDefaultDate = moment(dateStr).format('YYYY-MM-DD HH:mm');
                    plannedPaymentRecordModalDefaultDateTemp = true;
                }
            });

            document.getElementById('plannedPaymentRecord-form').addEventListener('submit', (e) => {
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
                plannedPaymentRecordModalTagChoice.getValue().forEach((e, key) => {
                    selectedTags.push(e.value);
                });

                @this.set('user_timezone', document.getElementById('user_timezone').value);
                @this.set('plannedPaymentRecordType', document.querySelector('.planned_payment_record-type.btn.btn-secondary').dataset.value);
                @this.set('plannedPaymentRecordCategory', document.getElementById('input_planned_payment_record-category_id').value);
                @this.set('plannedPaymentRecordWallet', document.getElementById('input_planned_payment_record-wallet_id').value);
                @this.set('plannedPaymentRecordWalletTransfer', document.getElementById('input_planned_payment_record-wallet_transfer_id').value);
                @this.set('plannedPaymentRecordAmount', plannedPaymentRecordAmountMask.unmaskedValue);
                @this.set('plannedPaymentRecordExtraAmount', plannedPaymentRecordExtraAmountMask.unmaskedValue);
                @this.set('plannedPaymentRecordFinalAmount', plannedPaymentRecordFinalAmountMask.unmaskedValue);
                @this.set('plannedPaymentRecordPeriod', document.getElementById('input_planned_payment_record-period').value);
                @this.set('plannedPaymentRecordTag', selectedTags);
                @this.save();

                plannedPaymentRecordModalDefaultDateTemp = null;
            });

            // Receipt Change
            document.getElementById('input_planned_payment_record-receipt').addEventListener('change', (e) => {
                if(document.getElementById('input_planned_payment_record-receipt').closest('.form-group') && document.getElementById('input_planned_payment_record-receipt').closest('.form-group').querySelector('.invalid-feedback')){
                    document.getElementById('input_planned_payment_record-receipt').closest('.form-group').querySelector('.invalid-feedback').remove();
                }
            });
            // Switch Wallet
            document.getElementById('btn_plannedPaymentrecord-switch').addEventListener('click', (e) => {
                let wallet = document.getElementById('input_planned_payment_record-wallet_id').value;
                let walletTransfer = document.getElementById('input_planned_payment_record-wallet_transfer_id').value;

                plannedPaymentRecordModalWalletChoice.setChoiceByValue(walletTransfer);
                plannedPaymentRecordModalWalletTransferChoice.setChoiceByValue(wallet);
            });

        });

        window.addEventListener('plannedPaymentRecord_wire-init', (event) => {
            refreshFsLightbox();

            if(@this.get('plannedPaymentRecordAmount')){
                plannedPaymentRecordAmountMask.value = (@this.get('plannedPaymentRecordAmount')).toString();
            }
            document.getElementById('modal-plannedPaymentRecord').addEventListener('show.bs.modal', (e) => {
                plannedPaymentRecordModalDefaultDate = moment().format('YYYY-MM-DD HH:mm');
                plannedPaymentRecordModalFlatpickrDateTime.setDate(plannedPaymentRecordModalDefaultDate);
            });
            document.getElementById('modal-plannedPaymentRecord').addEventListener('hidden.bs.modal', (e) => {
                @this.removeReceipt();
                plannedPaymentRecordModalDefaultDateTemp = null;
                Livewire.emitTo('sys.component.search-feature', 'refreshComponent');
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
            if(el.hasOwnProperty('plannedPaymentRecordCategory')){
                plannedPaymentRecordModalCategoryChoice.setChoiceByValue(el.plannedPaymentRecordCategory);
            }
            if(el.hasOwnProperty('plannedPaymentRecordWallet')){
                plannedPaymentRecordModalWalletChoice.setChoiceByValue(el.plannedPaymentRecordWallet);
            }
            if(el.hasOwnProperty('plannedPaymentRecordWalletTransfer')){
                plannedPaymentRecordModalWalletTransferChoice.setChoiceByValue(el.plannedPaymentRecordWalletTransfer);
            }
            if(el.hasOwnProperty('resetPeriod')){
                plannedPaymentRecordModalFlatpickrDateTime.setDate(moment().format('YYYY-MM-DD HH:mm'));
            }
            if(el.hasOwnProperty('plannedPaymentRecordTag')){
                plannedPaymentRecordModalTagChoice.removeActiveItems();
                if(el.plannedPaymentRecordTag){
                    (el.plannedPaymentRecordTag).forEach((tag) => {
                        plannedPaymentRecordModalTagChoice.setChoiceByValue(tag);
                    });
                }
            }
        });

        // Remove receipt
        function plannedPaymentRecordRemoveReceipt(){
            document.getElementById('input_planned_payment_record-receipt').value = null;
            document.getElementById('input_planned_payment_record-receipt_label_helper').textContent = 'Choose Image';
            document.getElementById('input_planned_payment_record-receipt').dispatchEvent(new Event('change'))

            @this.removeReceipt();
        }
        // Calculate Final after adding extra amount
        function plannedPaymentRecordCalculateFinal(type){
            let amount = parseFloat(plannedPaymentRecordAmountMask.unmaskedValue);
            if(isNaN(amount)){
                amount = 0;
            }
            let extraAmount = parseFloat(plannedPaymentRecordExtraAmountMask.unmaskedValue);
            if(isNaN(extraAmount)){
                extraAmount = 0;
            }

            let extra = (amount * extraAmount) / 100;
            if(type === 'amount'){
                extra = extraAmount;
            }

            let final = amount + extra;
            plannedPaymentRecordFinalAmountMask.value = final.toString();
        }
    </script>
@endpush