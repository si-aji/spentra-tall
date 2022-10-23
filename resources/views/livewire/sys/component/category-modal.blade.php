<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <form id="category-form" wire:submit.prevent="save()">
        <div class="offcanvas offcanvas-end" tabindex="-1" id="modal-category" aria-labelledby="offcanvasLabel" wire:init="" wire:ignore.self x-data="">
            <div class="offcanvas-header">
                <h5 id="offcanvasLabel" class="offcanvas-title">Category: {{ $categoryTitle }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                {{-- Parent --}}
                <div class="form-group tw__mb-4">
                    <label for="input_category-category_id" data-selected="{{ $categoryParent }}">Parent</label>
                    <select class="form-control @error('categoryParent') is-invalid @enderror" id="input_category-category_id" name="category_id" placeholder="Search for Category Data" x-on:change="$wire.localUpdate('categoryParent', $event.target.value)" {{ isset($categoryUuid) && !empty($categoryUuid) ? 'disabled' : '' }}>
                        <option value="" {{ $categoryParent == '' ? 'selected' : '' }}>Search for Category Data</option>
                        @foreach ($listCategory as $category)
                            <option value="{{ $category->uuid }}" {{ !empty($categoryParent) && $category->uuid === $categoryParent ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('categoryParent')
                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                    @enderror
                    @if (isset($categoryUuid) && !empty($categoryUuid))
                        <small class="text-muted tw__italic">**Change parent category on Re-order feature</small>
                    @endif
                </div>
    
                {{-- Name --}}
                <div class="form-group tw__mb-4">
                    <label for="input_category-name">Name</label>
                    <input type="text" class="form-control @error('categoryName') is-invalid @enderror" name="name" id="input_category-name" placeholder="Name" wire:model.defer="categoryName" value="{{ $categoryName }}">
                    @error('categoryName')
                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                    @enderror
                </div>
    
                <button type="submit" class="btn btn-primary mb-2 d-grid w-100">Submit</button>
                <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
                    Cancel
                </button>
            </div>
        </div>

        @if (isset($categoryModalState) && $categoryModalState === 'show')
            <div class="offcanvas-backdrop fade show"></div>
        @endif
    </form>
</div>

@push('javascript')
    <script>
        window.addEventListener('category_wire-init', (event) => {
            // Choices
            let categoryChoice = null;
            if(document.getElementById('input_category-category_id')){
                const categoryEl = document.getElementById('input_category-category_id');
                categoryChoice = new Choices(categoryEl, {
                    allowHTML: true,
                    removeItemButton: true,
                    searchPlaceholderValue: "Search for Category Data",
                    placeholder: true,
                    placeholderValue: 'Search for Category Data',
                    shouldSort: false
                });
            }

            document.getElementById('modal-category').addEventListener('hidden.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.component.category-modal', 'closeModal');
            });
            document.getElementById('modal-category').addEventListener('shown.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.component.category-modal', 'localUpdate', 'categoryModalState', 'show');
            });
        });

        window.addEventListener('category_wire-modalShow', (event) => {
            var myModalEl = document.getElementById('modal-category')
            var modal = new bootstrap.Offcanvas(myModalEl)
            modal.show();
        });
    </script>
@endpush