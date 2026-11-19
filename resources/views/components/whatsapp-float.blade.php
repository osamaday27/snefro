<a href="https://wa.me/{{ config('snefro.whatsapp') }}?text={{ urlencode(__('Hello Snefro for Kids, I would like to ask about your products')) }}"
   target="_blank" rel="noopener" aria-label="WhatsApp"
   class="group fixed bottom-5 end-5 z-50 flex items-center gap-3">
    <span class="hidden sm:flex items-center gap-2 bg-white text-brand-ink text-sm font-semibold ps-4 pe-5 py-3 border border-brand-line shadow-lg
                 opacity-0 translate-y-1 group-hover:opacity-100 group-hover:translate-y-0 transition duration-300">
        <span class="h-2 w-2 bg-[#25D366] animate-pulse"></span>{{ __('Chat with us') }}
    </span>
    <span class="relative flex h-16 w-16 items-center justify-center animate-wabounce">
        <span class="absolute inset-0 bg-[#25D366] animate-ring"></span>
        <span class="absolute inset-0 bg-[#25D366] animate-ring [animation-delay:1s]"></span>
        <span class="relative flex h-16 w-16 items-center justify-center bg-[#25D366] text-white shadow-xl">
            <x-whatsapp-icon class="w-9 h-9 transition-transform duration-300 group-hover:scale-110"/>
        </span>
    </span>
</a>
