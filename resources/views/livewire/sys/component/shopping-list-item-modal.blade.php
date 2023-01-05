<div>
    {{-- Be like water. --}}
    <form id="shoppingListItem-form">
        <div class="modal fade" wire:init="openModal" wire:ignore.self id="modal-shopping_list_item" tabindex="-1" aria-hidden="true" x-data="">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header tw__pb-2">
                        <h5 class="modal-title" id="modalCenterTitle">Shopping List Item: Add New</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div wire:ignore>
                            <input type="hidden" name="shopping_id" id="input_shopping_list_item-shopping_id" readonly>
                        </div>

                        {{-- Name --}}
                        <div class="form-group tw__mb-4" id="form-current">
                            <label for="input_shopping_list_item-name">Name</label>
                            <input type="text" class="form-control @error('shoppingListItemName') is-invalid @enderror" name="Name" id="input_shopping_list_item-name" placeholder="Item Name">
                            @error('shoppingListItemName')
                                <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-6 tw__mb-4 lg:tw__mb-0">
                                {{-- Price @ --}}
                                <div class="form-group">
                                    <label for="input_shopping_list_item-price">Price @</label>
                                    <input type="text" inputmode="numeric" class="form-control @error('shoppingListItemPrice') is-invalid @enderror" name="actual" id="input_shopping_list_item-price" placeholder="Item Price @">
                                    @error('shoppingListItemPrice')
                                        <small class="invalid-feedback">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 tw__mb-4 lg:tw__mb-0" x-data="{
                                qty: @entangle('shoppingListItemQty')
                            }">
                                <button type="button" class=" tw__hidden" x-on:click="qty = 1" id="input_shopping_list_item-qty_reset"></button>
                                {{-- QTY --}}
                                <div class="form-group">
                                    <label for="input_shopping_list_item-qty">QTY</label>
                                    <div class="input-group">
                                        <span class="input-group-text hover:tw__cursor-pointer hover:tw__bg-[#d9dee3] tw__transition-all" x-on:click="(qty > 0 ? qty-- : false);document.getElementById('input_shopping_list_item-qty').dispatchEvent(new Event('change'))">
                                            <i class='bx bx-minus'></i>
                                        </span>
                                        <input type="numeric" inputmode="numeric" class="form-control @error('shoppingListItemQty') is-invalid @enderror" placeholder="QTY" value="0" min="0" x-model="qty" id="input_shopping_list_item-qty">
                                        <span class="input-group-text hover:tw__cursor-pointer hover:tw__bg-[#d9dee3] tw__transition-all" x-on:click="qty++;document.getElementById('input_shopping_list_item-qty').dispatchEvent(new Event('change'))">
                                            <i class='bx bx-plus'></i>
                                        </span>
                                    </div>
                                    @error('shoppingListItemQty')
                                        <small class="invalid-feedback tw__block">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Sum --}}
                        <div class="form-group lg:tw__mt-4">
                            <label for="input_shopping_list_item-qty">Sum</label>
                            <input type="text" inputmode="numeric" class="form-control" name="sum" id="input_shopping_list_item-sum" placeholder="Sum" readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="closeModal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('javascript')
    <script>
        let shoppingListItemModalPriceMask = null;
        let shoppingListItemModalSumMask = null;
        document.addEventListener('DOMContentLoaded', (e) => {
            if(document.getElementById('input_shopping_list_item-price')){
                shoppingListItemModalPriceMask = IMask(document.getElementById('input_shopping_list_item-price'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: true,  // disallow negative
                    radix: '.',  // fractional delimiter
                });
            }
            if(document.getElementById('input_shopping_list_item-sum')){
                shoppingListItemModalSumMask = IMask(document.getElementById('input_shopping_list_item-sum'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: true,  // disallow negative
                    radix: '.',  // fractional delimiter
                });
            }
            
            // Submit Event
            document.getElementById('shoppingListItem-form').addEventListener('submit', (e) => {
                e.preventDefault();
                console.log("Shopping List Item is being submited");

                // Remove Invalid State if exists
                e.target.querySelectorAll('.form-control').forEach((el) => {
                    el.classList.remove('is-invalid');
                    if(el.closest('.form-group').querySelector('.invalid-feedback')){
                        el.closest('.form-group').querySelector('.invalid-feedback').remove();
                    }
                });

                if(e.target.querySelector('button[type="submit"]')){
                    e.target.querySelector('button[type="submit"]').innerHTML = `
                        <span class=" tw__flex tw__items-center tw__gap-2">
                            <i class="bx bx-loader-alt bx-spin"></i>
                            <span>Loading</span>    
                        </span>
                    `;
                    e.target.querySelector('button[type="submit"]').disabled = true;
                }

                @this.set('shoppingListUuid', document.getElementById('input_shopping_list_item-shopping_id').value);
                @this.set('shoppingListItemName', document.getElementById('input_shopping_list_item-name').value);
                @this.set('shoppingListItemPrice', shoppingListItemModalPriceMask.unmaskedValue);
                @this.set('shoppingListItemQty', document.getElementById('input_shopping_list_item-qty').value);
                @this.save();
            });

            // Change Event
            if(document.getElementById('input_shopping_list_item-qty')){
                document.getElementById('input_shopping_list_item-qty').addEventListener('change', (e) => {
                    setTimeout(() => {
                        let price = shoppingListItemModalPriceMask.unmaskedValue;
                        if(price !== ''){
                            let calc = (parseInt(e.target.value) * price).toString();
                            shoppingListItemModalSumMask.value = calc;
                        } else {
                            shoppingListItemModalSumMask.value = '';
                        }
                    }, 100);
                });
            }
            shoppingListItemModalPriceMask.on('accept', (e) => {
                document.getElementById('input_shopping_list_item-qty').dispatchEvent(new Event('change'));
            });

            if(document.getElementById('modal-shopping_list_item')){
                document.getElementById('modal-shopping_list_item').addEventListener('hidden.bs.modal', (e) => {
                    // @this.set('shoppingListItemQty', 1);
                    @this.set('shoppingListItemQty', 1);
                    shoppingListItemModalPriceMask.value = '0';
                    document.getElementById('input_shopping_list_item-qty').dispatchEvent(new Event('change'));
                });
                document.getElementById('modal-shopping_list_item').addEventListener('show.bs.modal', (e) => {
                    // @this.set('shoppingListItemQty', 1);
                    @this.set('shoppingListItemQty', 1);
                    shoppingListItemModalPriceMask.value = '0';
                    document.getElementById('input_shopping_list_item-qty').dispatchEvent(new Event('change'));
                });
                document.getElementById('modal-shopping_list_item').addEventListener('shown.bs.modal', (e) => {
                    if(document.getElementById('input_shopping_list_item-name')){
                        document.getElementById('input_shopping_list_item-name').focus();
                    }
                });
            }
        });

        window.addEventListener('shopping_list_item_wire-modalShow', (event) => {
            var myModalEl = document.getElementById('modal-shopping_list_item');
            var modal = new bootstrap.Modal(myModalEl)
            modal.show();
        });
        window.addEventListener('shopping_list_item_wire-modalHide', (event) => {
            var myModalEl = document.getElementById('modal-shopping_list_item');
            var modal = bootstrap.Modal.getInstance(myModalEl);
            modal.hide();
        });
    </script>
@endpush
