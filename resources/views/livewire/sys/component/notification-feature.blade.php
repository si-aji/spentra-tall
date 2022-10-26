<div>
    {{-- The whole world belongs to you. --}}
    <div>
        <div class="offcanvas offcanvas-end" data-bs-backdrop="false" tabindex="-1" id="modal-notification" aria-labelledby="offcanvasLabel" wire:init="" wire:ignore.self x-data="">
            <div class="offcanvas-header">
                <h5 id="offcanvasLabel" class="offcanvas-title">Notification Panel</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                {{-- Overdue --}}
                <div class="" id="overdue-container">
                    <div class=" tw__flex tw__items-center tw__gap-2 tw__p-2 tw__rounded tw__bg-red-100 tw__mb-2">
                        <i class='bx bx-alarm-exclamation'></i>
                        <h6 class=" tw__mb-0">Overdue</h6>
                    </div>
                    <div class="notif-container">
                        <div class=" tw__p-2 tw__bg-gray-100 tw__rounded">No available data</div>
                    </div>
                    @if (!empty($paginateOverdue))
                        <div class=" tw__mt-1 tw__flex tw__items-center tw__justify-between">
                            <button type="button" class="btn btn-sm btn-primary disabled:tw__cursor-not-allowed" {{ $paginateOverdue->hasMorePages() ? '' : 'disabled' }} x-on:click="@this.loadMoreOverdue(1)">Load more</button>
                            <span>Showing {{ $paginateOverdue->count() }} of {{ $paginateOverdue->total() }} entries</span>
                        </div>
                    @endif
                </div>

                {{-- Today --}}
                <div class=" tw__mt-6" id="today-container">
                    <div class=" tw__flex tw__items-center tw__gap-2 tw__p-2 tw__rounded tw__bg-[#696cff] tw__bg-opacity-[0.16] tw__mb-2">
                        <i class='bx bx-alarm'></i>
                        <h6 class=" tw__mb-0">Today</h6>
                    </div>
                    <div class="notif-container">
                        <div class=" tw__p-2 tw__bg-gray-100 tw__rounded">No available data</div>
                    </div>
                    @if ($paginateToday)
                        <div class=" tw__mt-1 tw__flex tw__items-center tw__justify-between">
                            <button type="button" class="btn btn-sm btn-primary disabled:tw__cursor-not-allowed" {{ $paginateToday->hasMorePages() ? '' : 'disabled' }} x-on:click="@this.loadMoreToday()">Load more</button>
                            <span>Showing {{ $paginateToday->count() }} of {{ $paginateToday->total() }} entries</span>
                        </div>
                    @endif
                </div>

                {{-- Upcomming --}}
                <div class=" tw__mt-6" id="upcomming-container">
                    <div class=" tw__flex tw__items-center tw__gap-2 tw__p-2 tw__rounded tw__bg-blue-100 tw__mb-2">
                        <i class='bx bx-alarm-snooze'></i>
                        <h6 class=" tw__mb-0">Upcomming</h6>
                    </div>
                    <div class="notif-container">
                        <div class=" tw__p-2 tw__bg-gray-100 tw__rounded">No available data</div>
                    </div>
                    @if ($paginateUpcomming)
                        <div class=" tw__mt-1 tw__flex tw__items-center tw__justify-between">
                            <button type="button" class="btn btn-sm btn-primary disabled:tw__cursor-not-allowed" {{ $paginateUpcomming->hasMorePages() ? '' : 'disabled' }} x-on:click="@this.loadMoreUpcomming()">Load more</button>
                            <span>Showing {{ $paginateUpcomming->count() }} of {{ $paginateUpcomming->total() }} entries</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if (isset($notificationModalState) && $notificationModalState === 'show')
            <div class="offcanvas-backdrop fade show"></div>
        @endif
    </div>
</div>

