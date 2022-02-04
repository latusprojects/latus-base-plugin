<script>
    window.model = 'page';
    window.action = 'create';
    window.lb_editor = true;
    window.exposed = {
        attributes: {},
        routes: {
            'pages.store': '{{ route('pages.store') }}',
            'pages.index': '{{ route('pages.index') }}',
        },
        trans: {
            'create.success.title': '{{ __('latus::page.create.success.title') }}',
            'create.success.text': '{{ __('latus::page.create.success.text') }}',
        }
    }
</script>

@php($crumbs = [
    ['url' => route('admin'), 'label' => __('latus::nav.content')],
    ['url' => route('pages.index'), 'label' => __('latus::nav.content.pages')],
    ['label' => __('latus::nav.content.page.create')]
])

<x-latus.createPage :crumbs="$crumbs">
    <x-slot name="content">
        <div class="block">
            <div class="h5 mb-3">{{ __('latus::nav.content.page.create.title') }}</div>
        </div>
        <div class="block p-0 ps-1 pe-1 overflow-hidden">
            <form novalidate class="needs-validation" id="createPageForm">
                <div class="row">
                    <div class="col-12 ps-0 pe-0">
                        <textarea id="textInput" name="textInput" hidden></textarea>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary js-latus-save"
                       value="{{ __('latus::page.form.save.label') }}">
            </form>
        </div>
    </x-slot>
</x-latus.createPage>