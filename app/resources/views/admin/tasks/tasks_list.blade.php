{{ $tasks->links() }}
<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">{{ __('admin.task_id') }}</th>
            <th scope="col">{{ __('admin.task_title') }}</th>
            <th scope="col">{{ __('admin.task_deadline') }}</th>
            <th scope="col">{{ __('admin.task_point') }}</th>
            <th scope="col">{{ __('admin.task_status') }}</th>
            <th scope="col">{{ __('admin.room_id') }}</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($tasks as $task)
            @include("admin.tasks.task")
        @empty
            <tr class="no_tasks"><td colspan="7">{{ __('admin.no_tasks') }}</td></tr>
        @endforelse
    </table>
</table>
