<script>
    window.model = 'role';
    window.action = 'edit';
    window.exposed = {
        attributes: {
            id: {{ $role->id }}
        },
        trans: {
            'edit.success.title': '{{ __('latus::role.edit.success.title') }}',
            'edit.success.text': '{{ __('latus::role.edit.success.text') }}',
        },
        auth: {
            'role.permission.update': Boolean({{ \Illuminate\Support\Facades\Gate::allows('updatePermissions', $role) }}),
        },
        routes: {
            'roles.addableChildren': '{{ route('roles.addableChildren', ['role' => $role->id]) }}'
        },
        userLevel: Number({{ auth()->user()->primaryRole()->level }}),
        role: JSON.parse('{!! json_encode($role->toArray()) !!}'),
    }
</script>

@if($is_locked)
    <script>
        document.addEventListener('latus.role-form.finished', function () {
            console.log('effe');
            document.dispatchEvent(new Event('latus.model-locked'));
        });
    </script>
@endif

<x-latus-bs5::modal id="lockedModelModal" data-bs-backdrop="static" data-bs-keyboard="false">
    <x-slot name="header">
        <h5 class="modal-title">
            {{ __('latus::role.action.prompt.locked.title') }} <b>{{ $role->name }} (#{{ $role->id }})</b>
        </h5>
    </x-slot>

    <x-slot name="body">
        {!! __('latus::role.action.prompt.locked.text') !!}
    </x-slot>

    <x-slot name="footer">
        <button type="button" class="btn btn-primary"
                onclick="window.location.reload();">{{ __('latus::role.action.prompt.refresh') }}</button>
    </x-slot>
</x-latus-bs5::modal>

@php($crumbs = [
    ['url' => route('admin'), 'label' => __('latus::nav.administration')],
    ['url' => route('roles.index'), 'label' => __('latus::nav.roles')],
    ['label' => __('latus::nav.role.edit')]
])

<x-latus.createPage :crumbs="$crumbs">
    <x-slot name="content">
        <div class="block">
            <div class="h5 mb-3">{{ __('latus::nav.role.edit.title') }}</div>
            <div id="roleMasterFormContainer"></div>
        </div>
    </x-slot>
</x-latus.createPage>