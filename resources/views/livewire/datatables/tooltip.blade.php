<span class="tw__relative tw__group tw__cursor-pointer">
    <span class="tw__flex tw__items-center">{{ Str::limit($slot, $length) }}</span>
    <span class="tw__hidden group-hover:tw__block tw__absolute tw__z-10 tw__-ml-28 tw__w-96 tw__mt-2 tw__p-2 tw__text-xs tw__whitespace-pre-wrap tw__rounded-lg tw__bg-gray-100 tw__border tw__border-gray-300 tw__shadow-xl tw__text-gray-700 tw__text-left">{{ $slot }}</span>
</span>