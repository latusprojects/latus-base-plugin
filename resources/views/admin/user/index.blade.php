<script>
    window.model = 'user';
    window.action = 'index';
</script>

<div id="content-head">
    <div class="content-header mb-2">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin') }}">{{ __('latus::nav.administration') }}</a>
                </li>
                <li class="breadcrumb-item"><a
                            href="{{ route('users.index') }}">{{ __('latus::nav.users') }}</a></li>
                <li class="breadcrumb-item active">{{ __('latus::nav.user.index') }}</li>
            </ol>
        </nav>
    </div>
</div>
<div id="content-main" is="latus-filterable-table" data-latus-route="{{ route('users.index') }}"
     data-latus-target-id="tableWrapper">
    <div class="row">
        <div class="col-12 col-md-6 col-xxl-4">
            <input class="form-control" data-latus-filter="search" placeholder="Suche nach: #ID, E-Mail">
        </div>
        <div class="col-auto flex-fill"></div>
        <label class="col-auto col-form-label" for="sortBySelect">Sortieren nach</label>
        <div class="col-auto">
            <select class="form-select" id="sortBySelect" data-latus-filter="sort">
                <option value="newest">Datum</option>
                <option value="id">#ID</option>
                <option value="email">E-Mail-Adresse</option>
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
        <data value="email">E-Mail Adresse</data>
        <data value="actions">Aktionen</data>
    </div>
    <div id="tableWrapper">

    </div>

</div>