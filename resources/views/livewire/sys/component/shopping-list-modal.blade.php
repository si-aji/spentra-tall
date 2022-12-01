<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <form id="shoppingList-form">
        <div class="offcanvas offcanvas-end" tabindex="-1" id="modal-shoppingList" aria-labelledby="offcanvasLabel" wire:init="" wire:ignore.self x-data="">
            <div class="offcanvas-header">
                <h5 id="offcanvasLabel" class="offcanvas-title">Shopping List: {{ $shoppingListTitle }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                {{-- Name --}}
                <div class="form-group tw__mb-4">
                    <label for="input_shoppingList-name">Name</label>
                    <input type="text" class="form-control @error('shoppingListName') is-invalid @enderror" name="name" id="input_shoppingList-name" placeholder="Name" wire:model.defer="shoppingListName" value="{{ $shoppingListName }}">
                    @error('shoppingListName')
                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Description --}}
                <div class="form-group tw__mb-4">
                    <label for="input_shoppingList-description">Description</label>
                    <textarea class="form-control @error('shoppingListDescription') is-invalid @enderror" name="description" id="input_shoppingList-description" wire:model.defer="shoppingListDescription" placeholder="Shopping List Description">{{ $shoppingListDescription }}</textarea>
                    @error('shoppingListDescription')
                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Budget --}}
                <div class="form-group tw__mb-4">
                    <label for="input_shoppingList-budget">Budget</label>
                    <div wire:ignore>
                        <input type="text" inputmode="numeric" class="form-control @error('shoppingListBudget') is-invalid @enderror" name="budget" id="input_shoppingList-budget" placeholder="Shopping List Budget">
                    </div>
                    @error('shoppingListBudget')
                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                    @enderror
                </div>
    
                <button type="submit" class="btn btn-primary mb-2 d-grid w-100">Submit</button>
                <button type="button" class="btn btn-outline-secondary d-grid w-100" data-bs-dismiss="offcanvas">
                    Cancel
                </button>
            </div>
        </div>
    </form>
</div>

@push('javascript')
    <script>
        let shoppingListBudgetMask = null;
        document.addEventListener('DOMContentLoaded', (e) => {
            if(document.getElementById('input_shoppingList-budget')){
                shoppingListBudgetMask = IMask(document.getElementById('input_shoppingList-budget'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: false,  // disallow negative
                    radix: '.',  // fractional delimiter
                });
            }

            if(document.getElementById('shoppingList-form')){
                document.getElementById('shoppingList-form').addEventListener('submit', (e) => {
                    e.preventDefault();

                    @this.set('shoppingListName', document.getElementById('input_shoppingList-name').value);
                    @this.set('shoppingListDescription', document.getElementById('input_shoppingList-description').value);
                    @this.set('shoppingListBudget', shoppingListBudgetMask.unmaskedValue);
                    @this.save();
                });
            }
        });

        window.addEventListener('shoppingList_wire-init', (event) => {
            document.getElementById('modal-shoppingList').addEventListener('hidden.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.component.shoppingList-modal', 'closeModal');
            });
            document.getElementById('modal-shoppingList').addEventListener('shown.bs.offcanvas', (e) => {
                Livewire.emitTo('sys.component.shoppingList-modal', 'localUpdate', 'shoppingListModalState', 'show');
            });
        });

        window.addEventListener('trigger-eventShoppingList', (event) => {
            let el = event.detail;
            if(el.hasOwnProperty('shoppingListBudget')){
                shoppingListBudgetMask.value = el.shoppingListBudget ? (el.shoppingListBudget).toString() : '';
            }
        });
        window.addEventListener('shoppingList_wire-modalShow', (event) => {
            var myModalEl = document.getElementById('modal-shoppingList')
            var modal = new bootstrap.Offcanvas(myModalEl)
            modal.show();
        });
        window.addEventListener('shoppingList_wire-modalHide', (event) => {
            console.log("Hide Modal");
            var myModalEl = document.getElementById('modal-shoppingList')
            var modal = bootstrap.Offcanvas.getInstance(myModalEl);
            modal.hide();
        });
    </script>
@endpush