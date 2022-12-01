@section('title', 'Shopping List: Detail')
@section('breadcrumb')
    <h4 class="tw__fw-bold tw__py-3 tw__mb-4 tw__text-2xl breadcrumb">
        <span>
            <a href="{{ route('sys.index') }}">Dashboard</a>
        </span>
        <span>
            <a href="{{ route('sys.shopping-list.index') }}">Shopping List: List</a>
        </span>
        <span class="active">Detail</span>
    </h4>
@endsection

<div>
    {{-- Success is as dangerous as failure. --}}
    <div class="card">
        <div class="card-body">
            <div>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-arrow-back'></i>Back</span>
                </a>
                <button type="button" class="btn btn-warning" data-uuid="{{ $shoppingListData->uuid }}" x-on:click="$wire.emitTo('sys.component.shopping-list-modal', 'editAction', @this.get('shoppingListUuid'))">
                    <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-edit'></i>Edit</span>
                </button>
            </div>

            <table class="table table-hover table-striped table-bordered tw__mt-4">
                <tr>
                    <th>Name</th>
                    <td>{{ $shoppingListData->name }}</td>
                </tr>
                <tr>
                    <th>Note</th>
                    <td>{{ $shoppingListData->note ?? '-' }}</td>
                </tr>
                <tr x-data="{
                    toggle: false
                }">
                    <th>Budget</th>
                    <td data-orig="{{ formatRupiah($shoppingListData->budget) }}" data-short="{{ formatRupiah($shoppingListData->budget, true, true) }}" x-on:click="toggle = !toggle;$el.innerHTML = `${toggle ? $el.dataset.orig : $el.dataset.short}`">{{ formatRupiah($shoppingListData->budget, true, true) }}</td>
                </tr>
            </table>

            <div class="card tw__mt-4">
                <div class="card-header">
                    <div class=" tw__flex tw__items-center tw__justify-between">
                        <h5 class="card-title tw__mb-0">Item List</h5>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-shopping_list_item">
                            <span class="tw__flex tw__items-center tw__gap-2"><i class='bx bx-plus'></i>Add</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class=" tw__grid tw__grid-flow-row lg:tw__grid-flow-col lg:tw__grid-cols-6 tw__gap-4 tw__items-start">
                        <div class=" tw__col-span-4">
                            <div id="shoppingListItem-container" wire:ignore></div>
                        </div>
                        <div class=" tw__col-span-2 lg:tw__ml-auto tw__border tw__rounded lg:tw__rounded-lg lg:tw__sticky lg:tw__top-28 tw__w-full" id="shopping_list_item-summary" wire:ignore>
                            <div class="tw__p-4 tw__border-b">
                                <strong>Summary</strong>
                            </div>
                            <table class="table table-hover">
                                <tr>
                                    <th>Total Item</th>
                                    <td class="total-item">-</td>
                                </tr>
                                <tr x-data="{toggle: false}">
                                    <th>Total</th>
                                    <td class="total" data-orig="{{ formatRupiah(0) }}" data-short="{{ formatRupiah(0) }}" x-on:click="toggle = !toggle;$el.innerHTML = `${toggle ? $el.dataset.orig : $el.dataset.short}`">{{ formatRupiah(0) }}</td>
                                </tr>
                                <tr x-data="{toggle: false}">
                                    <th>Budget Leftover</th>
                                    <td class="left-over" data-budget="{{ $shoppingListData->budget }}" x-on:click="toggle = !toggle;$el.innerHTML = `${toggle ? $el.dataset.orig : $el.dataset.short}`">{{ formatRupiah(0) }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js_inline')
    <script>
        let loadSkeleton = false;
        const loadDataSkeleton = () => {
            let container = document.getElementById('shoppingListItem-container');

            if(container){
                let template = `
                    <div class=" form-group">
                        <span class=" tw__bg-gray-400 tw__h-4 tw__w-12 tw__flex tw__rounded tw__mb-2"></span>

                        <span class=" tw__flex tw__bg-gray-400 tw__h-10 tw__w-full tw__rounded"></span>
                        
                        <div class=" tw__grid tw__grid-cols-2 lg:tw__grid-cols-3 tw__gap-2 lg:tw__gap-4 tw__mt-2">
                            <div class=" tw__col-span-2 lg:tw__col-span-1">
                                <span class=" tw__bg-gray-400 tw__h-4 tw__w-12 tw__flex tw__rounded tw__mb-2"></span>
                                <span class=" tw__flex tw__bg-gray-400 tw__h-10 tw__w-full tw__rounded"></span>
                            </div>

                            <div class=" tw__col-span-2 lg:tw__col-span-1">
                                <span class=" tw__bg-gray-400 tw__h-4 tw__w-12 tw__flex tw__rounded tw__mb-2"></span>
                                <span class=" tw__flex tw__bg-gray-400 tw__h-10 tw__w-full tw__rounded"></span>
                            </div>

                            <div class=" tw__col-span-2 lg:tw__col-span-1">
                                <span class=" tw__bg-gray-400 tw__h-4 tw__w-12 tw__flex tw__rounded tw__mb-2"></span>
                                <span class=" tw__flex tw__bg-gray-400 tw__h-10 tw__w-full tw__rounded"></span>
                            </div>
                        </div>
                    </div>
                `;
                // Check if child element exists
                if(container.querySelectorAll('.list_item-wrapper').length > 0){
                    container.querySelectorAll('.list_item-wrapper').forEach((el, index) => {
                        el.innerHTML = template;
                    });
                } else {
                    container.innerHTML = ``;
                    // Child not yet exists, create new data instead using existing data
                    for(i = 0; i < 5; i++){
                        let el = document.createElement('div');
                        el.classList.add('list_item-wrapper', 'tw__bg-gray-300', 'tw__mb-2', 'last:tw__mb-0', 'tw__border-b', 'last:tw__border-b-0', 'tw__p-4', 'tw__animate-pulse', 'tw__rounded-lg');
                        el.dataset.index = i;
                        el.innerHTML = template;
                        container.appendChild(el);
                    }
                }
            }
        };

        let shoppingListPriceArrMask = [];
        let shoppingListSumArrMask = [];
        const initializeListPriceArrMask = (el) => {
            console.log("Initialize", el);
            el.forEach((el, index) => {
                let sumEl = el.closest('.form-group').querySelector('.shopping_list-item-sum');

                if(shoppingListPriceArrMask[index]){
                    console.log("Data isset");
                    shoppingListPriceArrMask[index].destroy();
                }
                if(shoppingListSumArrMask[index]){
                    console.log("Sum Data isset");
                    shoppingListSumArrMask[index].destroy();
                }

                shoppingListPriceArrMask[index] = IMask(el, {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: true,  // disallow negative
                    radix: '.',  // fractional delimiter
                });
                shoppingListSumArrMask[index] = IMask(sumEl.querySelector('input[type="text"]'), {
                    mask: Number,
                    thousandsSeparator: ',',
                    scale: 2,  // digits after point, 0 for integers
                    signed: true,  // disallow negative
                    radix: '.',  // fractional delimiter
                });
                if(el.dataset.price){
                    shoppingListPriceArrMask[index].value = (el.dataset.price).toString();
                }

                // Add EventListener
                shoppingListPriceArrMask[index].on('accept', (e) => {
                    // Handle Change
                    handleChange(el.closest('.list_item-wrapper'));
                });

                // Calculate Sum
                let qtyEl = el.closest('.form-group').querySelector('.shopping_list_item-qty');
                let qty = qtyEl.querySelector('input[type="numeric"]').value;
                let sum = parseInt(el.dataset.price) * parseInt(qty);
                // Apply to sum el
                shoppingListSumArrMask[index].value = sum.toString();
            });
        };

        loadDataSkeleton();
        document.addEventListener('DOMContentLoaded', (e) => {
            window.dispatchEvent(new Event('shoppingListItemLoadData'));

            // Append Shopping List UUID to Shopping List Item Modal
            if(document.getElementById('modal-shopping_list_item')){
                document.getElementById('modal-shopping_list_item').addEventListener('shown.bs.modal', (e) => {
                    if(document.getElementById('input_shopping_list_item-shopping_id')){
                        document.getElementById('input_shopping_list_item-shopping_id').value = "{{ $shoppingListData->uuid }}";
                    }
                });
                document.getElementById('modal-shopping_list_item').addEventListener('hidden.bs.modal', (e) => {
                    loadDataSkeleton();
                    Livewire.emit('refreshComponent');
                });
                document.getElementById('modal-shoppingList').addEventListener('hidden.bs.offcanvas', (e) => {
                    loadDataSkeleton();
                    Livewire.emit('refreshComponent');
                });
            }
        });
        window.addEventListener('shoppingListItemLoadData', (e) => {
            if(document.getElementById('shoppingListItem-container')){
                // document.getElementById('shoppingList-container').innerHTML = ``;
                generateList();
            }
        });

        const generateList = () => {
            let data = @this.get('shoppingListItemData');
            let paneEl = document.getElementById('shoppingListItem-container');
            let shoppingListContent = null;
            console.log(data);
            if(data.length > 0){
                let existingItem = paneEl.querySelectorAll('.list_item-wrapper');
                if(existingItem.length > 0){
                    data.forEach((val, index) => {
                        let wrapper = paneEl.querySelector(`.list_item-wrapper[data-index="${index}"]`);
                        if(!wrapper){
                            let wrapperTemp = document.createElement(`div`);
                            wrapperTemp.classList.add('list_item-wrapper', 'tw__mb-2', 'last:tw__mb-0', 'tw__border-b', 'last:tw__border-b-0', 'tw__pb-3', 'last:tw__pb-0');
                            wrapperTemp.dataset.index = index;
                            wrapperTemp.dataset.uuid = val.uuid;
                            paneEl.appendChild(wrapperTemp);

                            wrapper = paneEl.querySelector(`.list_item-wrapper[data-index="${index}"]`);
                        } else {
                            wrapper.removeAttribute('class');
                            wrapper.dataset.uuid = val.uuid;
                            wrapper.classList.add('list_item-wrapper', 'tw__mb-2', 'last:tw__mb-0', 'tw__border-b', 'last:tw__border-b-0', 'tw__pb-3', 'last:tw__pb-0');
                        }

                        wrapper.innerHTML = `
                            <div class=" form-group">
                                <span class=" tw__flex tw__items-center tw__gap-1">
                                    <label>Item #${index + 1}</label>
                                    <small><a href="javascript:void(0)" onclick="removeListItem('${val.uuid}')">(Remove)</a></small>
                                </span>

                                <div class="input-group tw__mb-2">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 shopping_list_item-state" type="checkbox" ${val.state ? 'checked' : ''} x-on:change="handleChange($el)">
                                    </div>
                                    <input type="text" class="form-control" placeholder="Item Name" value="${val.name}" @input.debounce="handleChange($el)">
                                </div>
                                <div class=" tw__grid tw__grid-cols-2 lg:tw__grid-cols-3 tw__gap-2 lg:tw__gap-4">
                                    <div class=" tw__col-span-2 lg:tw__col-span-1">
                                        <label>Price @</label>
                                        <input type="text" class="form-control shopping_list_item-price_mask" placeholder="Item Price @" data-price="${val.amount}">
                                    </div>
                                    <div class=" tw__col-span-2 lg:tw__col-span-1 shopping_list_item-qty">
                                        <label>QTY</label>
                                        <div class="input-group">
                                            <span class="input-group-text hover:tw__cursor-pointer hover:tw__bg-[#d9dee3] tw__transition-all" x-on:click="calculateQty('decrement', $el)">
                                                <i class='bx bx-minus'></i>
                                            </span>
                                            <input type="numeric" inputmode="numeric" class="form-control" placeholder="Amount" value="${val.qty}" min="0">
                                            <span class="input-group-text hover:tw__cursor-pointer hover:tw__bg-[#d9dee3] tw__transition-all" x-on:click="calculateQty('increment', $el)">
                                                <i class='bx bx-plus'></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class=" tw__col-span-2 lg:tw__col-span-1 shopping_list-item-sum">
                                        <label>Sum</label>
                                        <input type="text" class="form-control" placeholder="Item Sum" readonly>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    // Initialize Input Mask
                    initializeListPriceArrMask(document.querySelectorAll('.shopping_list_item-price_mask'));
                    // Remove extra el
                    let extra = [].filter.call(paneEl.querySelectorAll('.list_item-wrapper'), (el) => {
                        return el.dataset.index >= data.length;
                    });
                    extra.forEach((el) => {
                        el.remove();
                    });

                    // Add Event Listener to QTY Change
                    document.querySelectorAll('.shopping_list_item-qty').forEach((el) => {
                        el.querySelector('.form-control').addEventListener('change', (e) => {
                            // console.log("QTY Changed");
                            // Handle Change
                            handleChange(el.closest('.list_item-wrapper'));
                        });
                    });
                }
            } else {
                document.getElementById('shoppingListItem-container').innerHTML = ``;
                // Data is empty
                shoppingListContent = document.createElement('div');
                shoppingListContent.classList.add('alert', 'alert-primary', 'tw__mb-0');
                shoppingListContent.setAttribute('role', 'alert');
                shoppingListContent.innerHTML = `
                    <div class=" tw__flex tw__items-center">
                        <i class="bx bx-error tw__mr-2"></i>
                        <div class="tw__block tw__font-bold tw__uppercase">
                            Attention!
                        </div>
                    </div>
                    <span class="tw__block tw__italic">No data found</span>
                `;

                paneEl.appendChild(shoppingListContent);
            }

            setTimeout(() => {
                fetchSummary();
            }, 0);
        }
        // QTY Changed
        function calculateQty(action, el){
            let inc = 1;
            if(action === 'decrement'){
                inc = -1;

                if(parseInt(el.closest('.shopping_list_item-qty').querySelector('input[type="numeric"]').value) === parseInt(1)){
                    return false;
                }
            }

            let qty = parseInt(el.closest('.shopping_list_item-qty').querySelector('input[type="numeric"]').value) + parseInt(inc);
            el.closest('.shopping_list_item-qty').querySelector('input[type="numeric"]').value = qty;

            // Handle Change
            handleChange(el.closest('.list_item-wrapper'));
        }

        // Handle Change
        const handleChange = (rootEl) => {
            if(!(rootEl.classList.contains('list_item-wrapper'))){
                rootEl = rootEl.closest('.list_item-wrapper');
            }

            // Fetch Data
            let qtyEl = rootEl.querySelector('.shopping_list_item-qty');
            let name = rootEl.querySelector('input[placeholder="Item Name"]').value;
            let state = rootEl.querySelector('input[type="checkbox"]').checked;
            let qty = qtyEl.querySelector('input[type="numeric"]').value;
            let price = shoppingListPriceArrMask[rootEl.dataset.index].unmaskedValue;

            console.log(name);
            console.log(state);
            console.log(qty);
            console.log(price);
        
            // Update database
            @this.set('quitely', true);
            @this.set('shoppingListItemUuid', rootEl.dataset.uuid);
            @this.set('shoppingListItemState', state);
            @this.set('shoppingListItemName', name);
            @this.set('shoppingListItemQty', qty);
            @this.set('shoppingListItemPrice', price);
            @this.saveItem();
            // Calculate Sum
            shoppingListSumArrMask[rootEl.dataset.index].value = (parseInt(price) * parseInt(qty)).toString();
            // Update Summary
            fetchSummary();
        };
        const fetchSummary = () => {
            let rawData = @this.get("shoppingListDataCollect");
            let table = document.getElementById('shopping_list_item-summary');
            let itemCount = table.querySelector('.total-item');
            let total = table.querySelector('.total');
            let leftover = table.querySelector('.left-over');
            leftover.dataset.budget = rawData.budget;
            let budget = leftover.dataset.budget;

            itemCount.innerHTML = document.querySelectorAll('input.shopping_list_item-state[type="checkbox"]:checked').length > 0 ? document.querySelectorAll('input.shopping_list_item-state[type="checkbox"]:checked').length : '-';
            let sum = 0;
            document.querySelectorAll('.list_item-wrapper').forEach((el) => {
                // Get Sum
                if(el.querySelector('input.shopping_list_item-state[type="checkbox"]').checked){
                    sum += parseInt(shoppingListSumArrMask[el.dataset.index].unmaskedValue);
                }
            });
            total.dataset.orig = formatRupiah(sum, 'Rp');
            total.dataset.short = formatRupiah(sum, 'Rp', true);
            total.innerHTML = total.dataset.short;
            // Calculate Leftover
            let calcLeftOver = budget - sum;
            leftover.dataset.orig = formatRupiah(calcLeftOver, 'Rp');
            leftover.dataset.short = formatRupiah(calcLeftOver, 'Rp', true);
            leftover.innerHTML = leftover.dataset.short;
        }

        // Remove Item
        function removeListItem(uuid){
            Swal.fire({
                title: 'Warning',
                icon: 'warning',
                text: `You'll perform remove action, this action cannot be undone!`,
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonText: 'Remove',
                showLoaderOnConfirm: true,
                preConfirm: (request) => {
                    return @this.call('removeData', uuid).then((e) => {
                        Swal.fire({
                            'title': 'Action: Success',
                            'icon': 'success',
                            'text': 'Shopping List data successfully deleted'
                        }).then((e) => {
                            loadDataSkeleton();
                            Livewire.emit('refreshComponent');
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            });
        }
    </script>
@endsection