@push('javascript')
    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            var notificationCanvas = document.getElementById('modal-notification')
            notificationCanvas.addEventListener('show.bs.offcanvas', function () {
                window.dispatchEvent(new Event('notificationGenerateOverdueList'));
            });
            notificationCanvas.addEventListener('hidden.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.component.notification-feature', 'closeModal');
            });
        });

        window.addEventListener('show-modalNotification', (event) => {
            var myModalEl = document.getElementById('modal-notification')
            var modal = new bootstrap.Offcanvas(myModalEl)
            modal.show();
        });
        window.addEventListener('close-modalNotification', (event) => {
            var myModalEl = document.getElementById('modal-notification')
            var modal = bootstrap.Offcanvas.getInstance(myModalEl);
            modal.hide();
        });

        window.addEventListener('notificationGenerateOverdueList', (e) => {
            generatePlannedPaymentList('overdue', @this.get('dataOverdue'));
            generatePlannedPaymentList('today', @this.get('dataToday'));
            generatePlannedPaymentList('upcomming', @this.get('dataUpcomming'));
        });
        const generatePlannedPaymentList = (pane, data) => {
            let paneEl = document.getElementById(`${pane}-container`);
            let container = paneEl.querySelector('.notif-container');

            container.innerHTML = ``;
            if(data.length > 0){
                let items = [];
                data.forEach((val, index) => {
                    let note = ``;
                    let walletName = `${val.wallet.parent ? `${val.wallet.parent.name} - ` : ''}${val.wallet.name}`;
                    let toWalletName = val.to_wallet_id ? `${val.wallet_transfer_target.parent ? `${val.wallet_transfer_target.parent.name} - ` : ''}${val.wallet_transfer_target.name}` : null;
                    if(val.note){
                        note = `
                            <small class=" tw__opacity-70">
                                <i class="bx bx-paragraph tw__mr-1"></i>
                                <span>${val.note}</span>
                            </small>
                        `;
                    }
                    let item = `
                        <div class=" tw__p-2 last:tw__border-b-0">
                            <div class=" tw__flex tw__justify-between">
                                <span>${val.name}</span>
                                <span class=" tw__whitespace-nowrap ${val.type === 'income' ? 'tw__text-green-600' : val.type === 'transfer' ? 'tw__text-gray-600' : 'tw__text-red-600'}">${val.type !== 'income' ? `(${formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))})` : formatRupiah(parseFloat(val.amount) + parseFloat(val.extra_amount))}</span>
                            </div>
                            ${note}
                            <small class="tw__flex tw__items-center tw__leading-none tw__gap-1 tw__flex-wrap"><span class=""><i class="bx bx-wallet-alt tw__mr-1"></i></span>${walletName} ${toWalletName !== null ? `<small><i class="bx bx-caret-right"></i></small>${toWalletName}` : ''}</small>
                            <small class="tw__flex tw__items-center tw__gap-2"><i class="bx bx-time"></i>${momentDateTime(val.next_date, 'DD MMM, YYYY')}</small>
                            <div class=" tw__mt-1 tw__flex tw__gap-2">
                                <button type="button" class="btn btn-sm tw__bg-[#696cff]/75 hover:tw__bg-[#696cff] tw__transition-all tw__text-white tw__w-full" onclick="@this.call('closeModal');Livewire.emitTo('sys.component.planned-payment-record-modal', 'editAction', '${val.planned_payment_record && val.planned_payment_record.length > 0 ? val.planned_payment_record[0]['uuid'] : ''}')">Approve</button>
                                <a href="{{ route('sys.planned-payment.index') }}/${val.uuid}" class="btn btn-sm tw__bg-[#8493a3]/75 hover:tw__bg-[#8493a3] tw__transition-all tw__text-white tw__w-full">Detail</a>
                            </div>
                        </div>
                    `;
                    
                    items.push(item);
                });
                container.innerHTML = `<div class=" tw__p-2 tw__bg-gray-100 tw__rounded">${items.join('')}</div>`;
            } else {
                container.innerHTML = `<div class=" tw__p-2 tw__bg-gray-100 tw__rounded">No available data</div>`;
            }
        };

        function notificationSkipRecord(uuid){
            Swal.fire({
                title: 'Warning',
                icon: 'warning',
                text: `You'll skip current period. This action cannot be undone, proceed with this action!`,
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: 'Yes, do it!',
                showLoaderOnConfirm: true,
                preConfirm: (request) => {
                    return @this.call('skipPeriod', uuid).then((e) => {
                        Swal.fire({
                            'title': 'Action: Success',
                            'icon': 'success',
                            'text': 'Record period successfully skipped'
                        }).then((e) => {
                            // Livewire.emitTo('sys.planned-payment.show', 'refreshComponent');
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        }
    </script>
@endpush