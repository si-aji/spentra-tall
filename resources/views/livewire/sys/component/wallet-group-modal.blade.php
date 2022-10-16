<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <form id="wallet_group-form" wire:submit.prevent="store()">
        <div class="offcanvas offcanvas-end" tabindex="-1" id="modal-wallet_group" aria-labelledby="offcanvasLabel" wire:init="" wire:ignore.self x-data="">
            <div class="offcanvas-header">
                <h5 id="offcanvasLabel" class="offcanvas-title">Wallet Group: {{ $walletGroupTitle }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="form-group tw__mb-4">
                    <label for="input_wallet_group-name">Name</label>
                    <input type="text" class="form-control @error('walletGroupName') is-invalid @enderror" name="name" id="input_wallet_group-name" placeholder="Name" wire:model.defer="walletGroupName" value="{{ $walletGroupName }}">
                    @error('walletGroupName')
                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group tw__mb-4">
                    <label for="input_wallet_group-wallet_id">List</label>
                    <select class="form-control @error('walletGroupList') is-invalid @enderror" id="input_wallet_group-wallet_id" name="wallet_id[]" placeholder="Search for Wallet Data" multiple>
                        <option value="">Search for Wallet Data</option>
                        @foreach ($listWallet as $wallet)
                            <optgroup label="{{ $wallet->name }}">
                                <option value="{{ $wallet->uuid }}" {{ !empty($walletGroupList) && is_array($walletGroupList) && in_array($wallet->uuid, $walletGroupList) ? 'selected' : '' }}>{{ $wallet->name }}</option>
                                @if ($wallet->child()->exists())
                                    @foreach ($wallet->child as $child)
                                        <option value="{{ $child->uuid }}" {{ !empty($walletGroupList) && is_array($walletGroupList) && in_array($child->uuid, $walletGroupList) ? 'selected' : '' }}>{{ $wallet->name }} - {{ $child->name }}</option>
                                    @endforeach
                                @endif
                            </optgroup>
                        @endforeach
                    </select>
                    @error('walletUuid')
                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                    @enderror
                </div>
    
                <button type="submit" class="btn btn-primary mb-2 d-grid w-100">Submit</button>
                <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
                    Cancel
                </button>
            </div>
        </div>

        @if (isset($walletGroupModalState) && $walletGroupModalState === 'show')
            <div class="offcanvas-backdrop fade show"></div>
        @endif
    </form>
</div>

@push('javascript')
    <script>
        window.addEventListener('wallet_group_wire-init', (event) => {
            let walletChoice = null;
            if(document.getElementById('input_wallet_group-wallet_id')){
                const walletEl = document.getElementById('input_wallet_group-wallet_id');
                walletChoice = new Choices(walletEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false,
                    resetScrollPosition: false
                });
                walletChoice.passedElement.element.addEventListener('hideDropdown', (e) => {
                    let selectedWallet = [];
                    if(walletChoice !== null){
                        walletChoice.getValue().forEach((e, key) => {
                            selectedWallet.push(e.value);
                        });
                    }

                    Livewire.emitTo('sys.component.wallet-group-modal', 'localUpdate', 'walletGroupList', selectedWallet);
                });
                walletChoice.passedElement.element.addEventListener('removeItem', (e) => {
                    let selectedWallet = [];
                    if(walletChoice !== null){
                        walletChoice.getValue().forEach((e, key) => {
                            selectedWallet.push(e.value);
                        });
                    }

                    Livewire.emitTo('sys.component.wallet-group-modal', 'localUpdate', 'walletGroupList', selectedWallet);
                });
            }
            
            document.getElementById('modal-wallet_group').addEventListener('hidden.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.component.wallet-group-modal', 'closeModal');
            });
            document.getElementById('modal-wallet_group').addEventListener('shown.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.component.wallet-group-modal', 'localUpdate', 'walletGroupModalState', 'show');
            });
        });

        window.addEventListener('wallet_group_wire-modalShow', (event) => {
            var myModalEl = document.getElementById('modal-wallet_group')
            var modal = new bootstrap.Offcanvas(myModalEl)
            modal.show();
        });
        window.addEventListener('wallet_group_wire-modalHide', (event) => {
            var myModalEl = document.getElementById('modal-wallet_group')
            var modal = bootstrap.Offcanvas.getInstance(myModalEl);
            modal.hide();
        });
    </script>
@endpush