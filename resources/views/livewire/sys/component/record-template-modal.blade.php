<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <form id="recordTemplate-form">
        <div class="modal fade" wire:init="openModal()" wire:ignore.self id="modal-recordTemplate" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" x-data="{
            init(){
                this.selectedRecordType = 'income';
                this.selectedExtraType = 'amount';
                this.is_mobile = navigator.userAgent.toLowerCase().match(/mobile/i) ? true : false;
            }
        }">
            <div class="modal-dialog modal-dialog-centered modal-lg" :class="{'modal-dialog-scrollable': is_mobile}" role="document">
                <div class="modal-content">
                    <div class="modal-header tw__pb-2">
                        <h5 class="modal-title" id="modalCenterTitle">{{ $recordTemplateTitle }}</h5>
                        <button type="button" class="btn-close" aria-label="Close" x-on:click="@this.closeModal()"></button>
                    </div>
                    <div class="modal-body tw__p-0">
                        <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col tw__grid-cols-2 lg:tw__grid-cols-4">
                            {{-- Left Side --}}
                            <div class=" tw__p-6 tw__col-span-2 tw__self-center">
                                {{-- Record Type --}}
                                <div class=" tw__text-center tw__mb-4">
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" class="record_template-type btn" data-value="income" x-on:click="selectedRecordType = 'income'" :class="[(selectedRecordType === 'income' ? 'btn-secondary' : 'btn-outline-secondary'), (is_mobile ? 'btn-sm' : '')]">Income</a>
                                        <a href="javascript:void(0)" class="record_template-type btn" data-value="transfer" x-on:click="selectedRecordType = 'transfer'" :class="[(selectedRecordType === 'transfer' ? 'btn-secondary' : 'btn-outline-secondary'), (is_mobile ? 'btn-sm' : '')]">Transfer</a>
                                        <a href="javascript:void(0)" class="record_template-type btn" data-value="expense" x-on:click="selectedRecordType = 'expense';" :class="[(selectedRecordType === 'expense' ? 'btn-secondary' : 'btn-outline-secondary'), (is_mobile ? 'btn-sm' : '')]">Expense</a>
                                    </div>
                                </div>

                                {{-- Category --}}
                                <div class="form-group tw__mb-4" x-show="selectedRecordType !== 'transfer' ? true : false">
                                    <label for="input_record_template-category_id">Category</label>
                                    <div wire:ignore>
                                        <select class="form-control" id="input_record_template-category_id" name="category_id" placeholder="Search for Category Data">
                                            <option value="" {{ $recordTemplateCategory == '' ? 'selected' : '' }}>Search for Category Data</option>
                                            @foreach ($listCategory as $category)
                                                <optgroup label="{{ $category->name }}">
                                                    <option value="{{ $category->uuid }}" {{ !empty($recordTemplateCategory) && $category->uuid === $recordTemplateCategory ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @if ($category->child()->exists())
                                                        @foreach ($category->child as $child)
                                                            <option value="{{ $child->uuid }}" {{ !empty($recordTemplateCategory) && $child->uuid === $recordTemplateCategory ? 'selected' : '' }}>{{ $category->name }} - {{ $child->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('recordTemplateCategory')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Wallet --}}
                                <div class="form-group tw__mb-4">
                                    <label for="input_record_template-wallet_id" x-text="selectedRecordType === 'income' || selectedRecordType === 'expense' ? 'Wallet' : 'From'"></label>
                                    <div wire:ignore>
                                        <select class="form-control" id="input_record_template-wallet_id" name="wallet_id" placeholder="Search for Wallet Data">
                                            <option value="" {{ $recordTemplateWallet == '' ? 'selected' : '' }}>Search for Wallet Data</option>
                                            @foreach ($listWallet as $wallet)
                                                <optgroup label="{{ $wallet->name }}">
                                                    <option value="{{ $wallet->uuid }}" {{ !empty($recordTemplateWallet) && $wallet->uuid === $recordTemplateWallet ? 'selected' : '' }}>{{ $wallet->name }}</option>
                                                    @if ($wallet->child()->exists())
                                                        @foreach ($wallet->child as $child)
                                                            <option value="{{ $child->uuid }}" {{ !empty($recordTemplateWallet) && $child->uuid === $recordTemplateWallet ? 'selected' : '' }}>{{ $wallet->name }} - {{ $child->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('recordTemplateWallet')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Wallet Transfer --}}
                                <div class="" x-show="selectedRecordType === 'transfer' ? true : false">
                                    <div class=" tw__mb-4">
                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="btn_recordTemplate-switch">
                                            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-transfer-alt bx-rotate-90' ></i>Switch</span>
                                        </a>
                                    </div>

                                    <div class="form-group tw__mb-4" id="form-transfer">
                                        <label for="input_record_template-target">To</label>
                                        <div wire:ignore>
                                            <select class="form-control" id="input_record_template-wallet_transfer_id" name="wallet_transfer_id" placeholder="Search for Wallet Target Data">
                                                <option value="" {{ $recordTemplateWalletTransfer == '' ? 'selected' : '' }}>Search for Wallet Target Data</option>
                                                @foreach ($listWallet as $wallet)
                                                    <optgroup label="{{ $wallet->name }}">
                                                        <option value="{{ $wallet->uuid }}" {{ !empty($recordTemplateWalletTransfer) && $wallet->uuid === $recordTemplateWalletTransfer ? 'selected' : '' }}>{{ $wallet->name }}</option>
                                                        @if ($wallet->child()->exists())
                                                            @foreach ($wallet->child as $child)
                                                                <option value="{{ $child->uuid }}" {{ !empty($recordTemplateWalletTransfer) && $child->uuid === $recordTemplateWalletTransfer ? 'selected' : '' }}>{{ $wallet->name }} - {{ $child->name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>

                                        @error('recordTemplateWalletTransfer')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Amount --}}
                                <div class="form-group tw__mb-4" id="form-amount">
                                    <label for="input_record_template-amount">Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="input_group-amount">
                                            <i class="bx" :class="selectedRecordType === 'income' ? 'bx-plus' : (selectedRecordType === 'expense' ? 'bx-minus' : 'bx-transfer')"></i>
                                        </span>
                                        <input type="text" inputmode="numeric" class="form-control @error('recordTemplateAmount') is-invalid @enderror" name="amount" id="input_record_template-amount" placeholder="Amount" @input.debounce="templateCalculateFinal(selectedExtraType)">
                                    </div>

                                    @error('recordTemplateAmount')
                                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                                    @enderror
                                </div>

                                {{-- Extra Amount --}}
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input_record_template-extra">Extra Amount</label>
                                            <input type="text" inputmode="numeric" class="form-control" name="extra" id="input_record_template-extra" placeholder="Extra Amount" @input.debounce="templateCalculateFinal(selectedExtraType)">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="input_record_template-final">Final Amount</label>
                                            <input type="text" inputmode="numeric" class="form-control" name="final" id="input_record_template-final" placeholder="Final Amount" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <small class="text-muted">
                                            <span>(</span>
                                            <a href="javascript:void(0)" class="record_template_extra-type" data-value="amount" x-on:click="selectedExtraType = 'amount';templateCalculateFinal(selectedExtraType)" :class="selectedExtraType !== 'amount' ? 'tw__text-slate-400' : 'active'">Amount</a>
                                            <span>/</span>
                                            <a href="javascript:void(0)" class="record_template_extra-type" data-value="percentage" x-on:click="selectedExtraType = 'percentage';templateCalculateFinal(selectedExtraType)" :class="selectedExtraType !== 'percentage' ? 'tw__text-slate-400' : 'active'">Percentage</a>
                                            <span>)</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                            {{-- Right Side --}}
                            <div class=" tw__p-6 tw__col-span-2 tw__bg-slate-100 tw__flex tw__items-center">
                                <div class=" tw__w-full">
                                    {{-- Name --}}
                                    <div class="form-group tw__mb-4">
                                        <label for="input_record_template-name">Template Name</label>
                                        <input type="text" class="form-control @error('recordTemplateName') is-invalid @enderror" name="recordTemplateName" id="input_record_template-name" placeholder="Record Name" wire:model.defer="recordTemplateName"/>
                                        @error('recordTemplateName')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Note --}}
                                    <div class="form-group tw__mb-4">
                                        <label for="input_record_template-note">Note</label>
                                        <textarea class="form-control @error('recordTemplateNote') is-invalid @enderror" name="note" id="input_record_template-note" placeholder="Record notes..." rows="6" wire:model.defer="recordTemplateNote"></textarea>
                                        @error('recordTemplateNote')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Tags --}}
                                    <div class="form-group tw__mb-4">
                                        <label>Tags</label>
                                        <div wire:ignore>
                                            <select class="form-control" id="input_record_template-tag_id" name="tag_id" placeholder="Search for Tag Data" multiple>
                                                <option value="">Search for Tag Data</option>
                                                @foreach ($listTag as $tag)
                                                    <option value="{{ $tag->uuid }}" {{ !empty($recordTemplateTag) && $tag->uuid === $recordTemplateTag ? 'selected' : '' }}>{{ $tag->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('recordTemplateTag')
                                            <span class="invalid-feedback tw__block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Add more State --}}
                                    <div class="form-group">
                                        <div class="form-check tw__flex tw__items-center tw__gap-2">
                                            <input class="form-check-input tw__mt-0" type="checkbox" value="" id="input_record_template-more" wire:model.defer="recordTemplateMoreState">
                                            <label class="form-check-label" for="input_record_template-more">
                                                Add more record template
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
        var recordTemplateModalAmountMask = null;
        var recordTemplateModalExtraAmountMask = null;
        var recordTemplateModalFinalAmountMask = null;
        // Choice
        let recordTemplateModalCategoryChoice = null;
        let recordTemplateModalWalletChoice = null;
        let recordTemplateModalWalletTransferChoice = null;
        let recordTemplateModalTagChoice = null;

        document.addEventListener('DOMContentLoaded', (e) => {
            // iMask
            if(document.getElementById('input_record_template-amount')){
                recordTemplateModalAmountMask = IMask(document.getElementById('input_record_template-amount'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }
            if(document.getElementById('input_record_template-extra')){
                recordTemplateModalExtraAmountMask = IMask(document.getElementById('input_record_template-extra'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }
            if(document.getElementById('input_record_template-final')){
                recordTemplateModalFinalAmountMask = IMask(document.getElementById('input_record_template-final'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                    min: 0,
                });
            }

            // Choices
            if(document.getElementById('input_record_template-category_id')){
                const categoryEl = document.getElementById('input_record_template-category_id');
                recordTemplateModalCategoryChoice = new Choices(categoryEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false,
                    renderChoiceLimit: 5
                });
            }
            if(document.getElementById('input_record_template-wallet_id')){
                const walletEl = document.getElementById('input_record_template-wallet_id');
                recordTemplateModalWalletChoice = new Choices(walletEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false
                });
            }
            if(document.getElementById('input_record_template-wallet_transfer_id')){
                const walletTransferEl = document.getElementById('input_record_template-wallet_transfer_id');
                recordTemplateModalWalletTransferChoice = new Choices(walletTransferEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Target Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Target Data',
                    shouldSort: false
                });
            }
            if(document.getElementById('input_record_template-tag_id')){
                const tagEl = document.getElementById('input_record_template-tag_id');
                recordTemplateModalTagChoice = new Choices(tagEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Tag Data",
                    placeholder: true,
                    placeholderValue: 'Search for Tag Data',
                    shouldSort: false
                });
            }
            
            document.getElementById('recordTemplate-form').addEventListener('submit', (e) => {
                e.preventDefault();
                // Get Tags Data
                let selectedTags = [];
                recordTemplateModalTagChoice.getValue().forEach((e, key) => {
                    selectedTags.push(e.value);
                });

                // @this.set('user_timezone', document.getElementById('user_timezone').value);
                @this.set('recordTemplateType', document.querySelector('.record_template-type.btn.btn-secondary').dataset.value);
                @this.set('recordTemplateCategory', document.getElementById('input_record_template-category_id').value)
                @this.set('recordTemplateWallet', document.getElementById('input_record_template-wallet_id').value);
                @this.set('recordTemplateWalletTransfer', document.getElementById('input_record_template-wallet_transfer_id').value)
                @this.set('recordTemplateAmount', recordTemplateModalAmountMask.unmaskedValue);
                @this.set('recordTemplateExtraType', document.querySelector('.record_template_extra-type.active').dataset.value);
                @this.set('recordTemplateExtraAmount', recordTemplateModalExtraAmountMask.unmaskedValue);
                @this.set('recordTemplateFinalAmount', recordTemplateModalFinalAmountMask.unmaskedValue);
                @this.set('recordTemplateTag', selectedTags);
                @this.set('recordTemplateMoreState', document.getElementById('input_record_template-more').checked);
                
                @this.save();
            });
        });

        window.addEventListener('record_template_wire-init', (event) => {
            document.getElementById('btn_recordTemplate-switch').addEventListener('click', (e) => {
                let wallet = document.getElementById('input_record_template-wallet_id').value;
                let walletTransfer = document.getElementById('input_record_template-wallet_transfer_id').value;

                recordTemplateModalWalletChoice.setChoiceByValue(walletTransfer);
                recordTemplateModalWalletTransferChoice.setChoiceByValue(wallet);
            });
        });
        window.addEventListener('open-modalRecordTemplate', (event) => {
            var myModalEl = document.getElementById('modal-recordTemplate');
            var modal = new bootstrap.Modal(myModalEl)
            modal.show();
        });
        window.addEventListener('close-modalRecordTemplate', (event) => {
            var myModalEl = document.getElementById('modal-recordTemplate');
            var modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();
        });
        window.addEventListener('trigger-eventRecordTemplate', (event) => {
            let el = event.detail;
            console.log(event);
            if(el.hasOwnProperty('recordTemplateType')){
                let data = el.recordTemplateType;
                document.querySelectorAll('a.record_template-type').forEach((el) => {
                    if(data.toUpperCase() === el.textContent.toUpperCase()){
                        // Trigger Event Click
                        el.dispatchEvent(new Event('click'));
                    }
                });
            }
            if(el.hasOwnProperty('recordTemplateAmount')){
                recordTemplateModalAmountMask.value = (el.recordTemplateAmount).toString();
            }
            if(el.hasOwnProperty('recordTemplateExtraAmount')){
                recordTemplateModalExtraAmountMask.value = (el.recordTemplateExtraAmount ?? '').toString();
            }
            if(el.hasOwnProperty('recordTemplateExtraType')){
                let data = el.recordTemplateExtraType;
                document.querySelectorAll('a.record_template_extra-type').forEach((el) => {
                    if(data.toUpperCase() === el.textContent.toUpperCase()){
                        // Trigger Event Click
                        el.dispatchEvent(new Event('click'));
                    }
                });
            }
            if(el.hasOwnProperty('recordTemplateCategory')){
                recordTemplateModalCategoryChoice.setChoiceByValue(el.recordTemplateCategory);
            }
            if(el.hasOwnProperty('recordTemplateWallet')){
                recordTemplateModalWalletChoice.setChoiceByValue(el.recordTemplateWallet);
            }
            if(el.hasOwnProperty('recordTemplateWalletTransfer')){
                recordTemplateModalWalletTransferChoice.setChoiceByValue(el.recordTemplateWalletTransfer);
            }
            if(el.hasOwnProperty('recordTemplateTag')){
                recordTemplateModalTagChoice.removeActiveItems();
                if(el.recordTemplateTag){
                    (el.recordTemplateTag).forEach((tag) => {
                        recordTemplateModalTagChoice.setChoiceByValue(tag);
                    });
                }
            }

            templateCalculateFinal(el.recordType);
        });

        // Calculate Final after adding extra amount
        function templateCalculateFinal(type){
            let amount = parseFloat(recordTemplateModalAmountMask.unmaskedValue);
            if(isNaN(amount)){
                amount = 0;
            }
            let extraAmount = parseFloat(recordTemplateModalExtraAmountMask.unmaskedValue);
            if(isNaN(extraAmount)){
                extraAmount = 0;
            }

            let extra = (amount * extraAmount) / 100;
            if(type === 'amount'){
                extra = extraAmount;
            }

            let final = amount + extra;
            recordTemplateModalFinalAmountMask.value = final.toString();
        }
    </script>
@endpush