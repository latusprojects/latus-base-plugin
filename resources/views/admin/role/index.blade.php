<script>
    window.model = 'role';
    window.action = 'index';
    document.addEventListener('latus.registers', function () {
        window.exposed.attributes = {};
    });
</script>

<x-latus-bs5::modal id="deleteModelModal">
    <x-slot name="header">
        <h5 class="modal-title">{{ __('latus::role.action.prompt.delete.title') }}<span
                    data-latus-prop="name"></span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </x-slot>

    <x-slot name="body">
        {!! __('latus::role.action.prompt.delete.text') !!}
    </x-slot>

    <x-slot name="footer">
        <button type="button" class="btn btn-secondary"
                data-bs-dismiss="modal">{{ __('latus::role.action.prompt.cancel') }}</button>
        <button type="button"
                class="btn btn-primary js-latus-confirm-delete">{{ __('latus::role.action.prompt.confirm') }}
        </button>
    </x-slot>
</x-latus-bs5::modal>

<div id="content-head">
    <div class="content-header mb-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('latus::nav.administration') }}</a>
                </li>
                <li class="breadcrumb-item"><a
                            href="{{ route('roles.index') }}">{{ __('latus::nav.roles') }}</a></li>
                <li class="breadcrumb-item active">{{ __('latus::nav.role.index') }}</li>
            </ol>
        </nav>
    </div>
</div>
<div id="content-main" is="latus-filterable-table" data-latus-route="{{ route('roles.index') }}"
     data-latus-target-id="tableWrapper">
    <div class="row">
        <div class="col-12 col-md-6 col-xxl-4">
            <div class="input-group">
                <input class="form-control" data-latus-filter="search" placeholder="Suche nach: #ID, Name">
                <span class="input-group-text">
                    <i class="bi bi-info-circle text-primary" data-bs-toggle="tooltip"
                       title="Um nach einer spezifischen ID zu suchen, gebe zwei Rautezeichen (z.B. ##5783) vor der ID an, um nach ähnlichen IDs zu suchen, gebe genau ein Rautezeichen vor der ID an (z.B. #52).">
                    </i>
                </span>
            </div>
        </div>
        <div class="col-auto flex-fill"></div>
        <label class="col-auto col-form-label" for="sortBySelect">Sortieren nach</label>
        <div class="col-auto">
            <select class="form-select" id="sortBySelect" data-latus-filter="sort">
                <option value="id">#ID</option>
                <option value="created_at">Datum</option>
                <option value="name">Name</option>
            </select>
        </div>
        <div class="col-auto">
            <select class="form-select" id="sortBySelect" data-latus-filter="sortDesc">
                <option value="0">Aufsteigend</option>
                <option value="1">Absteigend</option>
            </select>
        </div>
    </div>

    <div class="visually-hidden js-latus-columns">
        <data value="checkbox" data-latus-clearwidth="true"></data>
        <data value="id" data-latus-clearwidth="true">#</data>
        <data value="name">Name</data>
        <data value="child_roles" data-latus-clearwidth="true">Unterrollen</data>
        <data value="actions" data-latus-clearwidth="true" data-latus-class="align-text-end p-0 js-actions">Aktionen
        </data>
    </div>
    <div id="tableWrapper">

    </div>

</div>