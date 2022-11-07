@section('title', 'Wallet Share: Passphrase')

<div>
    {{-- The whole world belongs to you. --}}
    <div class="container-xxl">
        <div class="row tw__justify-center">
            <div class="col-5">
                <div class="authentication-wrapper authentication-basic container-p-y">
                    <div class="authentication-inner">
                        <!-- Register -->
                        <div class="card">
                            <div class="card-body">
                                <!-- /Logo -->
                                <h4 class="mb-2">Wallet Share</h4>
                                <p class="mb-4">Related data is secured with passphrase, please enter correct passphrase below to access related data</p>
            
                                <form class="mb-3" method="POST" wire:submit.prevent="authenticate">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Passphrase</label>
                                        <input type="text" class="form-control @error('passphrase') is-invalid @enderror" id="text" name="passphrase" placeholder="Enter passphrase to access #{{ $shareData->token }} share data" autofocus wire:model.debounce="passphrase"/>
                                        <small class="text-muted tw__italic">*Passphrase session is valid for {{ env('SESSION_LIFETIME') }} minute(s). After reaching the specified time, you'll need to input passphrase again to access related data</small>
                                        @error('passphrase')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary d-grid w-100" type="submit">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /Register -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>