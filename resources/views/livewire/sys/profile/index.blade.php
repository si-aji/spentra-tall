@section('title', 'Profile')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>Profile</span>
        <span class="active">Account</span>
    </h4>
@endsection

<div x-data="{
		init(){
			this.uploadState = false;
			this.uploadProgress = 0;
		}
	}">
    <div class="card">
		<div class="card-body">
			<ul class="nav nav-pills flex-column flex-md-row">
				@foreach ($extraMenu as $menu)
					<li class="nav-item">
						<a class="nav-link {{ $submenuState === $menu['state'] ? 'active' : '' }}" href="{{ isset($menu['route']) && !empty($menu['route']) ? route($menu['route']) : 'javascript:void(0);' }}"><i class="{{ $menu['icon'] }} me-1"></i> {{ $menu['name'] }}</a>
					</li>
				@endforeach
			</ul>
		</div>
	</div>

	<form id="form-profile" method="POST" wire:submit.prevent="save" x-on:submit="refreshNavbar()" class="card mb-4 tw__mt-4">
		@csrf
        <h5 class="card-header">Profile Details</h5>
        <!-- Account -->
        <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4" x-on:livewire-upload-start="uploadState = true;uploadProgress = 0;$wire.removePhoto()" x-on:livewire-upload-progress="uploadProgress = $event.detail.progress" x-on:livewire-upload-finish="uploadState = false">
				@if (empty($photo))
					<a data-fslightbox href="{{ $avatar }}">
						<img src="{{ $avatar }}" data-src="{{ \Auth::user()->getProfilePicture() }}" alt="user-avatar" class="d-block rounded tw__object-cover tw__h-24 tw__w-24 tw__border-2 tw__border-[#696cff]" height="100" width="100" id="uploadedAvatar" />
					</a>
				@else
					<a data-fslightbox href="{{ $photo->temporaryUrl() }}">
						<img src="{{ $photo->temporaryUrl() }}" data-src="{{ \Auth::user()->getProfilePicture() }}" alt="user-avatar" class="d-block rounded tw__object-cover tw__h-24 tw__w-24 tw__border-2 tw__border-[#696cff]" height="100" width="100" id="uploadedAvatar" />
					</a>
				@endif
                <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                        <span class="d-none d-sm-block">Upload new photo</span>
                        <i class="bx bx-upload d-block d-sm-none"></i>
                        <input type="file" wire:model.lazy="photo" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg"/>
                    </label>
                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4" x-on:click="$wire.removePhoto()">
                        <i class="bx bx-reset d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Reset</span>
                    </button>
					<div class=" tw__mt-2" x-show="uploadState">
						<div class="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 20%" x-bind:style="{width: `${uploadProgress}%`}" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                </div>
            </div>
        </div>
        <hr class="my-0" />
        <div class="card-body">
			<div class="form-group mb-3">
				<label>Name</label>
				<input type="text" wire:model.lazy="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" value="{{ \Auth::user()->name }}">
				@error('name')
					<span class="invalid-feedback">{{ $message }}</span>	
				@enderror
			</div>
			<div class="form-group mb-3">
				<label>Username</label>
				<input type="text"wire:model.lazy="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ \Auth::user()->username }}">
				@error('username')
					<span class="invalid-feedback">{{ $message }}</span>	
				@enderror
			</div>
			<div class="form-group mb-3">
				<label>Email</label>
				<input type="email" wire:model.lazy="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ \Auth::user()->email }}">
				@error('email')
					<span class="invalid-feedback">{{ $message }}</span>	
				@enderror
			</div>

			<div class="mt-2">
				<button type="submit" class="btn btn-primary me-2" x-bind:disabled="uploadState">Save changes</button>
				<button type="reset" class="btn btn-outline-secondary" x-on:click="$wire.removePhoto()">Cancel</button>
			</div>
        </div>
        <!-- /Account -->
	</form>
	<div class="card">
		<h5 class="card-header">Delete Account</h5>
		<div class="card-body">
			<div class="mb-3 col-12 mb-0">
				<div class="alert alert-warning">
					<h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
					<p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
				</div>
			</div>
			<form id="form-deactive" x-data="{disabled: true}">
				<div class="form-check mb-3">
					<input class="form-check-input" type="checkbox" name="confirm" id="input-confirm" x-on:change="disabled = !(event.target.checked)"/>
					<label class="form-check-label" for="input-confirm">I confirm my account deactivation</label>
				</div>
				<button type="button" class="btn btn-danger deactivate-account" x-on:click="deleteAccount()" x-bind:disabled="disabled">Deactivate Account</button>
			</form>
		</div>
	</div>
</div>

@section('js_inline')
	<script>
		// Update/reset user image of account page
		let accountUserImage = document.getElementById('uploadedAvatar');
		const fileInput = document.querySelector('.account-file-input'),
			resetFileInput = document.querySelector('.account-image-reset');

		if (accountUserImage) {
			const resetImage = accountUserImage.dataset.src;
			resetFileInput.onclick = () => {
				fileInput.value = '';
				accountUserImage.src = resetImage;
			};
		}

		function refreshNavbar(){
			setTimeout(() => {
				Livewire.emitTo('sys.component.search-feature', 'refreshComponent');
			}, 500);
		}
		function deleteAccount(){
			Swal.fire({
                title: 'Warning',
                icon: 'warning',
                text: `Please type your password to proceed!`,
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: 'Remove',
				input: 'password',
				inputPlaceholder: 'Type your current password!',
				inputAttributes: {
					autocapitalize: 'off'
				},
				inputValidator: (value) => {
					return new Promise((resolve) => {
						Swal.showLoading();
						if (value === '') {
							Swal.hideLoading();
							resolve('Please type your current password to proceed');
						} else {
							@this.set('deletePassword', value);
							let action = @this.call('checkAccount')
								.then((response) => {
									console.log(response);
									if(!response.result){
										Swal.hideLoading();
										resolve('Missmatch password');
									}

									Swal.hideLoading();
									resolve();
								});
						}
					});
				},
                allowOutsideClick: () => !Swal.isLoading()
            }).then((e) => {
				if(e.value){
					Swal.fire({
						'title': 'Action: Success',
						'icon': 'success',
						'text': `It's sad to see you go, but you can always back anytime :)`
					}).then((e) => {
						@this.call('deleteAccount');
					});
				}
			});
		}
	</script>
@endsection