<div>
    {{-- Because she competes with no one, no one can compete with her. --}}
    <form id="wallet_balance-form">
        <div class="modal fade" wire:init="openModal" wire:ignore.self id="modal-wallet_balance" tabindex="-1" aria-hidden="true" x-data="">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header tw__pb-2">
                        <h5 class="modal-title" id="modalCenterTitle">Balance Adjustment: {{ isset($walletBalanceData) && !empty($walletBalanceData) ? (($walletBalanceData->parent()->exists() ? $walletBalanceData->parent->name.' - ' : '').$walletBalanceData->name) : '-' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Current Balance --}}
                        <div class="form-group tw__mb-4" id="form-current">
                            <label for="input_wallet_balance-amount">Current Balance</label>
                            <input type="text" inputmode="numeric" class="form-control" name="current" id="input_wallet_balance-current" placeholder="Current Balance" readonly>
                        </div>
                        {{-- Actual Balance --}}
                        <div class="form-group" id="form-actual">
                            <label for="input_wallet_balance-amount">Actual Balance</label>
                            <input type="text" inputmode="numeric" class="form-control @error('walletActualBalance') is-invalid @enderror" name="actual" id="input_wallet_balance-actual" placeholder="Actual Balance">
                            @error('walletActualBalance')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
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
        let balanceMask = null;
        let balanceActualMask = null;
        window.addEventListener('wallet_balance_wire-init', (event) => {
            document.getElementById('modal-wallet').addEventListener('hidden.bs.modal', (e) => {
                Livewire.emitTo('sys.component.wallet-balance-modal', 'closeModal');
            });
            document.getElementById('modal-wallet').addEventListener('shown.bs.modal', (e) => {
                Livewire.emitTo('sys.component.wallet-balance-modal', 'localUpdate', 'walletBalanceModalState', 'show');
            });

            if(document.getElementById('input_wallet_balance-current')){
                balanceMask = IMask(document.getElementById('input_wallet_balance-current'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: true,  // disallow negative
                    radix: '.',  // fractional delimiter
                });
            }
            if(document.getElementById('input_wallet_balance-actual')){
                balanceActualMask = IMask(document.getElementById('input_wallet_balance-actual'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: true,  // disallow negative
                    radix: '.',  // fractional delimiter
                });
            }
            balanceMask.value = `${@this.get('walletBalance')}`;
            balanceActualMask.value = `${@this.get('walletActualBalance')}`;

            document.getElementById('modal-wallet_balance').addEventListener('shown.bs.modal', (e) => {
                document.getElementById('input_wallet_balance-actual').focus();
                document.getElementById('input_wallet_balance-actual').select();
            });
        });

        document.addEventListener('DOMContentLoaded', (e) => {
            if(document.getElementById('wallet_balance-form')){
                document.getElementById('wallet_balance-form').addEventListener('submit', (e) => {
                    e.preventDefault();

                    let amount = balanceActualMask.unmaskedValue;
                    @this.set('walletActualBalance', amount);
                    @this.set('user_timezone', document.getElementById('user_timezone').value);
                    @this.set('recordPeriod', moment().format('YYYY-MM-DD HH:mm:ss'))
                    @this.save();
                });
            }
        });

        window.addEventListener('wallet_balance_wire-modalShow', (event) => {
            var myModalEl = document.getElementById('modal-wallet_balance')
            var modal = new bootstrap.Modal(myModalEl)
            modal.show();
        });
        window.addEventListener('wallet_balance_wire-modalHide', (event) => {
            var myModalEl = document.getElementById('modal-wallet_balance')
            var modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();
        });
    </script>
@endpush