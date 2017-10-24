<nav aria-label="Page navigation" class="text-center list-navigation">
    <ul class="pagination">
        @if($previous)
        <li>
            <a href="javascript:void(0)" class="paginate previous" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        @endif
        @for($i = $startPage; $i <= $endPage; $i++)
            <li><a href="javascript:void(0)" class="paginate page {{ $i === $currentPage ? 'active' : '' }}"> {{ $i }} </a></li>
        @endfor
        @if($next)
        <li>
            <a href="javascript:void(0)" class="paginate next" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        @endif
    </ul>
</nav>   