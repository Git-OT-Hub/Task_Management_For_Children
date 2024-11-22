<tr id="reward-{{ $reward->id }}">
    <td class="reward-id align-middle">{{ $reward->id }}</td>
    <td class="reward align-middle">{{ $reward->reward }}</td>
    <td class="reward_point align-middle">{{ $reward->point }}</td>
    <td class="reward_status align-middle">
        @if ($reward->acquired_flg == 1)
            {{ __('admin.already_acquired') }}
        @endif
    </td>
    <td class="reward-room-id align-middle">{{ $reward->room_id }}</td>
    <td class="text-end align-middle">
        <form class="reward-delete-form">
            @csrf
            <button type="button" class="btn btn-danger shadow" value="{{ $reward->id }}"><i class="fa-solid fa-trash-can fa-lg"></i></button>
        </form>
    </td>
</tr>
