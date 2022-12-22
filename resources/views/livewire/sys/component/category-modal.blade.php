<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
    <form id="category-form">
        <div class="offcanvas offcanvas-end" tabindex="1" id="modal-category" data-bs-scroll="true" aria-labelledby="offcanvasLabel" wire:init="" wire:ignore.self x-data="">
            <div class="offcanvas-header">
                <h5 id="offcanvasLabel" class="offcanvas-title">Category: {{ $categoryTitle }}</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                {{-- Parent --}}
                <div class="form-group tw__mb-4">
                    <label for="input_category-category_id" data-selected="{{ $categoryParent }}">Parent</label>
                    <div wire:ignore>
                        <select class="form-control @error('categoryParent') is-invalid @enderror" id="input_category-category_id" name="category_id" placeholder="Search for Category Data" x-on:change="$wire.localUpdate('categoryParent', $event.target.value)" {{ isset($categoryUuid) && !empty($categoryUuid) ? 'disabled' : '' }}>
                            <option value="" {{ $categoryParent == '' ? 'selected' : '' }}>Search for Category Data</option>
                            @foreach ($listCategory as $category)
                                <option value="{{ $category->uuid }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
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
                    <div class=" tw__flex tw__items-center tw__gap-2">
                        <div class="" wire:ignore>
                            <div class=" tw__h-9 tw__w-9 tw__rounded tw__border tw__border-[#d9dee3]" id="category-color_pickr">
                            </div>
                            <input type="hidden" name="categoryColor" id="input_category-color" readonly>
                        </div>
                        <div class=" tw__w-full">
                            <input type="text" class="form-control @error('categoryName') is-invalid @enderror" name="name" id="input_category-name" placeholder="Name" wire:model.defer="categoryName" value="{{ $categoryName }}">
                            @error('categoryName')
                                <small class="invalid-feedback tw__block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
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
            document.getElementById('modal-category').addEventListener('hidden.bs.offcanvas', (e) => {
                // Enable Scroll
                document.getElementsByTagName('body')[0].style.overflow = null;
                document.getElementsByTagName('body')[0].style.paddingRight = null;

                Livewire.emitTo('sys.component.category-modal', 'closeModal');
                colorPickrInit();
            });
            document.getElementById('modal-category').addEventListener('shown.bs.offcanvas', (e) => {
                // Prevent Scroll
                document.getElementsByTagName('body')[0].style.overflow = 'hidden';
                document.getElementsByTagName('body')[0].style.paddingRight = '0px';

                Livewire.emitTo('sys.component.category-modal', 'localUpdate', 'categoryModalState', 'show');
            });
        });

        window.addEventListener('category_wire-modalShow', (event) => {
            colorPickrInit(@this.get('categoryColor'));

            var myModalEl = document.getElementById('modal-category')
            var modal = new bootstrap.Offcanvas(myModalEl)
            modal.show();
        });

        let colorPickr = null;
        const colorPickrInit = (defaultColor = null) => {
            const el = document.createElement('p');
            el.classList.add('tw__w-full', 'tw__h-full', 'tw__flex');
            document.getElementById('category-color_pickr').appendChild(el);
            if(colorPickr){
                colorPickr.destroyAndRemove();
            }

            let conf = {
                el: el,
                theme: 'monolith',
                swatches: JSON.parse(localStorage.getItem('pickrPalette')),
                components: {
                    preview: false,
                    opacity: false,
                    hue: true,
                    interaction: {
                        hex: false,
                        rgba: false,
                        hsva: false,
                        input: true,
                        clear: true,
                        save: true,
                        cancel: true
                    }
                },
                defaultRepresentation: 'HEXA'
            };
            // Set Default Color
            if(defaultColor !== null){
                // Push default color to existing conf
                conf.default = defaultColor;
            }

            // Color Pickr
            colorPickr = new Pickr(conf);
            colorPickr.on('init', (instance) => {
                instance._root.button.closest('div').style.display = 'flex';
                instance._root.button.closest('div').style.width = '100%';
                instance._root.button.closest('div').style.height = '100%';
                instance._root.button.style.width = '100%';
                instance._root.button.style.height = '100%';

                instance._root.interaction.cancel.value = `Palette Reset`;
                instance._root.interaction.save.value = `Palette Add`;
            }).on('change', (color, source, instance) => {
                colorPickr.applyColor(true);
                if(document.getElementById('input_category-color')){
                    document.getElementById('input_category-color').value = color.toRGBA().toString();
                }
            }).on('save', (color, instance) => {
                if(color !== null){
                    let palette = [];
                    if(localStorage.getItem('pickrPalette')){
                        palette = JSON.parse(localStorage.getItem('pickrPalette'));
                    }

                    let selected = color.toRGBA().toString();
                    if(!palette.includes(selected)){
                        palette.push(selected);

                        colorPickr.addSwatch(selected);
                        localStorage.setItem('pickrPalette', JSON.stringify(palette));
                    }

                }
            }).on('cancel', (e) => {
                let palette = JSON.parse(localStorage.getItem('pickrPalette'));
                palette.forEach((val, index) => {
                    colorPickr.removeSwatch(0);
                });
                localStorage.setItem('pickrPalette', JSON.stringify([]));
            });
        }

        let categoryChoice = null;
        document.addEventListener('DOMContentLoaded', (e) => {
            if(document.getElementById('category-form')){
                document.getElementById('category-form').addEventListener('submit', (e) => {
                    e.preventDefault();

                    @this.set('categoryParent', document.getElementById('input_category-category_id').value);
                    @this.set('categoryName', document.getElementById('input_category-name').value);
                    @this.set('categoryColor', document.getElementById('input_category-color').value);
                    @this.save();
                });
            }

            // Choices
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

            // Color Pickr
            colorPickrInit();
        });
    </script>
@endpush