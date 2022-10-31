<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <form id="wallet_share-form" wire:submit.prevent="save()">
        <div class="offcanvas offcanvas-end" tabindex="-1" id="modal-wallet_share" aria-labelledby="offcanvasLabel" wire:init="" wire:ignore.self x-data="{
            passphraseState: false
        }">
            <div class="offcanvas-header">
                <h5 id="offcanvasLabel" class="offcanvas-title">Wallet Share</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                {{-- Token --}}
                <div class="form-group tw__mb-4">
                    <label>Token</label>
                    <input type="text" class="form-control @error('walletShareToken') is-invalid @enderror" placeholder="Share Token" readonly>
                    @error('walletShareToken')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                    <small class="text-muted tw__block tw__italic">**Share token will be generated automatically by system</small>
                </div>

                {{-- Passphrase --}}
                <div class="form-group tw__mb-4">
                    <label>Passphrase</label>
                    <input type="text" class="form-control @error('walletSharePassphrase') is-invalid @enderror" placeholder="Passphrase" @input.debounce="$el.value.length > 0 ? (passphraseState = true) : (passphraseState = false)">
                    @error('walletSharePassphrase')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                    <small class="text-muted tw__block tw__italic" x-text="`**${passphraseState ? 'With passphrase, everyone need to enter the right passphrase to open your data' : 'No passphrase mean whoever had the link, they have access to your data'}`"></small>
                </div>

                {{-- Note --}}
                <div class="form-group tw__mb-4">
                    <label>Note</label>
                    <textarea class="form-control @error('walletShareDescription') is-invalid @enderror" placeholder="Some notes to remember"></textarea>
                    @error('walletShareDescription')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Time limit --}}
                <div class="form-group tw__mb-4">
                    <label>Time Limit</label>
                    <div wire:ignore>
                        <select class="form-control" id="input_wallet_share-time_limit">
                            <option value="">Search for Time Limit</option>
                            <option value="lifetime" selected>Lifetime</option>
                            <option value="period" disabled>Until specific Date</option>
                            <option value="open_time" disabled>Until opened several time</option>
                        </select>
                    </div>
                    @error('walletShareTimeLimit')
                        <span class="invalid-feedback tw__block">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Item --}}
                <div class="form-group">
                    <label>Share Item</label>
                    <div wire:ignore>
                        <select class="form-control" id="input_wallet_share-wallet_id" name="wallet_id" placeholder="Search for Wallet Data" multiple>
                            <option value="">Search for Wallet Data</option>
                            @foreach ($listWallet as $wallet)
                                <optgroup label="{{ $wallet->name }}">
                                    <option value="{{ $wallet->uuid }}">{{ $wallet->name }}</option>
                                    @if ($wallet->child()->exists())
                                        @foreach ($wallet->child as $child)
                                            <option value="{{ $child->uuid }}">{{ $wallet->name }} - {{ $child->name }}</option>
                                        @endforeach
                                    @endif
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    @error('walletShareItem')
                        <span class="invalid-feedback tw__block">{{ $message }}</span>
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
        // Choices
        let walletShareModalTimeLimitChoice = null;
        let walletShareModalWalletChoice = null;
        document.addEventListener('DOMContentLoaded', (e) => {
            // Choices
            if(document.getElementById('input_wallet_share-time_limit')){
                const timeLimitEl = document.getElementById('input_wallet_share-time_limit');
                walletShareModalTimeLimitChoice = new Choices(timeLimitEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Time Limit",
                    placeholder: true,
                    placeholderValue: 'Search for Time Limit',
                    shouldSort: false
                });
            }
            if(document.getElementById('input_wallet_share-wallet_id')){
                const walletEl = document.getElementById('input_wallet_share-wallet_id');
                walletShareModalWalletChoice = new Choices(walletEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Wallet Data",
                    placeholder: true,
                    placeholderValue: 'Search for Wallet Data',
                    shouldSort: false
                });
            }
        });

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