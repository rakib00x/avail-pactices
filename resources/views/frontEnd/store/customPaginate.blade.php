<style>
    .active-paginate{
        background-color: #485fc7!important;
        border-color: #485fc7;
        color: #fff;
    }
</style>

@if ($paginator->hasPages())
<nav class="pagination" role="navigation" aria-label="pagination">
<ul class="pagination-list">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
            <span class="pagination-link" aria-hidden="true">← Previous</span>
        </li>
    @else
        <li>
            <a class="pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">← Previous</a>
        </li>
    @endif

    <?php
        $start = $paginator->currentPage() - 2; // show 3 pagination links before current
        $end = $paginator->currentPage() + 2; // show 3 pagination links after current
        if($start < 1) {
            $start = 1; // reset start to 1
            $end += 1;
        } 
        if($end >= $paginator->lastPage() ) $end = $paginator->lastPage(); // reset end to last page
    ?>

    @if($start > 1)
        <li>
            <a class="pagination-link" href="{{ $paginator->url(1) }}">{{1}}</a>
        </li>
        @if($paginator->currentPage() != 4)
            {{-- "Three Dots" Separator --}}
            <li class="disabled" aria-disabled="true"><span class="page-link">...</span></li>
        @endif
    @endif
        @for ($i = $start; $i <= $end; $i++)
            <li class="">
                <a class="pagination-link {{ ($paginator->currentPage() == $i) ? ' is-current' : '' }}" href="{{ $paginator->url($i) }}">{{$i}}</a>
            </li>
        @endfor
    @if($end < $paginator->lastPage())
        @if($paginator->currentPage() + 3 != $paginator->lastPage())
            {{-- "Three Dots" Separator --}}
            <li class="disabled" aria-disabled="true"><span class="pagination-link">...</span></li>
        @endif
        <li class="">
            <a class="pagination-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{$paginator->lastPage()}}</a>
        </li>
    @endif

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li class="">
            <a class="pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">Next →</a>
        </li>
    @else
        <li class=" disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
            <span class="pagination-link" aria-hidden="true">Next →</span>
        </li>
    @endif
</ul>
</nav>
@endif