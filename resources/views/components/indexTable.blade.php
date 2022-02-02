<table class="table table-responsive table-bordered shadow-sm caption-top cf">
    <caption>{{ __('latus::page.table.count', ['shown' => count($paginator->items()), 'total' => $paginator->total()]) }}</caption>
    <thead class="table-light">
    <tr>
        <th scope="col" style="width:1px;"></th>
        <th scope="col" style="width:1px;">#</th>
        <th scope="col">{{ __('lh::offer.table.row.title') }}</th>
        <th scope="col">{{ __('lh::offer.table.row.fullVehicleName') }}</th>
        <th scope="col">{{ __('lh::offer.table.row.date') }}</th>
        <th scope="col" style="width:1px;">{{ __('lh::offer.table.row.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($paginator->items() as $item)
        <tr id="offer-{{ $item->id }}">
            <th scope="row"></th>
            <td class="fw-bold">{{ $item->id }}</td>
            <td class="js-model">{{ $item->title }}</td>
            <td class="js-model">{{ $item->vehicleModel->model . ' - ' . $item->vehicleVariation->name }}</td>
            <td class="js-model">{{ $item->created_at }}</td>
            <td class="align-text-end p-0 js-actions">
                <div class="btn-group">
                    <a class="btn btn-link js-lh-show-view-modal" data-with="vehicle-model,vehicle-variation"
                       data-model-id="{{ $item->id }}"
                       href="#">{{ __('latus::nav.context.view') }}</a>
                    <a class="btn btn-link"
                       href="{{ route('vehicle-offers.edit', $item->id) }}">{{ __('latus::nav.context.edit') }}</a>
                    <div class="btn-group">
                        <a class="btn btn-link dropdown-toggle text-decoration-none" href="#"
                           data-bs-toggle="dropdown">{{ __('latus::nav.context.more') }}</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item btn btn-link js-lh-show-delete-modal"
                                   href="#"
                                   data-model-id="{{ $item->id }}">{{ __('latus::nav.context.delete') }}</a>
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
        <li class="page-item{{ $paginator->currentPage() === 1 ? ' disabled' : '' }}">
            <a class="page-link"
               href="{{ $paginator->currentPage() === 1 ? '#' : $paginator->previousPageUrlWithQuery() }}">
                <span>&laquo;</span>
            </a>
        </li>
        @for($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="page-item{{ $i === $paginator->currentPage() ? ' active' : '' }}">
                <a class="page-link"
                   href="{{ $paginator->pageUrlWithQuery($i) }}">{{ $i }}</a>
            </li>
        @endfor
        <li class="page-item{{ !$paginator->nextPageUrl() ? ' disabled' : '' }}">
            <a class="page-link"
               href="{{ $paginator->nextPageUrl() ? $paginator->nextPageUrlWithQuery() : '#' }}"
               aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>