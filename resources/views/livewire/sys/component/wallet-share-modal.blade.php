<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <form id="wallet_share-form" wire:submit.prevent="save()">
        <div class="offcanvas offcanvas-end" tabindex="-1" id="modal-wallet_share" aria-labelledby="offcanvasLabel" wire:init="" wire:ignore.self x-data="">
            <div class="offcanvas-header">
                <h5 id="offcanvasLabel" class="offcanvas-title">Wallet Share</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control @error('walletShareName') is-invalid @enderror" placeholder="Name">
                    @error('walletShareName')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </form>

    @if (isset($walletShareModalState) && $walletShareModalState === 'show')
        <div class="offcanvas-backdrop fade show"></div>
    @endif
</div>

@push('javascript')
    <script>
        document.addEventListener('wallet_share_wire-init', () => {
            document.getElementById('modal-wallet_share').addEventListener('hidden.bs.offcanvas', (e) => {
                @this.call('closeModal')
            });
            document.getElementById('modal-wallet_share').addEventListener('shown.bs.offcanvas', (e) => {
                @this.set('walletShareModalState', 'show');
            });
        });
    </script>
@endpush