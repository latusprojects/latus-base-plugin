<script>
    window.model = 'user';
    window.action = 'edit';
    window.exposed = {
        attributes: {
            id: {{ $user->id }}
        },
        trans: {
            'edit.success.title': '{{ __('latus::user.edit.success.title') }}',
            'edit.success.text': '{{ __('latus::user.edit.success.text') }}',
        },
        auth: {
            'user.permission.update': Boolean({{ \Illuminate\Support\Facades\Gate::allows('updatePermissions', $user) }}),
        },
        routes: {
            'users.addableRoles': '{{ route('users.addableRoles', ['targetUser' => $user->id]) }}'
        },
        userLevel: Number({{ auth()->user()->primaryRole()->level }}),
        user: {
            name: '{{ $user->name }}',
            email: '{{ $user->email }}'
        },
    }
</script>

@php($crumbs = [
    ['url' => route('admin'), 'label' => __('latus::nav.administration')],
    ['url' => route('users.index'), 'label' => __('latus::nav.users')],
    ['label' => __('latus::nav.user.edit')]
])

<x-latus.createPage :crumbs="$crumbs">
    <x-slot name="content">
        <div class="block">
            <div class="h5 mb-3">{{ __('latus::nav.user.edit.title') }}</div>
            <div id="userMasterFormContainer"></div>
        </div>
    </x-slot>
</x-latus.createPage>