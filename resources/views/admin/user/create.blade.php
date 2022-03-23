<script>
    window.model = 'user';
    window.action = 'create';
    window.exposed = {
        attributes: {},
        trans: {
            'create.success.title': '{{ __('latus::user.create.success.title') }}',
            'create.success.text': '{{ __('latus::user.create.success.text') }}',
        },
        auth: {
            'user.permission.add': Boolean({{ \Illuminate\Support\Facades\Gate::allows('addPermissions', \Latus\Permissions\Models\User::class) }}),
        },
        routes: {
            'users.addableRoles': '{{ route('users.addableRoles') }}'
        },
        userLevel: Number({{ auth()->user()->primaryRole()->level }})
    }
</script>

@php($crumbs = [
    ['url' => route('admin'), 'label' => __('latus::nav.administration')],
    ['url' => route('users.index'), 'label' => __('latus::nav.users')],
    ['label' => __('latus::nav.user.create')]
])

<x-latus.createPage :crumbs="$crumbs">
    <x-slot name="content">
        <div class="block">
            <div class="h5 mb-3">{{ __('latus::nav.user.create.title') }}</div>
            <div id="userMasterFormContainer"></div>
        </div>
    </x-slot>
</x-latus.createPage>