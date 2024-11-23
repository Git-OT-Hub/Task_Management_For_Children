@extends('layouts.layout')

@section('title', '課題詳細')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header text-center fs-5 custom-main-color">{{ $task->title }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-4 align-self-center text-center">
                            <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('rooms.show', $room) }}">
                                <i class="fa-solid fa-reply fa-xl"></i>
                                <span class="fs-5">{{ __('rooms.show') }}</span>
                            </a>
                        </div>
                        <div class="col-4 ms-auto text-center">
                            @if($task->complete_flg == 1 && $task->approval_flg == 0)
                                <span class="btn btn-warning rounded-pill">
                                    {{ __('tasks.completion_reported') }}
                                </span>
                            @elseif($task->complete_flg == 1 && $task->approval_flg == 1)
                                <span class="btn btn-danger rounded-pill">
                                    {{ __('tasks.completed') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="text-center">
                        @if($task->image)
                            <div class="text-center">
                                <img src="{{ Storage::url($task->image) }}" class="img-fluid rounded" alt="">
                            </div>

                            @if(Auth::user()->id === $room->user_id)
                                <div class="mt-2 text-end">
                                    <form method="POST" action="{{ route('rooms.tasks.image.destroy', ['room' => $room, 'task' => $task]) }}" id="delete-task-image">
                                        @method("DELETE")
                                        @csrf

                                        <button type="submit" class="btn btn-danger shadow">
                                            {{ __('tasks.image_delete') }}
                                        </button>
                                    </form>
                                </div>
                            @endif

                        @else
                            <div class="text-center">
                                <img src="{{ asset('images/no_image.png') }}" class="img-fluid rounded" alt="">
                            </div>
                        @endif
                    </div>

                    @if(session("imageGenerationFailure"))
                        <div class="alert alert-danger mt-4" role="alert">
                            {{ session("imageGenerationFailure") }}
                        </div>
                    @endif
                    
                    @if(Auth::user()->id === $room->user_id)
                        <div class="accordion mt-4" id="accordionGenerateImage">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('tasks.image_generation') }}
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionGenerateImage">
                                    <div class="accordion-body">
                                        <form method="POST" action="{{ route('rooms.tasks.image.ai', ['room' => $room, 'task' => $task]) }}" id="image-generation-form">
                                            @csrf

                                            <div class="row mb-2">
                                                <small class="col">{{ __('tasks.image_generation_explanation') }}</small>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-12">
                                                    <input type="text" class="form-control @error('image_description') is-invalid @enderror" name="image_description" value="{{ old('image_description') }}" required>

                                                    @error('image_description')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="row mb-0">
                                                <div class="col-12">
                                                    <div class="text-end">
                                                        <button type="submit" class="btn btn-primary shadow">
                                                            {{ __('tasks.image_generation') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="loading-overlay-task" class="custom-hidden">
                        <div class="custom-loading-spinner">
                            <div class="d-flex align-items-center">
                                <strong class="fs-3 text-primary" role="status">{{ __('tasks.image_generation_progress') }}</strong>
                                <div class="spinner-border ms-auto text-primary" style="width: 3rem; height: 3rem;" aria-hidden="true"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <p class="card-text">
                        {{ __('tasks.point') }}：{{ $task->point }}
                    </p>
                    <p class="card-text">
                        {{ __('tasks.deadline') }}：{{ $task->deadline }}
                    </p>
                    <p class="card-text mb-1">
                        {{ __('tasks.body') }}：
                    </p>
                    <p class="card-text border border-2 p-2">
                        {!! nl2br(e($task->body)) !!}
                    </p>
                    <p class="card-text">
                        <small class="text-body-secondary">
                            {{ __('tasks.created_at') }}：{{ $task->created_at->format('Y/m/d') }}
                        </small>
                    </p>
                </div>

                <div class="card-body">
                    @if(Auth::user()->id === $room->user_id)
                        <div class="row align-items-center justify-content-end mb-4">
                            <div class="col-3 text-end">
                                <a class="btn btn-secondary shadow" href="{{ route('rooms.tasks.edit', ['room' => $room, 'task' => $task]) }}">
                                    {{ __('tasks.edit') }}
                                </a>
                            </div>
                            <div class="col-3 text-end">
                                <form method="POST" action="{{ route('rooms.tasks.destroy', ['room' => $room, 'task' => $task]) }}" id="delete-task">
                                    @method("DELETE")
                                    @csrf

                                    <button type="submit" class="btn btn-danger shadow">
                                        {{ __('tasks.delete') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="row align-items-center justify-content-center">
                            @if($task->approval_flg == 0 && $task->complete_flg == 1)
                                <div class="col-12 text-center">
                                    <div class="alert alert-warning" role="alert">
                                        {{ __('tasks.there_was_completion_report') }}
                                    </div>
                                </div>
                            @endif

                            @if($task->approval_flg == 1 && $task->complete_flg == 1)
                                <div class="col-12 text-center">
                                    <div class="alert alert-success" role="alert">
                                        {{ __('tasks.approved') }}
                                    </div>
                                </div>
                            @else
                                <div class="col-3 text-center">
                                    <form method="POST" action="{{ route('rooms.tasks.redo', ['room' => $room, 'task' => $task]) }}" id="redo">
                                        @csrf

                                        @if($task->approval_flg == 0 && $task->complete_flg == 1)
                                            <button type="submit" class="btn btn-warning shadow">
                                                {{ __('tasks.redo') }}
                                            </button>
                                        @elseif($task->approval_flg == 0 && $task->complete_flg == 0)
                                            <button type="submit" class="btn btn-warning shadow" disabled>
                                                {{ __('tasks.redo') }}
                                            </button>
                                        @endif
                                    </form>
                                </div>
                                <div class="col-3 text-center">
                                    <form method="POST" action="{{ route('rooms.tasks.approval', ['room' => $room, 'task' => $task]) }}" id="approval">
                                        @csrf

                                        @if($task->approval_flg == 0 && $task->complete_flg == 1)
                                            <button type="submit" class="btn btn-success shadow">
                                                {{ __('tasks.approval') }}
                                            </button>
                                        @elseif($task->approval_flg == 0 && $task->complete_flg == 0)
                                            <button type="submit" class="btn btn-success shadow" disabled>
                                                {{ __('tasks.approval') }}
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            @endif
                        </div>
                    @elseif(Auth::user()->id === $task->task_recipient)
                        <div class="row align-items-center justify-content-center">
                            @if($task->approval_flg == 1 && $task->complete_flg == 1)
                                <div class="col-12 text-center">
                                    <div class="alert alert-success" role="alert">
                                        {{ __('tasks.is_approved') }}
                                    </div>
                                </div>
                            @elseif($task->complete_flg == 1 && $task->approval_flg == 0)
                                <div class="col-12 text-center">
                                    <div class="alert alert-warning" role="alert">
                                        {{ __('tasks.completion_report_in_progress') }}
                                    </div>
                                </div>
                            @elseif($task->complete_flg == 0 && $task->approval_flg == 0)
                                <div class="col-3 text-center">
                                    <form method="POST" action="{{ route('rooms.tasks.completion', ['room' => $room, 'task' => $task]) }}" id="completion-report">
                                        @csrf

                                        <button type="submit" class="btn btn-success shadow">
                                            {{ __('tasks.completion_report') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
