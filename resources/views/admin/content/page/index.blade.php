<div id="content-head">
    <div class="content-header mb-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('latus::nav.content') }}</a></li>
                <li class="breadcrumb-item"><a
                            href="{{ route('pages.index') }}">{{ __('latus::nav.content.pages') }}</a></li>
                <li class="breadcrumb-item active">{{ __('latus::nav.content.page.index') }}</li>
            </ol>
        </nav>
    </div>
</div>
<div id="content-main">

    <table class="table table-responsive table-bordered shadow-sm caption-top cf">
        <caption>{{ __('latus::page.table.count', ['shown' => count($paginator->items()), 'total' => $paginator->total()]) }}</caption>
        <thead class="table-light">
        <tr>
            <th scope="col" style="width:1px;"></th>
            <th scope="col" style="width:1px;">#</th>
            <th scope="col">{{ __('latus::page.table.row.title') }}</th>
            <th scope="col" style="width:1px;">{{ __('latus::page.table.row.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($paginator->items() as $item)
            <tr>
                <th scope="row"></th>
                <td class="fw-bold">{{ $item->id }}</td>
                <td>{{ mb_strimwidth($item->title, 0, 100, '...') }}</td>
                <td class="align-text-end p-0">
                    <div class="btn-group">
                        <a class="btn btn-link"
                           href="{{ route('pages.show', $item->id) }}">{{ __('latus::nav.context.view') }}</a>
                        <a class="btn btn-link"
                           href="{{ route('pages.edit', $item->id) }}">{{ __('latus::nav.context.edit') }}</a>
                        <div class="btn-group">
                            <a class="btn btn-link dropdown-toggle text-decoration-none" href="#"
                               data-bs-toggle="dropdown">More</a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item btn btn-link"
                                       href="#">{{ __('latus::nav.context.delete') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-end">
            <li class="page-item{{ !$paginator->previousPageUrl() ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->previousPageUrl() ? $paginator->previousPageUrl() : '#' }}">
                    <span>&laquo;</span>
                </a>
            </li>
            @for($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="page-item{{ $i === $paginator->currentPage() ? ' active' : '' }}">
                    <a class="page-link" href="{{ route('pages.index', ['page' => $i]) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="page-item{{ !$paginator->nextPageUrl() ? ' disabled' : '' }}">
                <a class="page-link" href="{{ $paginator->nextPageUrl() ? $paginator->nextPageUrl() : '#' }}"
                   aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>