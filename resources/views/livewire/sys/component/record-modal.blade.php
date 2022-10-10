<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <form id="record-form">
        <div class="modal fade" wire:init="openModal" wire:ignore.self id="modal-record" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" x-data="{
            init(){
                this.selectedRecordType = '{{ $recordType }}';
                this.selectedExtraType = '{{ $recordExtraType }}'
            }
        }">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header tw__pb-2">
                        <h5 class="modal-title" id="modalCenterTitle">{{ $recordTitle }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal" x-on:click="
                            selectedRecordType = 'income';
                            selectedExtraType = 'amount';
                        "></button>
                    </div>
                    <div class="modal-body tw__p-0">
                        <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-2 lg:tw__grid-cols-4">
                            <div class=" tw__p-6 tw__col-span-2 tw__self-center">
                                <div class="form-group tw__mb-4">
                                    <label for="input-template">Template</label>
                                    <select class="form-control" id="input-template_id" name="template_id" placeholder="Search for Template Data" x-on:change="$wire.localUpdate('recordTemplate', $event.target.value);$wire.fetchTemplate($event.target.value)">
                                        <option value="" {{ $recordTemplate == '' ? 'selected' : '' }}>Search for Template Data</option>
                                        @foreach ($listTemplate as $template)
                                            <option value="{{ $template->uuid }}" {{ !empty($recordTemplate) && $template->uuid === $recordTemplate ? 'selected' : '' }}>{{ $template->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Record Type --}}
                                <div class=" tw__text-center tw__mb-4">
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" wire:click="localUpdate('recordType', 'income')" class="record-type btn" :class="selectedRecordType === 'income' ? 'btn-secondary' : 'btn-outline-secondary'" x-on:click="selectedRecordType = 'income'">Income</a>
                                        <a href="javascript:void(0)" wire:click="localUpdate('recordType', 'transfer')" class="record-type btn" :class="selectedRecordType === 'transfer' ? 'btn-secondary' : 'btn-outline-secondary'" x-on:click="selectedRecordType = 'transfer'">Transfer</a>
                                        <a href="javascript:void(0)" wire:click="localUpdate('recordType', 'expense')" class="record-type btn" :class="selectedRecordType === 'expense' ? 'btn-secondary' : 'btn-outline-secondary'" x-on:click="selectedRecordType = 'expense'">Expense</a>
                                    </div>
                                </div>

                                <div class="form-group tw__mb-4">
                                    <label for="input-category_id">Category</label>
                                    <select class="form-control" id="input-category_id" name="category_id" placeholder="Search for Category Data" x-on:change="$wire.localUpdate('recordCategory', $event.target.value)">
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
                                </div>

                                <div class="form-group tw__mb-4">
                                    <label for="input-wallet_id" x-text="selectedRecordType === 'income' || selectedRecordType === 'expense' ? 'Wallet' : 'From'"></label>
                                    <select class="form-control" id="input-wallet_id" name="wallet_id" placeholder="Search for Wallet Data" x-on:change="$wire.localUpdate('recordWallet', $event.target.value)">
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
                                </div>

                                <div class="" x-show="selectedRecordType === 'transfer' ? true : false">
                                    <div class=" tw__mb-4">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" x-on:click="$wire.localUpdate('recordWallet', document.getElementById('input-wallet_transfer_id').value);$wire.localUpdate('recordWalletTransfer', document.getElementById('input-wallet_id').value);">
                                            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-transfer-alt bx-rotate-90' ></i>Switch</span>
                                        </a>
                                    </div>

                                    <div class="form-group tw__mb-4" id="form-transfer">
                                        <label for="input-target">To</label>
                                        <select class="form-control" id="input-wallet_transfer_id" name="wallet_transfer_id" placeholder="Search for Wallet Target Data" x-on:change="$wire.localUpdate('recordWalletTransfer', $event.target.value)">
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
                                    </div>
                                </div>

                                <div class="form-group tw__mb-4" id="form-amount">
                                    <label for="input-amount">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="input_group-amount">
                                            <i class="bx" :class="selectedRecordType === 'income' ? 'bx-plus' : (selectedRecordType === 'expense' ? 'bx-minus' : 'bx-transfer')"></i>
                                        </span>
                                        <input type="text" inputmode="numeric" class="form-control" name="amount" id="input-amount" placeholder="Amount" wire:model.defer="recordAmount" @input.debounce="calculateFinal(selectedExtraType)">
                                    </div>
                                </div>

                                <div class="row" x-show="selectedRecordType !== 'transfer' ? true : false">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input-extra">Extra Amount</label>
                                            <input type="text" inputmode="numeric" class="form-control" name="extra" id="input-extra" placeholder="Extra Amount" wire:model.defer="recordExtraAmount" @input.debounce="calculateFinal(selectedExtraType)">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input-final">Final Amount</label>
                                            <input type="text" inputmode="numeric" class="form-control" name="final" id="input-final" placeholder="Final Amount" wire:model.defer="recordFinalAmount" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">
                                            <span>(</span>
                                            <a href="javascript:void(0)" class="record_extra-type" wire:click="localUpdate('recordExtraType', 'amount')" x-on:click="selectedExtraType = 'amount'; calculateFinal(selectedExtraType)" :class="selectedExtraType !== 'amount' ? 'tw__text-slate-400' : ''">Amount</a>
                                            <span>/</span>
                                            <a href="javascript:void(0)" class="record_extra-type" wire:click="localUpdate('recordExtraType', 'percentage')" x-on:click="selectedExtraType = 'percentage'; calculateFinal(selectedExtraType)" :class="selectedExtraType !== 'percentage' ? 'tw__text-slate-400' : ''">Percentage</a>
                                            <span>)</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <div class=" tw__p-6 tw__col-span-2 tw__bg-slate-100 tw__flex tw__items-center">
                                <div class=" tw__w-full">
                                    <div class="form-group tw__mb-4">
                                        <label for="input-period">Date Time</label>
                                        <input type="text" class="form-control flatpickr" name="period" id="input-period" placeholder="Record Date Time" wire:model.defer="recordPeriod">
                                    </div>
        
                                    <div class="form-group tw__mb-4">
                                        <label for="input-note">Note</label>
                                        <textarea class="form-control" name="note" id="input-note" placeholder="Record notes..." rows="6" wire:model.defer="recordNote"></textarea>
                                    </div>
        
                                    <div class="form-group tw__mb-4">
                                        <label for="input-receipt">Receipt</label>
        
                                        <div class="d-flex">
                                            <input type="file" class="tw__hidden" id="input-receipt" name="receipt" accept=".jpeg,.jpg,.png,.pdf" max="512" wire:model.defer="recordReceipt">
                                            {{-- <input type="file" class="tw__hidden" id="input-receipt" name="receipt" accept=".jpeg,.jpg,.png,.pdf" max="512"> --}}
            
                                            @if ($recordReceipt)
                                                <label for="input-receipt" id="input-receipt_label" class="tw__cursor-pointer">
                                                    <div class="d-flex tw__items-center">
                                                        <i class="bx bx-paperclip bx-rotate-90 tw__text-4xl"></i>
                                                        {{-- <i class="bi bi-paperclip tw__text-3xl"></i> --}}
                                                        <div class="d-md-block text-left tw__ml-2">
                                                            <div class="fw-normal text-dark mb-1" id="input-receipt_label_helper">
                                                                <span>{{ $recordReceipt->getClientOriginalName() }}</span>
                                                                <small class="tw__block">
                                                                    <span>(</span>
                                                                    <a href="javascript:void(0)" onclick="removeAvatarUpload()" class="tw__text-red-400 hover:tw__text-red-700 hover:tw__underline">Remove</a>
                                                                    <span>or</span>
                                                                    <a href="javascript:void(0)" data-src="{{ $recordReceipt->temporaryUrl() }}" @click="lightbox($event.target.dataset.src)" class="tw__text-blue-400 hover:tw__text-blue-700 hover:tw__underline">Preview</a>
                                                                    <span>)</span>
                                                                </small>
                                                            </div>
                                                            <div class="text-gray small">JPG/JPEG or PNG. Max size of 1M</div>
                                                        </div>
                                                    </div>
                                                </label>
                                            @else
                                                <label for="input-receipt" id="input-receipt_label" class="tw__cursor-pointer">
                                                    <div class="d-flex tw__items-center">
                                                        <i class="bx bx-paperclip bx-rotate-90 tw__text-4xl"></i>
                                                        {{-- <i class="bi bi-paperclip tw__text-3xl"></i> --}}
                                                        <div class="d-md-block text-left tw__ml-2">
                                                            <div class="fw-normal text-dark mb-1" id="input-receipt_label_helper">Choose Image</div>
                                                            <div class="text-gray small">JPG/JPEG or PNG. Max size of 1M</div>
                                                        </div>
                                                    </div>
                                                </label>
                                            @endif
                                        </div>
                                    </div>
        
                                    <div class="form-group">
                                        <div class="form-check tw__flex tw__items-center tw__gap-2">
                                            <input class="form-check-input tw__mt-0" type="checkbox" value="" id="input-more" wire:model.defer="recordMoreState">
                                            <label class="form-check-label" for="input-more">
                                                Add more record
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="closeModal" x-on:click="
                            selectedRecordType = 'income';
                            selectedExtraType = 'amount';
                        ">
                            Close
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
        var amountMask = null;
        var extraAmountMask = null;
        var finalAmountMask = null;
        window.addEventListener('record_wire-init', (event) => {
            if(document.getElementById('input-amount')){
                amountMask = IMask(document.getElementById('input-amount'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }
            if(document.getElementById('input-extra')){
                extraAmountMask = IMask(document.getElementById('input-extra'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }
            if(document.getElementById('input-final')){
                finalAmountMask = IMask(document.getElementById('input-final'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }

            // Flatpickr
            flatpickr(document.getElementById('input-period'), {
                enableTime: true,
                altInput: true,
                altFormat: "F j, Y / H:i",
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                minuteIncrement: 1,
                allowInput: true,
                defaultDate: {{ !empty($recordPeriod) ? '"'.date('Y-m-d H:i', strtotime($recordPeriod)).'"' : 'null' }}
            });

            // Choices
            let templateChoice =null;
            if(document.getElementById('input-template_id')){
                const templateEl = document.getElementById('input-template_id');
                templateChoice = new Choices(templateEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Template Data",
                    placeholder: true,
                    placeholderValue: 'Search for Template Data',
                    shouldSort: false
                });
            }
            let categoryChoice =null;
            if(document.getElementById('input-category_id')){
                const categoryEl = document.getElementById('input-category_id');
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
            let walletChoice =null;
            if(document.getElementById('input-wallet_id')){
                const walletEl = document.getElementById('input-wallet_id');
                walletChoice = new Choices(walletEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false
                });
            }
            let walletTransferChoice =null;
            if(document.getElementById('input-wallet_transfer_id')){
                const walletTransferEl = document.getElementById('input-wallet_transfer_id');
                walletTransferChoice = new Choices(walletTransferEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Target Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Target Data',
                    shouldSort: false
                });
            }

            // Submit
            document.getElementById('record-form').addEventListener('submit', (e) => {
                e.preventDefault();
                console.log("Form Submit");
                Livewire.emit('localUpdate', 'recordAmount', amountMask.unmaskedValue);
                Livewire.emit('localUpdate', 'recordExtraAmount', extraAmountMask.unmaskedValue);
                Livewire.emit('localUpdate', 'recordMoreState', document.getElementById('input-more').checked ? true : false)
                Livewire.emit('store');

                Livewire.emitTo('sys.component.record-modal', 'refreshComponent');

                if(!(document.getElementById('input-more').checked)){
                    Livewire.emit('closeModal');
                }
            });
        });
        window.addEventListener('close-modal', (event) => {
            console.log("Modal Close for Record");

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
        });

        function calculateFinal(type)
        {
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
            Livewire.emit('localUpdate', 'recordFinalAmount', final);
            finalAmountMask.value = final.toString();
        }
        function removeAvatarUpload(){
            document.getElementById('input-receipt').value = null;
            document.getElementById('input-receipt_label_helper').textContent = 'Choose Image';
        }

        // Handle lightbox
        function lightbox(image){
            const lightbox = new FsLightbox();
            // set up props, like sources, types, events etc.
            lightbox.props.sources = [image];
            // lightbox.props.onInit = () => console.log('Lightbox initialized!');

            lightbox.open();
        }
    </script>
@endpush