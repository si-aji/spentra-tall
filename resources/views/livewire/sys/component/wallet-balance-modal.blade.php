<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <form id="wallet_balance-form">
        <div class="modal fade" wire:init="openModal" wire:ignore.self id="modal-wallet_balance" tabindex="-1" aria-hidden="true" x-data="">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header tw__pb-2">
                        <h5 class="modal-title" id="modalCenterTitle">Balance Adjustment: {{ isset($walletBalance) && !empty($walletBalance) ? (($walletBalance->parent()->exists() ? $walletBalance->parent->name.' - ' : '').$walletBalance->name) : '-' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group tw__mb-4" id="form-current">
                            <label for="input-amount">Current Balance</label>
                            <input type="text" inputmode="numeric" class="form-control" name="current" id="input-current" placeholder="Current Balance" readonly>
                        </div>
                        <div class="form-group" id="form-actual">
                            <label for="input-amount">Actual Balance</label>
                            <input type="text" inputmode="numeric" class="form-control" name="actual" id="input-actual" placeholder="Actual Balance">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="closeModal">
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
        window.addEventListener('wallet_balance_wire-init', (event) => {
            console.log("Wallet Balance Init");

            document.getElementById('modal-wallet').addEventListener('hidden.bs.modal', (e) => {
                Livewire.emitTo('sys.component.wallet-balance-modal', 'closeModal');
            });
            document.getElementById('modal-wallet').addEventListener('shown.bs.modal', (e) => {
                Livewire.emitTo('sys.component.wallet-balance-modal', 'localUpdate', 'walletBalanceModalState', 'show');
            });
        });

        window.addEventListener('wallet_balance_wire-modalShow', (event) => {
            console.log("Wallet Balance Modal Show");

            var myModalEl = document.getElementById('modal-wallet_balance')
            var modal = new bootstrap.Modal(myModalEl)
            modal.show();
        });
    </script>
@endpush