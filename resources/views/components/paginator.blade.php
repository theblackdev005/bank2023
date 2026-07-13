<div id="pagination">
    @if ( $items->hasPages() )
        
        <ul class="pagination">
            @if ( $items->currentPage() > 1 )
                <li class="page-item">
                    <a href="{{ $items->previousPageUrl() }}" class="prev page-link disabled">&lt;&lt;</a>
                </li>
            @else
                <li class="page-item">
                    <button type="button" class="prev page-link disabled" disabled>&lt;&lt;</button>
                </li>
            @endif

            <li class="page-item active">
                <a class="page-link">{{ $items->currentPage() }}</a>
            </li>

            @if ( $items->hasMorePages() )
                <li class="page-item">
                    <a href="{{ $items->nextPageUrl() }}" class="next page-link disabled">&gt;&gt;</a>
                </li>
            @else
                <li class="page-item">
                    <button type="button" class="prev page-link disabled" disabled>&gt;&gt;</button>
                </li>
            @endif
        </ul>

    @endif
</div>