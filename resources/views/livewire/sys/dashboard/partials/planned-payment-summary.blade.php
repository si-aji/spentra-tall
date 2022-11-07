<div class="card">
    <div class="d-flex align-items-end row">
        <div class="col-sm-7">
            <div class="card-body">
                <h5 class="card-title text-primary">Hi <strong>{{ \Auth::user()->name }}</strong>, how's doing? 👋</h5>
                <p class="mb-4">
                    @if ($plannedPaymentCount > 0 || $plannedPaymentOverdueCount > 0)
                        @php
                            $text = [];
                            if($plannedPaymentCount > 0){
                                $text[] = "<strong>".$plannedPaymentCount."</strong> planned payment(s) <strong>due today</strong>";
                            }
                            if($plannedPaymentOverdueCount > 0){
                                $text[] = "<strong>".$plannedPaymentOverdueCount."</strong> planned payment(s) <strong>overdue</strong>";
                            }
                        @endphp
                        <span>You have {!! implode(" and ", $text) !!}, please go to <a href="{{ route('sys.planned-payment.index') }}">Planned Payment</a> page for more detail</span>
                    @else
                        <span>You don't have any planned payment today</span>
                    @endif
                </p>

                <a href="{{ route('sys.planned-payment.index') }}" class="btn btn-sm btn-outline-primary">View Planned Payment</a>
            </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
                <img
                    src="{{ asset('assets/themes/sneat/img/illustrations/man-with-laptop-light.png') }}"
                    height="140"
                    alt="View Badge User"
                    data-app-dark-img="{{ asset('assets/themes/sneat/img/illustrations/man-with-laptop-dark.png') }}"
                    data-app-light-img="{{ asset('assets/themes/sneat/img/illustrations/man-with-laptop-light.png') }}"
                    class=" tw__h-[140px]"
                    style="display: unset !important"
                />
            </div>
        </div>
    </div>
</div>