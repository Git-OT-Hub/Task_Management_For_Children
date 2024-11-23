@extends('layouts.layout')

@section('title', 'ルーム詳細')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header text-center fs-5 custom-main-color text-white" id="room-name">{{ $room->name }}</div>

                        <div class="card-body border-bottom border-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            {{ __('rooms.master') }}
                                            <span class="badge text-bg-success align-middle ms-3">{{ __('rooms.participating') }}</span>
                                        </div>
                                        <div class="col-3">
                                            <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                                @if($room_member["room_master_icon"])
                                                    <img src="{{ Storage::url($room_member['room_master_icon']) }}" alt="" class="img-thumbnail rounded-circle">
                                                @else
                                                    <img src="{{ asset('images/no_image.png') }}" alt="" class="img-thumbnail rounded-circle">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-9 align-self-center">
                                            <p class="mb-0 fs-5">{{ $room_member["room_master_name"] }}</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-12 mb-1">
                                            {{ __('rooms.executor') }}
                                            @if($room_member["participant_join_flg"] == 0)
                                                <span class="badge text-bg-warning align-middle ms-3">{{ __('rooms.invitation') }}</span>
                                            @else
                                                <span class="badge text-bg-success align-middle ms-3">{{ __('rooms.participating') }}</span>
                                            @endif
                                        </div>
                                        <div class="col-3">
                                            <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                                @if($room_member["participant_icon"])
                                                    <img src="{{ Storage::url($room_member['participant_icon']) }}" alt="" class="img-thumbnail rounded-circle">
                                                @else
                                                    <img src="{{ asset('images/no_image.png') }}" alt="" class="img-thumbnail rounded-circle">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-9 align-self-center">
                                            <p class="mb-0 fs-5">{{ $room_member["participant_name"] }}</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body border-bottom border-3">
                            <div class="row">
                                <div class="col-4 align-self-center text-center">
                                    <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('rooms.index') }}">
                                        <i class="fa-solid fa-reply fa-xl"></i>
                                        <span class="fs-5">{{ __('rooms.list') }}</span>
                                    </a>
                                </div>
                                <div class="col-6 ms-auto text-center">
                                    @if(Auth::user()->id === $room->user_id)
                                        <div class="dropdown custom-room-button">
                                            <button type="button" class="btn btn-secondary shadow dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                <i class="fa-solid fa-pen-to-square fa-xl"></i>
                                            </button>
                                            <form class="dropdown-menu p-4 dropdown-menu-end shadow">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="room_name" class="form-label">{{ __('rooms.name') }}</label>
                                                    <input type="text" class="form-control @error('room_name') is-invalid @enderror" id="room_name" name="room_name" value="{{ old('room-name', $room->name) }}" required autocomplete="room_name" autofocus>

                                                    <ul id="room-error-message" class="fw-bold text-danger">
                                                    </ul>

                                                </div>
                                                <input type="hidden" id="room-edit-id" value="{{ $room->id }}">
                                                <input type="hidden" id="room-edit-recipient" name="user_name" value="{{ $recipient }}">
                                                <div class="text-end">
                                                    <button type="button" class="btn btn-primary shadow" id="room-edit">
                                                        <i class="fa-solid fa-pen-to-square fa-xl"></i>
                                                    </button>
                                                </div>
                                            </form>
                                            @include("rooms.edit_script")
                                        </div>
                                        <div class="custom-room-button ms-3">
                                            <form method="POST" action="{{ route('rooms.destroy', $room) }}" id="room-delete-form">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger shadow">
                                                    <i class="fa-solid fa-trash-can fa-xl"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <form class="tasks-search-form">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <input type="search" class="form-control" placeholder="{{ __('tasks.title') }}" id="" name="title" value="">
                                    </div>
                                    <div class="col-6">
                                        <select class="form-select" id="" name="status">
                                            <option value="">{{ __('tasks.select_status') }}</option>
                                            <option value="none">{{ __('tasks.not_completion_reported') }}</option>
                                            <option value="reported">{{ __('tasks.completion_reported') }}</option>
                                            <option value="completed">{{ __('tasks.completed') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3 align-items-center">
                                    <div class="col-12">
                                        <label class="form-label mb-0">{{ __('tasks.deadline') }}</label>
                                    </div>
                                    <div class="col-5 pe-0">
                                        <input type="datetime-local" class="form-control" name="deadline_from" value="">
                                    </div>
                                    <div class="col-2 text-center px-0">
                                        <span class="">~</span>
                                    </div>
                                    <div class="col-5 ps-0">
                                        <input type="datetime-local" class="form-control" name="deadline_until" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="row align-items-center">
                                            <div class="col-12">
                                                <label class="form-label mb-0">{{ __('tasks.point') }}</label>
                                            </div>
                                            <div class="col-5 pe-0">
                                                <input type="number" class="form-control" name="point_from" value="">
                                            </div>
                                            <div class="col-2 text-center px-0">
                                                <span class="">~</span>
                                            </div>
                                            <div class="col-5 ps-0">
                                                <input type="number" class="form-control" name="point_until" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                    <div class="col-6 align-self-end">
                                        <div class="row">
                                            <div class="col-6 text-end">
                                                <button type="button" class="btn btn-primary shadow" id="tasks-search-btn"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
                                            </div>
                                            <div class="col-6 text-end">
                                                <a href="{{ route('rooms.show', $room) }}" class="btn btn-secondary shadow">{{ __('tasks.reset') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @include("rooms.tasks.search_script")
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-4 text-center">
                    @if(Auth::user()->id === $room->user_id)
                        <a class="btn btn-primary shadow" href="{{ route('rooms.tasks.create', $room) }}">
                            {{ __('tasks.create') }}
                        </a>
                    @endif
                </div>
                <div class="col-4 offset-4 text-center">
                    <a class="btn btn-success shadow" href="{{ route('rooms.rewards.index', $room) }}">
                        {{ __('rewards.list') }}
                    </a>
                </div>
            </div>
            <div class="row mt-4" id="tasks-list">
                @include("rooms.tasks.task_list")
            </div>
        </div>
    </div>
</div>
@endsection
