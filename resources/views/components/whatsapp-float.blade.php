<a href="https://wa.me/{{ config('snefro.whatsapp') }}?text={{ urlencode('مرحباً سنفرو للأطفال 👋 أريد الاستفسار عن منتجاتكم') }}"
   target="_blank" rel="noopener" aria-label="تواصل معنا على واتساب"
   class="group fixed bottom-5 end-5 z-50 flex items-center gap-3">
    <span class="hidden sm:flex items-center gap-2 bg-white text-brand-ink text-sm font-bold rounded-full ps-4 pe-5 py-2.5 shadow-xl
                 opacity-0 translate-x-3 group-hover:opacity-100 group-hover:translate-x-0 transition duration-300">
        <span class="relative flex h-2.5 w-2.5"><span class="absolute inline-flex h-full w-full rounded-full bg-green-400 animate-ping"></span><span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span></span>
        تواصل معنا الآن
    </span>
    <span class="relative flex h-16 w-16 items-center justify-center animate-wabounce">
        <span class="absolute inline-flex h-full w-full rounded-full bg-[#25D366] animate-ring"></span>
        <span class="absolute inline-flex h-full w-full rounded-full bg-[#25D366] animate-ring [animation-delay:.9s]"></span>
        <span class="relative flex h-16 w-16 items-center justify-center rounded-full bg-[#25D366] text-white shadow-2xl shadow-green-600/40 ring-4 ring-white">
            <x-whatsapp-icon class="w-9 h-9 group-hover:animate-wiggle" />
        </span>
    </span>
</a>
