<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            // لا حواف دائرية في أي مكان
            borderRadius: { none: '0', sm: '0', DEFAULT: '0', md: '0', lg: '0', xl: '0', '2xl': '0', '3xl': '0', full: '0' },
            extend: {
                fontFamily: { sans: ['Poppins', 'Cairo', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                colors: {
                    brand: { ink: '#111111', pink: '#F6B3C8', rose: '#D9648F', blush: '#FDF0F4', mist: '#F6F6F6', line: '#E6E6E6' },
                },
                keyframes: {
                    ring: { '0%': { transform: 'scale(1)', opacity: '.5' }, '100%': { transform: 'scale(1.8)', opacity: '0' } },
                    wabounce: { '0%,55%,100%': { transform: 'translateY(0)' }, '65%': { transform: 'translateY(-14px)' }, '75%': { transform: 'translateY(0)' }, '85%': { transform: 'translateY(-6px)' } },
                    fadeup: { '0%': { opacity: 0, transform: 'translateY(14px)' }, '100%': { opacity: 1, transform: 'none' } },
                    float: { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-10px)' } },
                    scrollline: { '0%': { transform: 'scaleY(0)', transformOrigin: 'top' }, '50%': { transform: 'scaleY(1)', transformOrigin: 'top' }, '51%': { transform: 'scaleY(1)', transformOrigin: 'bottom' }, '100%': { transform: 'scaleY(0)', transformOrigin: 'bottom' } },
                },
                animation: {
                    ring: 'ring 2s ease-out infinite', wabounce: 'wabounce 2.8s ease-in-out infinite',
                    fadeup: 'fadeup .5s ease-out both', float: 'float 5s ease-in-out infinite', scrollline: 'scrollline 2s ease-in-out infinite',
                },
            },
        },
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
<style>
    *, *::before, *::after { border-radius: 0 !important; }
    html[lang="ar"] * { letter-spacing: 0 !important; }
    [x-cloak] { display: none !important; }
    html { scroll-behavior: smooth; }
    body { font-family: 'Poppins', 'Cairo', sans-serif; -webkit-font-smoothing: antialiased; }
    html[lang="ar"] body { font-family: 'Cairo', 'Poppins', sans-serif; }
    .swal2-popup { font-family: 'Cairo', 'Poppins', sans-serif !important; }
    .no-scrollbar::-webkit-scrollbar { display: none; } .no-scrollbar { scrollbar-width: none; }

    /* انتقال الصفحة */
    @keyframes pageIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: none; } }
    main { animation: pageIn .45s ease both; }

    /* ظهور العناصر عند التمرير */
    [data-reveal] { opacity: 0; transform: translateY(28px); transition: opacity .8s ease, transform .8s cubic-bezier(.2,.7,.2,1); transition-delay: var(--d, 0ms); }
    [data-reveal="fade"] { transform: none; }
    [data-reveal="left"] { transform: translateX(-34px); }
    [data-reveal="right"] { transform: translateX(34px); }
    [data-reveal].is-in { opacity: 1; transform: none; }

    /* خط وردي يتمدد تحت العناوين */
    .title-line { display: block; height: 3px; width: 0; background: #F6B3C8; transition: width .9s cubic-bezier(.2,.7,.2,1) .25s; }
    .is-in .title-line, .title-line.is-in { width: 56px; }

    /* شريط متحرك */
    @keyframes marquee { to { transform: translateX(-50%); } }
    @keyframes marqueeRtl { to { transform: translateX(50%); } }
    .marquee-track { display: flex; width: max-content; animation: marquee 32s linear infinite; }
    [dir="rtl"] .marquee-track { animation-name: marqueeRtl; }
    .marquee:hover .marquee-track { animation-play-state: paused; }

    /* الهيرو */
    .hero-swiper { --swiper-pagination-color: #F6B3C8; }
    .hero-swiper .swiper-pagination { display: flex; gap: 8px; justify-content: center; }
    .hero-swiper .swiper-pagination-bullet { width: 34px; height: 3px; margin: 0 !important; background: #fff; opacity: .5; transition: .3s; }
    .hero-swiper .swiper-pagination-bullet-active { background: #F6B3C8; opacity: 1; width: 54px; }
    .hero-swiper .hero-par { transition: transform .8s cubic-bezier(.2,.7,.2,1); transform: translate3d(calc(var(--mx, 0) * -16px), calc(var(--my, 0) * -10px), 0); }
    .hero-swiper .hero-img { transform: scale(1.14); transition: transform 9s ease-out; }
    .hero-swiper .swiper-slide-active .hero-img { transform: scale(1); }
    .hero-swiper .hero-in { opacity: 0; transform: translateY(26px); transition: opacity .8s ease, transform .9s cubic-bezier(.2,.7,.2,1); }
    .hero-swiper .swiper-slide-active .hero-in { opacity: 1; transform: none; transition-delay: calc(var(--i, 0) * 120ms + 350ms); }
    .hero-swiper .hero-panel { transform: translateX(-40px); opacity: 0; transition: opacity .9s ease .2s, transform 1s cubic-bezier(.2,.7,.2,1) .2s; }
    [dir="rtl"] .hero-swiper .hero-panel { transform: translateX(40px); }
    .hero-swiper .swiper-slide-active .hero-panel { transform: none; opacity: 1; }
</style>
<noscript><style>[data-reveal], .hero-in, .hero-panel { opacity: 1 !important; transform: none !important; }</style></noscript>
<script>
    // ظهور العناصر عند التمرير (يعمل أيضاً مع العناصر التي يضيفها Livewire)
    (function () {
        if (window.__snefroReveal) return; window.__snefroReveal = true;
        const io = new IntersectionObserver((entries) => entries.forEach((e) => {
            if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); }
        }), { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        const scan = () => document.querySelectorAll('[data-reveal]:not(.is-in)').forEach((el) => io.observe(el));
        new MutationObserver(scan).observe(document.documentElement, { childList: true, subtree: true });
        document.addEventListener('DOMContentLoaded', scan);
        document.addEventListener('livewire:navigated', scan);
        // لا نُعيد إخفاء العناصر التي ظهرت بالفعل عند تحديثات Livewire
        document.addEventListener('livewire:init', () => {
            Livewire.hook('morph.updating', ({ el, toEl }) => {
                if (el.classList && toEl.classList && el.classList.contains('is-in')) toEl.classList.add('is-in');
            });
        });
        scan();
    })();
</script>
