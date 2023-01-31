
@if ($paginator->hasPages())

    <nav class="pagination" role="navigation" aria-label="pagination">
        <ul class="pagination-list">
            
            <li><a id="prevpage" href="1" class="pagination-link" style="background:#e2e6e6">← Previous</a></li>
            
            @foreach ($elements as $element)
           
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif
            
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li > <a href="{{ $url }}" class="custom_paginate pagination-link is-current main_class_{{ $page }}" style="background:#e2e6e6">{{ $page }}</a></li>
                        @else
                            <li><a href="{{ $url }}" class="custom_paginate pagination-link main_class_{{ $page }}" style="background:#e2e6e6">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            
            <li><a class="pagination-link" id="next_page" href="1" rel="next" style="background:#e2e6e6">Next →</a></li>


        </ul>
    </nav>

@endif 
