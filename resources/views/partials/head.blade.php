<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: { sans: ['Cairo', 'Tahoma', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                colors: {
                    brand: {
                        blue: '#3b9ae1', yellow: '#f7c948', red: '#ef4b4b', green: '#4cb963',
                        orange: '#f5922f', purple: '#8a4fbf', ink: '#1f2a44', sky: '#eef7ff', cream: '#fffaf0',
                    },
                },
                keyframes: {
                    float: { '0%,100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-12px)' } },
                    wiggle: { '0%,100%': { transform: 'rotate(-6deg)' }, '50%': { transform: 'rotate(6deg)' } },
                    ring: { '0%': { transform: 'scale(1)', opacity: '.55' }, '100%': { transform: 'scale(1.9)', opacity: '0' } },
                    wabounce: {
                        '0%,55%,100%': { transform: 'translateY(0)' },
                        '65%': { transform: 'translateY(-16px)' },
                        '75%': { transform: 'translateY(0)' },
                        '85%': { transform: 'translateY(-7px)' },
                    },
                    fadeup: { '0%': { opacity: 0, transform: 'translateY(16px)' }, '100%': { opacity: 1, transform: 'translateY(0)' } },
                },
                animation: {
                    float: 'float 4s ease-in-out infinite',
                    wiggle: 'wiggle 1.2s ease-in-out infinite',
                    ring: 'ring 1.8s ease-out infinite',
                    wabounce: 'wabounce 2.6s ease-in-out infinite',
                    fadeup: 'fadeup .6s ease-out both',
                },
            },
        },
    };
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
<style>
    [x-cloak]{display:none!important}
    body{font-family:'Cairo',Tahoma,sans-serif}
    .swal2-popup{font-family:'Cairo',Tahoma,sans-serif!important}
    .no-scrollbar::-webkit-scrollbar{display:none}.no-scrollbar{scrollbar-width:none}
</style>
