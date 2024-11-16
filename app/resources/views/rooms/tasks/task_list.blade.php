@forelse ($results as $result)
    <div class="col-12 col-lg-6 mt-3">
        <div class="card h-100 shadow">
            <div class="row g-0">
                <div class="col-4 align-self-center p-3">
                    @if($result["task_image"])
                        <img src="{{ Storage::url($result['task_image']) }}" class="img-fluid rounded" alt="">
                    @else
                        <img src="{{ asset('images/no_image.png') }}" class="img-fluid rounded" alt="">
                    @endif
                </div>
                <div class="col-8">
                    <div class="card-body">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-4">
                                <small class="text-body-secondary">
                                    {{ __('tasks.creator') }}
                                </small>
                            </div>
                            <div class="col-8 text-end">
                                @if($result["task_complete_flg"] == 1 && $result["task_approval_flg"] == 0)
                                    <span class="btn btn-warning rounded-pill">
                                        {{ __('tasks.completion_reported') }}
                                    </span>
                                @elseif($result["task_complete_flg"] == 1 && $result["task_approval_flg"] == 1)
                                    <span class="btn btn-danger rounded-pill">
                                        {{ __('tasks.completed') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="border-bottom border-5 py-3">
                            <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                @if($result["sender_icon"])
                                    <img src="{{ Storage::url($result['sender_icon']) }}" alt="" class="img-thumbnail rounded-circle">
                                @else
                                    <img src="{{ asset('images/no_image.png') }}" alt="" class="img-thumbnail rounded-circle">
                                @endif
                            </div>
                            <span class="mb-0 fs-4 ms-3">
                                {{ $result["sender_name"] }}
                            </span>
                        </div>

                        <h4 class="card-title my-3">
                            <a href="{{ route('rooms.tasks.show', ['room' => $room, 'task' => $result['task_id']]) }}" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{ $result["task_title"] }}</a>
                        </h4>
                        <p class="card-text">
                            {{ __('tasks.point') }}：{{ $result["task_point"] }}
                        </p>
                        <p class="card-text">
                            {{ __('tasks.deadline') }}：{{ $result["task_deadline"] }}
                        </p>
                        <p class="card-text">
                            <small class="text-body-secondary">
                                {{ __('tasks.created_at') }}：{{ $result["task_created_at"]->format('Y/m/d') }}
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12 mt-3">
        <p class="mb-0 fs-4">{{ __('tasks.no') }}</p>
    </div>
@endforelse
<div class="col-12 mt-4">
    {{ $tasks->links() }}
</div>
