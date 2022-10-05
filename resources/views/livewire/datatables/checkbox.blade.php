<div class="tw__flex tw__justify-center">
    <input
        type="checkbox"
        wire:model="selected"
        value="{{ $value }}"
        @if (property_exists($this, 'pinnedRecords') && in_array($value, $this->pinnedRecords)) checked @endif
        class="tw__w-4 tw__h-4 tw__mt-1 tw__text-blue-600 tw__form-checkbox tw__transition tw__duration-150 tw__ease-in-out"
    />
</div>
