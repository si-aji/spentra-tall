<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <form id="tag-form" wire:submit.prevent="save()">
        <div class="offcanvas offcanvas-end" tabindex="-1" id="modal-tag" aria-labelledby="offcanvasLabel" wire:init="" wire:ignore.self x-data="">
            <div class="offcanvas-header">
                <h5 id="offcanvasLabel" class="offcanvas-title">Tag: {{ $tagTitle }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                {{-- Name --}}
                <div class="form-group tw__mb-4">
                    <label for="input_tag-name">Name</label>
                    <input type="text" class="form-control @error('tagName') is-invalid @enderror" name="name" id="input_tag-name" placeholder="Name" wire:model.defer="tagName" value="{{ $tagName }}">
                    @error('tagName')
                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                    @enderror
                </div>
    
                <button type="submit" class="btn btn-primary mb-2 d-grid w-100">Submit</button>
                <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
                    Cancel
                </button>
            </div>
        </div>

        @if (isset($tagModalState) && $tagModalState === 'show')
            <div class="offcanvas-backdrop fade show"></div>
        @endif
    </form>
</div>

@push('javascript')
    <script>
        window.addEventListener('tag_wire-init', (event) => {
            document.getElementById('modal-tag').addEventListener('hidden.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.component.tag-modal', 'closeModal');
            });
            document.getElementById('modal-tag').addEventListener('shown.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.component.tag-modal', 'localUpdate', 'tagModalState', 'show');
            });
        });

        window.addEventListener('tag_wire-modalShow', (event) => {
            var myModalEl = document.getElementById('modal-tag')
            var modal = new bootstrap.Offcanvas(myModalEl)
            modal.show();
        });
    </script>
@endpush