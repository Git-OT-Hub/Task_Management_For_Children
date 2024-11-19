<tr id="room-{{ $result['room_id'] }}">
    <td class="room-id align-middle">{{ $result['room_id'] }}</td>
    <td class="room-name align-middle">{{ $result['room_name'] }}</td>
    <td class="master align-middle">{{ $result['master'] }}</td>
    <td class="implementer align-middle">{{ $result['implementer'] }}</td>
    <td class="text-end">
        <form class="room-delete-form">
            @csrf
            <button type="button" class="btn btn-danger shadow" value="{{ $result['room_id'] }}"><i class="fa-solid fa-trash-can fa-lg"></i></button>
        </form>
    </td>
</tr>
