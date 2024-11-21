<tr id="task-{{ $task->id }}">
    <td class="task-id align-middle">{{ $task->id }}</td>
    <td class="task-title align-middle">{{ $task->title }}</td>
    <td class="task-deadline align-middle">{{ $task->deadline }}</td>
    <td class="task-point align-middle">{{ $task->point }}</td>
    <td class="task-status align-middle">
        @if ($task->complete_flg == 1 && $task->approval_flg == 1)
            {{ __('admin.accomplished') }}
        @elseif ($task->complete_flg == 1 && $task->approval_flg == 0)
            {{ __('admin.completion_report_in_progress') }}
        @else
            {{ __('admin.no_completion_no_accomplished') }}
        @endif
    </td>
    <td class="task-room-id align-middle">{{ $task->room_id }}</td>
    <td class="text-end align-middle">
        <form class="task-delete-form">
            @csrf
            <button type="button" class="btn btn-danger shadow" value="{{ $task->id }}"><i class="fa-solid fa-trash-can fa-lg"></i></button>
        </form>
    </td>
</tr>
