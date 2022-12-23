@section('title', 'Wallet: Detail')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>
            <a href="{{ route('sys.record.index') }}">Wallet: List</a>
        </span>
        <span class="active">Detail</span>
    </h4>
@endsection

<div>
    {{-- Do your work, then step back. --}}
    <div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-arrow-back'></i>Back</span>
        </a>
        <button type="button" class="btn btn-warning" data-uuid="{{ $walletData->uuid }}" x-on:click="$wire.emitTo('sys.component.wallet-modal', 'editAction', @this.get('walletUuid'))">
            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-edit'></i>Edit</span>
        </button>
    </div>

    <div class="card tw__mt-4">
        <div class="card-body">
            <table class="table table-hover">
                <tr>
                    <th>Name</th>
                    <td>{{ ($walletData->parent()->exists() ? $walletData->parent->name.' - ' : '').($walletData->name) }}</td>
                </tr>
                <tr x-data="{toggle: false}">
                    <th>Balance</th>
                    <td>
                        <span class="tw__block" data-orig="{{ formatRupiah($walletData->getBalance()) }}" data-short="{{ formatRupiah($walletData->getBalance(), 'Rp', true) }}" x-on:click="toggle = !toggle" x-text="(toggle ? $el.dataset.orig : $el.dataset.short)">{{ formatRupiah($walletData->getBalance(), 'Rp', true) }}</span>
                    </td>
                </tr>
            </table>

            <div class="card tw__mt-4">
                <div class="card-header">
                    <h5 class="card-title">Record History</h5>
                </div>
                <div class="card-body">
                    <div id="record-container">
                        <div>
                            @for ($i = 0; $i < 3; $i++)
                                <div class=" tw__flex tw__flex-col">
                                    <div class="list-wrapper tw__flex tw__gap-2 tw__mb-4 last:tw__mb-0">
                                        <div class=" tw__p-4 tw__text-center">
                                            <div class="tw__sticky tw__top-24 md:tw__top-40 tw__flex tw__items-center tw__flex-col">
                                                <span class="tw__font-semibold tw__bg-gray-300 tw__animate-pulse tw__h-4 tw__w-8 tw__block tw__rounded tw__mr-0 tw__mb-2"></span>
                                                <div class=" tw__min-h-[40px] tw__min-w-[40px] tw__bg-gray-300 tw__bg-opacity-60 tw__rounded-full tw__flex tw__leading-none tw__items-center tw__justify-center tw__align-middle tw__animate-pulse">
                                                    <p class="tw__mb-0 tw__font-bold tw__text-xl tw__text-white"></p>
                                                </div>
                                                <span class="tw__font-semibold tw__bg-gray-300 tw__animate-pulse tw__h-3 tw__w-12 tw__block tw__rounded tw__mr-0 tw__mt-1"></span>
                                            </div>
                                        </div>
                                        <div class=" tw__bg-gray-300 tw__rounded-lg tw__w-full content-list tw__p-4 tw__h-20 tw__animate-pulse tw__self-center">
                                            
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="card-footer tw__pt-0">
                    <div class=" tw__flex tw__items-center tw__justify-between">
                        <button wire:loading.remove wire:target="loadMore" type="button" class="btn btn-primary disabled:tw__cursor-not-allowed" {{ $paginate->hasMorePages() ? '' : 'disabled' }} wire:click="loadMore">
                            <span>Load more</span>
                        </button>
                        <button wire:loading.block wire:target="loadMore" type="button" class="btn btn-primary disabled:tw__cursor-not-allowed" disabled>
                            <span class=" tw__flex tw__items-center tw__gap-2">
                                <i class="bx bx-loader-alt bx-spin"></i>
                                <span>Loading</span>
                            </span>
                        </button>
                        <span>Showing {{ $paginate->count() }} of {{ $paginate->total() }} entries</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js_plugins')
    <script src="{{ mix('assets/js/format-record.js') }}"></script>
@endsection

@section('js_inline')
    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            window.dispatchEvent(new Event('walletRecordLoadData'));
        });
        window.addEventListener('walletRecordLoadData', (e) => {
            generateRecordWalletList();
        });
        const generateRecordWalletList = () => {
            if(document.getElementById('record-container')){
                document.getElementById('record-container').innerHTML = ``;
            }

            let data = @this.get('walletRecordData');
            let paneEl = document.getElementById('record-container');
            console.log(data);

            if(data.length > 0){
                if(!paneEl.querySelector(`.content-wrapper`)){
                    recordContent = document.createElement('div');
                    recordContent.classList.add('content-wrapper');
                    recordContent.classList.add('tw__flex', 'tw__gap-4');
                    paneEl.appendChild(recordContent);
                } else {
                    recordContent = paneEl.querySelector('.content-wrapper');
                }

                let prevDate = null;
                data.forEach((val, index) => {
                    let date = val.datetime;
                    let original = val.datetime;
                    let recordDate = momentDateTime(val.datetime, 'YYYY-MM-DD');

                    if(recordDate != prevDate){
                        let listContainer = document.createElement('div');
                        listContainer.classList.add('list-wrapper', 'tw__flex', 'tw__gap-4', 'tw__mb-4', 'last:tw__mb-0');
                        listContainer.innerHTML = recordContainerFormat(val, index);
                        // Date not same with previous, generate new list
                        recordContent.appendChild(listContainer);
                        prevDate = recordDate;
                    }

                    // Append Record Item
                    let contentContainer = recordContent.querySelector(`.content-list[data-date="${momentDateTime(val.datetime, 'YYYY-MM-DD')}"]`);
                    if(contentContainer){
                        // console.log(contentContainer);
                        let item = document.createElement('div');
                        item.classList.add('tw__border-b', 'last:tw__border-b-0', 'tw__py-4', 'first:tw__pt-0', 'last:tw__pb-0');

                        // Append Action
                        let action = [];
                        // Detail Action
                        action.push(`
                            <li>
                                <a class="dropdown-item tw__text-blue-400" href="{{ route('sys.record.index') }}/${val.uuid}">
                                    <span class=" tw__flex tw__items-center"><i class="bx bx-show tw__mr-2"></i>Detail</span>
                                </a>
                            </li>
                        `);

                        // Append Item
                        item.innerHTML = recordContentFormat(val, index, action);
                        contentContainer.appendChild(item);
                    }
                });
            } else {
                // Data is empty
                recordContent = document.createElement('div');
                recordContent.classList.add('alert', 'alert-primary', 'tw__mb-0');
                recordContent.setAttribute('role', 'alert');
                recordContent.innerHTML = `
                    <div class=" tw__flex tw__items-center">
                        <i class="bx bx-error tw__mr-2"></i>
                        <div class="tw__block tw__font-bold tw__uppercase">
                            Attention!
                        </div>
                    </div>
                    <span class="tw__block tw__italic">No data found</span>
                `;

                paneEl.appendChild(recordContent);
            }
        };
    </script>
@endsection