@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-center fs-5 custom-main-color">{{ $task->title }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-4 align-self-center text-center">
                            <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('rooms.show', $room) }}">
                                <i class="fa-solid fa-reply"></i>
                                {{ __('rooms.show') }}
                            </a>
                        </div>
                        <div class="col-4 ms-auto text-center">
                            @if($task->complete_flg == 1 && $task->approval_flg == 0)
                                <span class="btn btn-warning">
                                    {{ __('tasks.completion_reported') }}
                                </span>
                            @elseif($task->complete_flg == 1 && $task->approval_flg == 1)
                                <span class="btn btn-danger">
                                    {{ __('tasks.completed') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('images/test_task_image.png') }}" class="img-fluid rounded" alt="">
                    </div>
                </div>

                <div class="card-body">
                    <p class="card-text">
                        {{ __('tasks.point') }}：{{ $task->point }}
                    </p>
                    <p class="card-text">
                        {{ __('tasks.deadline') }}：{{ $task->deadline }}
                    </p>
                    <p class="card-text">
                        {{ __('tasks.body') }}：<br>
                        {!! nl2br(e($task->body)) !!}
                    </p>
                    <p class="card-text">
                        <small class="text-body-secondary">
                            {{ __('tasks.created_at') }}：{{ $task->created_at->format('Y/m/d') }}
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
