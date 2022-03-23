<script>
    window.model = 'role';
    window.action = 'create';
    window.exposed = {
        attributes: {},
        trans: {
            'create.success.title': '{{ __('latus::role.create.success.title') }}',
            'create.success.text': '{{ __('latus::role.create.success.text') }}',
        },
        auth: {
            'role.permission.add': Boolean({{ \Illuminate\Support\Facades\Gate::allows('addPermissions', \Latus\Permissions\Models\Role::class) }}),
        },
        routes: {
            'roles.addableChildren': '{{ route('roles.addableChildren') }}'
        },
        userLevel: Number({{ auth()->user()->primaryRole()->level }})
    }
</script>

@php($crumbs = [
    ['url' => route('admin'), 'label' => __('latus::nav.administration')],
    ['url' => route('roles.index'), 'label' => __('latus::nav.roles')],
    ['label' => __('latus::nav.role.create')]
])

<x-latus.createPage :crumbs="$crumbs">
    <x-slot name="content">
        <div class="block">
            <div class="h5 mb-3">{{ __('latus::nav.role.create.title') }}</div>
            <div id="roleMasterFormContainer"></div>
        </div>
    </x-slot>
</x-latus.createPage>