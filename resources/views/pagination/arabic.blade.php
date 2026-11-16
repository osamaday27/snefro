@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-2" aria-label="التنقل بين الصفحات">
        @if ($paginator->onFirstPage())
            <span class="h-11 w-11 rounded-2xl bg-slate-100 text-slate-300 flex items-center justify-center"><x-heroicon-o-chevron-right class="w-6 h-6"/></span>
        @else
            <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="window.scrollTo({top:0,behavior:'smooth'})"
                    class="h-11 w-11 rounded-2xl bg-white border border-slate-200 hover:bg-brand-blue hover:text-white flex items-center justify-center transition"><x-heroicon-o-chevron-right class="w-6 h-6"/></button>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-1 text-slate-400">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="h-11 min-w-11 px-3 rounded-2xl bg-brand-blue text-white font-extrabold flex items-center justify-center">{{ $page }}</span>
                    @else
                        <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="window.scrollTo({top:0,behavior:'smooth'})"
                                class="h-11 min-w-11 px-3 rounded-2xl bg-white border border-slate-200 font-bold hover:bg-brand-sky transition">{{ $page }}</button>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="window.scrollTo({top:0,behavior:'smooth'})"
                    class="h-11 w-11 rounded-2xl bg-white border border-slate-200 hover:bg-brand-blue hover:text-white flex items-center justify-center transition"><x-heroicon-o-chevron-left class="w-6 h-6"/></button>
        @else
            <span class="h-11 w-11 rounded-2xl bg-slate-100 text-slate-300 flex items-center justify-center"><x-heroicon-o-chevron-left class="w-6 h-6"/></span>
        @endif
    </nav>
@endif
