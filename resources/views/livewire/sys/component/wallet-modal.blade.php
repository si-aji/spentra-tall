<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <form id="wallet-form" wire:submit.prevent="store('{{ $walletUuid }}')">
        <div class="offcanvas offcanvas-end" tabindex="-1" id="modal-wallet" aria-labelledby="offcanvasLabel" wire:init="" wire:ignore.self x-data="">
            <div class="offcanvas-header">
                <h5 id="offcanvasLabel" class="offcanvas-title">Wallet: {{ $walletTitle }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="form-group tw__mb-4">
                    <label for="input_wallet-wallet_id" data-selected="{{ $walletParent }}">Parent</label>
                    <select class="form-control @error('walletParent') is-invalid @enderror" id="input_wallet-wallet_id" name="wallet_id" placeholder="Search for Wallet Data" x-on:change="$wire.localUpdate('walletParent', $event.target.value)" {{ isset($walletUuid) && !empty($walletUuid) ? 'disabled' : '' }}>
                        <option value="" {{ $walletParent == '' ? 'selected' : '' }}>Search for Wallet Data</option>
                        @foreach ($listWallet as $wallet)
                            <option value="{{ $wallet->uuid }}" {{ !empty($walletParent) && $wallet->uuid === $walletParent ? 'selected' : '' }}>{{ $wallet->name }}</option>
                        @endforeach
                    </select>
                    @error('walletParent')
                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                    @enderror
                    @if (isset($walletUuid) && !empty($walletUuid))
                        <small class="text-muted tw__italic">**Change parent wallet on Re-order feature</small>
                    @endif
                </div>
    
                <div class="form-group tw__mb-4">
                    <label for="input_wallet-name">Name</label>
                    <input type="text" class="form-control @error('walletName') is-invalid @enderror" name="name" id="input_wallet-name" placeholder="Name" wire:model.defer="walletName" value="{{ $walletName }}">
                    @error('walletName')
                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                    @enderror
                </div>
    
                <button type="submit" class="btn btn-primary mb-2 d-grid w-100">Submit</button>
                <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
                    Cancel
                </button>
            </div>
        </div>

        @if (isset($walletModalState) && $walletModalState === 'show')
            <div class="offcanvas-backdrop fade show"></div>
        @endif
    </form>
</div>

@push('javascript')
    <script>
        window.addEventListener('wallet_wire-init', (event) => {
            console.log("Wallet Component Init");
            console.log(event);

            let walletChoice =null;
            if(document.getElementById('input_wallet-wallet_id')){
                const walletEl = document.getElementById('input_wallet-wallet_id');
                walletChoice = new Choices(walletEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false
                });
            }
            document.getElementById('modal-wallet').addEventListener('hidden.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.component.wallet-modal', 'closeModal');
            });
            document.getElementById('modal-wallet').addEventListener('shown.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.component.wallet-modal', 'localUpdate', 'walletModalState', 'show');
            });
        });

        window.addEventListener('wallet_wire-modalShow', (event) => {
            var myModalEl = document.getElementById('modal-wallet')
            var modal = new bootstrap.Offcanvas(myModalEl)
            modal.show();
        });
    </script>
@endpush