<div class="tw__space-y-4">
    @foreach($rules as $index => $rule)
        @php $key = $parentIndex !== null ? $parentIndex . '.' . $index : $index; @endphp
        <div wire:key="{{ $key }}">
            @if($rule['type'] === 'rule')
                @include('datatables::complex-query-rule', ['parentIndex' => $key, 'rule' => $rule])
            @elseif($rule['type'] === 'group')
                <div x-data="{
                    key: '{{ collect(explode('.', $key))->join(".content.") . ".content" }}',
                    source: () => document.querySelector('[dragging]'),
                    dragstart: (e, key) => {
                        e.target.setAttribute('dragging', key)
                        e.target.classList.add('tw__bg-opacity-20', 'tw__bg-white')
                    },
                    dragend: (e) => {
                        e.target.removeAttribute('dragging')
                        e.target.classList.remove('tw__bg-opacity-20', 'tw__bg-white')
                    },
                    dragenter(e) {
                        if (e.target.closest('[drag-target]') !== this.source().closest('[drag-target]')) {
                            console.log(this.$refs.placeholder)
                            this.$refs.placeholder.appendChild(this.source())
                        }
                    },
                    drop(e) {
                        $wire.call('moveRule', this.source().getAttribute('dragging'), this.key)
                    },
                }" drag-target
                    x-on:dragenter.prevent="dragenter"
                    x-on:dragleave.prevent
                    x-on:dragover.prevent
                    x-on:drop="drop"
                    class="tw__p-4 tw__space-y-4 tw__bg-blue-500 tw__bg-opacity-10 tw__rounded-lg tw__text-gray-{{ strlen($parentIndex) > 6 ? 1 : 9 }}00 tw__border tw__border-blue-400"
                >
                    <span class="tw__flex tw__justify-center tw__space-x-4">
                        <button wire:click="addRule('{{ collect(explode('.', $key))->join(".content.") . ".content" }}')" class="tw__flex tw__items-center tw__space-x-2 tw__px-3 tw__py-2 tw__border tw__border-blue-400 tw__rounded-md tw__bg-white tw__text-blue-500 tw__text-xs tw__leading-4 tw__font-medium tw__uppercase tw__tracking-wider hover:tw__bg-blue-200 focus:tw__outline-none">ADD RULE</button>
                        <button wire:click="addGroup('{{ collect(explode('.', $key))->join(".content.") . ".content" }}')" class="tw__flex tw__items-center tw__space-x-2 tw__px-3 tw__py-2 tw__border tw__border-blue-400 tw__rounded-md tw__bg-white tw__text-blue-500 tw__text-xs tw__leading-4 tw__font-medium tw__uppercase tw__tracking-wider hover:tw__bg-blue-200 focus:tw__outline-none">ADD GROUP</button>
                    </span>
                    <div class="tw__block sm:tw__flex tw__items-center">
                        <div class="tw__flex tw__justify-center sm:tw__block">
                            @if(count($rule['content']) > 1)
                                <div class="tw__mr-8">
                                    <label class="tw__block tw__uppercase tw__tracking-wide tw__text-xs tw__font-bold tw__py-1 tw__rounded tw__flex tw__justify-between">Logic</label>
                                    <select
                                        wire:model="rules.{{ collect(explode('.', $key))->join(".content.") }}.logic"
                                        class="tw__w-24 tw__text-sm tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50"
                                    >
                                        <option value="and">AND</option>
                                        <option value="or">OR</option>
                                    </select>
                                </div>
                            @endif
                        </div>
                        <div x-ref="placeholder" class="tw__flex-grow tw__space-y-4">
                            <div>
                                @include('datatables::complex-query-group', [
                                    'parentIndex' => $key,
                                    'rules' => $rule['content'],
                                    'logic' => $rule['logic']
                                ])
                            </div>
                        </div>
                    </div>


                    <div class="tw__flex tw__justify-end">
                        @unless($key === 0)
                            <button wire:click="removeRule('{{ collect(explode('.', $key))->join(".content.") . ".content" }}')" class="tw__px-3 tw__py-2 tw__rounded tw__bg-red-600 tw__text-white"><x-icons.trash /></button>
                        @endunless
                    </div>

                </div>
            @endif
        </div>
    @endforeach
</div>
