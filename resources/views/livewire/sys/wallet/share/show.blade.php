@section('title', 'Wallet Share: Detail')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>
            <a href="{{ route('sys.wallet.share.index') }}">Wallet Share: List</a>
        </span>
        <span class="active">Detail</span>
    </h4>
@endsection

<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-arrow-back'></i>Back</span>
                </a>
                <button type="button" class="btn btn-warning" data-uuid="{{ $walletShareData->uuid }}" x-on:click="$wire.emitTo('sys.component.wallet-share-modal', 'editAction', @this.get('walletShareUuid'), true);">
                    <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-edit'></i>Edit</span>
                </button>
            </h5>
        </div>
        <div class="card-body">
            <table class="table tabl-hover table-striped table-bordered">
                <tr>
                    <th>Token</th>
                    <td>
                        <a href="{{ route('shr.wallet-share', $walletShareData->token) }}" target="_blank">{{ $walletShareData->token }}</a>
                    </td>
                </tr>
                <tr>
                    <th>Account</th>
                    <td>
                        {{ implode(', ', $walletShareData->walletShareDetail()->pluck('name')->toArray()) }}
                    </td>
                </tr>
                <tr>
                    <th>Time Limit</th>
                    <td>
                        <small class=" bg-{{ $walletShareData->share_limit === 'lifetime' ? 'success' : ''}} tw__px-2 tw__py-1 tw__rounded tw__text-white">{{ ucwords($walletShareData->share_limit) }}</small>
                    </td>
                </tr>
                <tr>
                    <th>Passphrase</th>
                    <td>
                        @if ($walletShareData->passphrase)
                            <button type="button" class="btn btn-sm btn-outline-primary" data-clipboard-text="{{ siacryption($walletShareData->passphrase) }}" id="wallet_share-clipboard_btn" title="">
                                <span class=" tw__flex tw__items-center tw__gap-1">
                                    <i class="bx bxs-lock-alt"></i>
                                    <span>Passphrase</span>
                                </span>
                            </button>
                        @else
                            <span>-</span>
                        @endif    
                    </td>
                </tr>
                <tr>
                    <th>Note</th>
                    <td>{{ $walletShareData->note ?? '-' }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@section('js_plugins')
    {{-- Clipboard --}}
    <script src="{{ mix('assets/plugins/clipboard/clipboard.min.js') }}"></script>
@endsection

@section('js_inline')
    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            if(document.getElementById('wallet_share-clipboard_btn')){
                var passphraseClipboard = new ClipboardJS('#wallet_share-clipboard_btn');
                passphraseClipboard.on('success', (e) => {
                    let el = e.trigger;
                    clipboardTooltip(el, 'show', 'Copied!');
                    el.addEventListener('mouseout', (e) => {
                        clipboardTooltip(el, 'hide');
                    }, { once: true });
                });
            }
        });
    </script>
@endsection
