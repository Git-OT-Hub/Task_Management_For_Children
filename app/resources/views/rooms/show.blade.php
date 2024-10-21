@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header text-center custom-main-color">{{ $room->name }}</div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 align-self-center text-center">
                                    <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('rooms.index') }}">
                                        <i class="fa-solid fa-reply"></i>
                                        {{ __('rooms.list') }}
                                    </a>
                                </div>
                                <div class="col-4 ms-auto text-center">
                                    <a class="btn btn-secondary shadow" href="#">
                                        {{ __('rooms.edit') }}
                                    </a>
                                    <a class="btn btn-danger shadow ms-3" href="#">
                                        {{ __('rooms.delete') }}
                                    </a>
                                </div>
                            </div>
                            検索機能
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4 text-center">
                    <a class="btn btn-primary shadow" href="#">
                        {{ __('tasks.create') }}
                    </a>
                </div>
                <div class="col-4 offset-4 text-center">
                    <a class="btn btn-success shadow" href="#">
                        {{ __('rewards.list') }}
                    </a>
                </div>
            </div>
            <div class="row">
                @forelse ($results as $result)
                    <div class="col-12 col-lg-6 mt-3">
                        <div class="card h-100 shadow">
                            <div class="row g-0">
                                <div class="col-4 align-self-center">
                                    <img src="{{ asset('images/test_task_image.png') }}" class="img-fluid rounded-start" alt="">
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
                                                    <span class="btn btn-warning">
                                                        {{ __('tasks.completion_reported') }}
                                                    </span>
                                                @elseif($result["task_complete_flg"] == 1 && $result["task_approval_flg"] == 1)
                                                    <span class="btn btn-danger">
                                                        {{ __('tasks.completed') }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="border-bottom border-5 py-3">
                                            <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                                <img src="{{ asset('images/test_header_icon.png') }}" alt="" class="img-thumbnail rounded-circle">
                                            </div>
                                            <span class="mb-0 fs-4 ms-3">
                                                {{ $result["sender_name"] }}
                                            </span>
                                        </div>

                                        <h4 class="card-title my-3">
                                            <a href="#" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{ $result["task_title"] }}</a>
                                        </h4>
                                        <p class="card-text">
                                            {{ __('tasks.point') }}：{{ $result["task_point"] }}
                                        </p>
                                        <p class="card-text">
                                            {{ __('tasks.deadline') }}：{{ $result["task_deadline"] }}
                                        </p>
                                        <p class="card-text">
                                            <small class="text-body-secondary">
                                                {{ __('tasks.created_at') }}：{{ $result["task_created_at"] }}
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
            </div>
        </div>
    </div>
</div>
@endsection
