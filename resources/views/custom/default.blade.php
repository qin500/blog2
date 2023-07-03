@if ($paginator->hasPages())
    <div id="paging" class="paging">
        <div class="paging-warp">
            <p class="total">{{ $paginator->total() }}</p>
            <ul class="list">
                @if ($paginator->onFirstPage())
                    <li class="first">第一页</li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">上一页</a>
                    </li>
                @endif
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <li class="middle">{{ $element }}</li>
                            <li class="disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="active" aria-current="page"><span>{{ $page }}</span></li>
                                @else
                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
{{--                <li>1</li>--}}
{{--                <li>2</li>--}}
{{--                <li>3</li>--}}
{{--                <li>4</li>--}}
                <li class="middle">...</li>
                    @if ($paginator->hasMorePages())
                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">下一页</a>
                        </li>
                    @else
                        <li class="last">最后一页</li>
                    @endif

            </ul>
        </div>
    </div>

@endif
