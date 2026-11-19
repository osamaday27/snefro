@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-1.5" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="h-11 w-11 border border-brand-line text-neutral-300 flex items-center justify-center"><x-heroicon-o-chevron-right class="w-5 h-5 ltr:rotate-180"/></span>
        @else
            <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="window.scrollTo({top:0,behavior:'smooth'})"
                    class="h-11 w-11 border border-brand-line hover:bg-brand-ink hover:text-white hover:border-brand-ink flex items-center justify-center transition"><x-heroicon-o-chevron-right class="w-5 h-5 ltr:rotate-180"/></button>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element)) <span class="px-1 text-neutral-400">{{ $element }}</span> @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="h-11 min-w-11 px-3 bg-brand-ink text-white font-semibold flex items-center justify-center">{{ $page }}</span>
                    @else
                        <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="window.scrollTo({top:0,behavior:'smooth'})"
                                class="h-11 min-w-11 px-3 border border-brand-line font-medium hover:bg-brand-pink transition">{{ $page }}</button>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="window.scrollTo({top:0,behavior:'smooth'})"
                    class="h-11 w-11 border border-brand-line hover:bg-brand-ink hover:text-white hover:border-brand-ink flex items-center justify-center transition"><x-heroicon-o-chevron-left class="w-5 h-5 ltr:rotate-180"/></button>
        @else
            <span class="h-11 w-11 border border-brand-line text-neutral-300 flex items-center justify-center"><x-heroicon-o-chevron-left class="w-5 h-5 ltr:rotate-180"/></span>
        @endif
    </nav>
@endif
