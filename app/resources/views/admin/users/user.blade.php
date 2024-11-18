<tr id="user-{{ $user->id }}">
    <td class="user-id align-middle">{{ $user->id }}</td>
    <td class="user-name align-middle">{{ $user->name }}</td>
    <td class="user-email align-middle">{{ $user->email }}</td>
    <td class="text-end">
        <form class="user-delete-form">
            @csrf
            <button type="button" class="btn btn-danger shadow" value="{{ $user->id }}"><i class="fa-solid fa-trash-can fa-lg"></i></button>
        </form>
    </td>
</tr>
