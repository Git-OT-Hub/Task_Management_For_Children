@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-center fs-5 custom-main-color">{{ __('tasks.edit') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('rooms.tasks.update', ['room' => $room, 'task' => $task]) }}">
                        @method("PATCH")
                        @csrf

                        <div class="row mb-3">
                            <label for="title" class="col-12 col-form-label">{{ __('tasks.title') }}</label>

                            <div class="col-12">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $task->title) }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label for="deadline" class="col-12 col-form-label">{{ __('tasks.deadline') }}</label>

                            <div class="col-12">
                                <input id="deadline" type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" name="deadline" value="{{ old('deadline', $task->deadline) }}" required>

                                @error('deadline')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <small class="col-12">{{ __('tasks.point_explanation') }}</small>
                        </div>
                        <div class="row mb-3">
                            <label for="point" class="col-12 col-form-label">{{ __('tasks.point') }}</label>

                            <div class="col-12">
                                <input id="point" type="number" class="form-control @error('point') is-invalid @enderror" name="point" value="{{ old('point', $task->point) }}" required>

                                @error('point')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="body" class="col-12 col-form-label">{{ __('tasks.body') }}</label>

                            <div class="col-12">
                                <textarea id="body" name="body" rows="4" class="form-control @error('body') is-invalid @enderror">{{ old('body', $task->body) }}</textarea>

                                @error('body')
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
                                        {{ __('tasks.edit') }}
                                    </button>
                                </div>

                                <div class="mt-3 text-center">
                                    <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('rooms.tasks.show', ['room' => $room, 'task' => $task]) }}">
                                        <i class="fa-solid fa-reply"></i>
                                        {{ __('tasks.show') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
