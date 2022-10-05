<div class="tw__w-full">
    @php $key = collect(explode('.', $parentIndex))->join(".content.") . ".content" @endphp
    <div
        draggable="true"
        x-on:dragstart="dragstart($event, '{{ $key }}')"
        x-on:dragend="dragend"
        key="{{ $key }}"
        class="tw__px-3 tw__py-2 tw__-my-1 sm:tw__flex tw__space-x-4 tw__items-end hover:tw__bg-opacity-20 hover:tw__bg-white hover:tw__shadow-xl"
    >
        <div class="sm:tw__flex tw__flex-grow sm:tw__space-x-4">
            <div class="sm:w-1/3">
                <label
                    class="tw__block tw__uppercase tw__tracking-wide tw__text-xs tw__font-bold tw__py-1 tw__rounded tw__flex tw__justify-between">Column</label>
                <div class="tw__relative">
                    <select wire:model="rules.{{ $key }}.column" name="selectedColumn"
                        class="tw__w-full tw__my-1 tw__text-sm tw__text-gray-900 tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50">
                        <option value=""></option>
                        @foreach ($columns as $i => $column)
                            <option value="{{ $i }}">{{ Str::ucfirst($column['label']) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if ($options = $this->getOperands($key))
                <div class="sm:w-1/3">
                    <label
                        class="tw__block tw__uppercase tw__tracking-wide tw__text-xs tw__font-bold tw__py-1 tw__rounded tw__flex tw__justify-between">Operand</label>
                    <div class="tw__relative">
                        <select name="operand" wire:model="rules.{{ $key }}.operand"
                            class="tw__w-full tw__my-1 tw__text-sm tw__text-gray-900 tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50">
                            <option selected></option>
                            @foreach ($options as $operand)
                                <option value="{{ $operand }}">{{ $operand }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            @if (!in_array($rule['content']['operand'], ['is empty', 'is not empty']))
                <div class="sm:w-1/3">
                    @if ($column = $this->getRuleColumn($key))
                        <label
                            class="tw__block tw__uppercase tw__tracking-wide tw__text-xs tw__font-bold tw__py-1 tw__rounded tw__flex tw__justify-between">Value</label>
                        <div class="tw__relative">
                            @if (is_array($column['filterable']))
                                <select name="value" wire:model="rules.{{ $key }}.value"
                                    class="tw__w-full tw__my-1 tw__text-sm tw__text-gray-900 tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50">
                                    <option selected></option>
                                    @foreach ($column['filterable'] as $value => $label)
                                        @if (is_object($label))
                                            <option value="{{ $label->id }}">{{ $label->name }}</option>
                                        @elseif(is_array($label))
                                            <option value="{{ $label['id'] }}">{{ $label['name'] }}</option>
                                        @elseif(is_numeric($value))
                                            <option value="{{ $label }}">{{ $label }}</option>
                                        @else
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            @elseif($column['type'] === 'boolean')
                                <select name="value" wire:model="rules.{{ $key }}.value"
                                    class="tw__w-full tw__my-1 tw__text-sm tw__text-gray-900 tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50">
                                    <option selected></option>
                                    <option value="true">True</option>
                                    <option value="false">False</option>
                                </select>
                            @elseif($column['type'] === 'date')
                                <input type="date" name="value" wire:model.lazy="rules.{{ $key }}.value"
                                    class="tw__w-full tw__px-3 tw__py-2 tw__border tw__my-1 tw__text-sm tw__text-gray-900 tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__outline-none focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50" />
                            @elseif($column['type'] === 'time')
                                <input type="time" name="value" wire:model.lazy="rules.{{ $key }}.value"
                                    class="tw__w-full tw__px-3 tw__py-2 tw__border tw__my-1 tw__text-sm tw__text-gray-900 tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__outline-none focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50" />
                            @else
                                <input name="value" wire:model.lazy="rules.{{ $key }}.value"
                                    class="tw__w-full tw__px-3 tw__py-2 tw__border tw__my-1 tw__text-sm tw__text-gray-900 tw__leading-4 tw__block tw__rounded-md tw__border-gray-300 tw__shadow-sm focus:tw__outline-none focus:tw__border-blue-300 focus:tw__ring focus:tw__ring-blue-200 focus:tw__ring-opacity-50" />
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </div>
        <div class="tw__flex tw__justify-center sm:tw__justify-end">
            <button wire:click="duplicateRule('{{ $key }}')"
                class="tw__mb-px tw__w-9 tw__h-9 tw__flex tw__items-center tw__justify-center tw__rounded tw__text-green-600 hover:tw__text-green-400">
                <x-icons.copy />
            </button>
            <button wire:click="removeRule('{{ $key }}')"
                class="tw__mb-px tw__w-9 tw__h-9 tw__flex tw__items-center tw__justify-center tw__rounded tw__text-red-600 hover:tw__text-red-400">
                <x-icons.trash />
            </button>
        </div>
    </div>
</div>
