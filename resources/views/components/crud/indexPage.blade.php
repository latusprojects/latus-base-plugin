<div id="toastWrapper" class="position-relative">
    <div class="toast-container position-absolute top-0 end-0 p-3">

    </div>
</div>

<div id="content-head">
    <div class="content-header mb-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                @foreach($crumbs as $item)
                    @if($loop->last)
                        <li class="breadcrumb-item active">{{ $item['label'] }}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ $item['url'] }}">{{ $item['label'] }}</a></li>
                    @endif
                @endforeach
            </ol>
        </nav>
    </div>
</div>

@isset($indexHeader)
    <div id="content-pre">
        {!! $indexHeader !!}
    </div>
@endisset

<div id="content-main" class="position-relative">
    <div id="loadingIndicator" class="position-absolute h-100 w-100 text-center pt-4 js-loading-indicator"
         style="top:0;left:0;z-index:100;background-color: rgba(0,0,0,0.1);">
        <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem; " role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div id="indexContent">
        {!! $indexContent !!}
    </div>

</div>