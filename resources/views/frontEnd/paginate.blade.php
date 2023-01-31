<style type="text/css">
.page-item .page-link:hover {
    color: #ffffff;
    background-color: #007bff;
    border-color: #08c;
    box-shadow: none
}

</style>

@if ($paginator->hasPages())
    <ul class="pagination">
       
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span>‹</span></li>
        @else
            <li class="page-item"><a class="page-link" href="<?php url(); ?>supplierProductPagination?page=1" rel="First Page">‹‹</a></li>
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹</a></li>
        @endif


      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li style="background:#007bff ;" class="page-item active"><a style="color: white;" class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach


        
        @if ($paginator->hasMorePages())
            <li class="page-item"><a href="{{ $paginator->nextPageUrl() }}" class="page-link" rel="next">›</a></li>
            <li class="page-item"><a href="<?php url(); ?>supplierProductPagination?page={{ $paginator->lastPage() }}" class="page-link" rel="last page">››</a></li>

        @else
            <li class="page-item disabled"><span>›</span></li>
        @endif
    </ul>
@endif 