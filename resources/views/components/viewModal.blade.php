<x-latus-bs5::modal id="{{ $id }}" size="{{ $size }}">

    <x-slot name="header">
        <h5 class="modal-title">{!! $title !!}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </x-slot>

    <x-slot name="body">

        <div class="mb-3 card">
            <div class="card-header row mw-100 ms-0">
                <div class="ps-0 col-8 fw-bold">
                    {!! $cardTitle !!}
                </div>
                <div class="col-4 align-text-end pe-0">
                    <div class="btn-group btn-group-sm p-0">
                        <a class="btn btn-outline-secondary" href="#"><i class="bi bi-printer"></i></a>
                        <a class="btn btn-outline-secondary" href="#"><i class="bi bi-download"></i></a>
                        <a class="btn btn-outline-secondary" href="#"><i class="bi bi-share"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {!! $cardBody !!}
            </div>
        </div>

    </x-slot>

</x-latus-bs5::modal>