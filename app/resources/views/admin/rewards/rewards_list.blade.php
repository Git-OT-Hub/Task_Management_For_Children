{{ $rewards->links() }}
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">{{ __('admin.reward_id') }}</th>
            <th scope="col">{{ __('admin.reward') }}</th>
            <th scope="col">{{ __('admin.reward_point') }}</th>
            <th scope="col">{{ __('admin.reward_status') }}</th>
            <th scope="col">{{ __('admin.room_id') }}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($rewards as $reward)
            @include("admin.rewards.reward")
        @empty
            <tr class="no_rewards"><td colspan="6">{{ __('admin.no_rewards') }}</td></tr>
        @endforelse
    </table>
</table>
