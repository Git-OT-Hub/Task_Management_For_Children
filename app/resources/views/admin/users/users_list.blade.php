{{ $users->links() }}
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">{{ __('admin.id') }}</th>
            <th scope="col">{{ __('admin.name') }}</th>
            <th scope="col">{{ __('admin.email') }}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            @include("admin.users.user")
        @empty
            <tr class="no_users"><td colspan="4">{{ __('admin.no_users') }}</td></tr>
        @endforelse
    </table>
</table>
