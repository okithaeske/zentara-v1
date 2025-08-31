@props(['id' => null, 'maxWidth' => null])

<x-user-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg font-semibold text-white">
            {{ $title }}
        </div>

        <div class="mt-4 text-sm text-gray-300">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-white/5 text-end border-t border-white/10">
        {{ $footer }}
    </div>
</x-user-modal>

