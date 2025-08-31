<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-transparent">
    <div class="mb-4">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-2 px-6 py-6 glass-effect shadow-xl overflow-hidden sm:rounded-xl border border-white/10">
        {{ $slot }}
    </div>
</div>
