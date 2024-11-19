{{ $rooms->links() }}
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">{{ __('admin.room_id') }}</th>
            <th scope="col">{{ __('admin.room_name') }}</th>
            <th scope="col">{{ __('admin.master') }}</th>
            <th scope="col">{{ __('admin.implementer') }}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($results as $result)
            @include("admin.rooms.room")
        @empty
            <tr class="no_rooms"><td colspan="5">{{ __('admin.no_rooms') }}</td></tr>
        @endforelse
    </table>
</table>
