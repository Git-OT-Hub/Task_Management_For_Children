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
                        @if($task->image)
                            <img src="{{ Storage::url($task->image) }}" class="img-fluid rounded" alt="">
                        @else
                            <img src="{{ asset('images/test_task_image.png') }}" class="img-fluid rounded" alt="">
                        @endif
                    </div>

                    @if(isset($imageGenerationFailure))
                        <div class="alert alert-danger mt-4" role="alert">
                            {{ $imageGenerationFailure }}
                        </div>
                    @endif
                    
                    <div class="accordion mt-4" id="accordionGenerateImage">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('tasks.image_generation') }}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionGenerateImage">
                                <div class="accordion-body">
                                    <form method="POST" action="{{ route('rooms.tasks.image.ai', ['room' => $room, 'task' => $task]) }}">
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
