<!-- resources/views/partials/pagination.blade.php -->

@props(['paginator'])

@if ($paginator->lastPage() > 1)
    <ul class="pagination pagination-outer">
        <li class="{{ $paginator->currentPage() == 1 ? ' disabled' : '' }}">
            <a href="{{ $paginator->url(1) }}" class="page-link">&lsaquo;</a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="{{ $paginator->currentPage() == $i ? ' active' : '' }}">
                <a href="{{ $paginator->url($i) }}" class="page-link">{{ $i }}</a>
            </li>
        @endfor
        <li class="{{ $paginator->currentPage() == $paginator->lastPage() ? ' disabled' : '' }}">
            <a href="{{ $paginator->url($paginator->currentPage() + 1) }}" class="page-link">&rsaquo;</a>
        </li>
    </ul>
@endif


