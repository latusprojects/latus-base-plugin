<script>
    window.model = 'page';
    window.action = 'edit';
    window.lb_editor = true;
    window.exposed = {
        attributes: {},
        routes: {
            'pages.update': '{{ route('pages.update', ['page' => $page->id]) }}',
            'pages.index': '{{ route('pages.index') }}',
        },
        trans: {
            'edit.success.title': '{{ __('latus::page.edit.success.title') }}',
            'edit.success.text': '{{ __('latus::page.edit.success.text') }}',
        }
    }
</script>

@php($crumbs = [
    ['url' => route('admin'), 'label' => __('latus::nav.content')],
    ['url' => route('pages.index'), 'label' => __('latus::nav.content.pages')],
    ['label' => __('latus::nav.content.page.edit')]
])

<x-latus.editPage :crumbs="$crumbs">
    <x-slot name="content">
        <div class="block">
            <div class="h5 mb-3">{{ __('latus::nav.content.page.edit.title') }}: #{{ $page->id }}</div>
        </div>
        <div class="block p-0 ps-1 pe-1 overflow-hidden">
            <form novalidate class="needs-validation" id="editPageForm">
                <div class="row p-3">
                    <div class="col-12">
                        <label for="titleInput">Title</label>
                        <input type="text" class="form-control" id="titleInput" name="titleInput"
                               value="{{ $page->title }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 ps-0 pe-0">
                        <textarea id="textInput" name="textInput" hidden>{{ $page->getRawContent() }}</textarea>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary js-latus-save"
                       value="{{ __('latus::page.form.save.label') }}">
            </form>
        </div>
    </x-slot>
</x-latus.editPage>