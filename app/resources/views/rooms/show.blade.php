@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header text-center fs-5 custom-main-color" id="room-name">{{ $room->name }}</div>

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

                        <div class="card-body">
                            <div class="row">
                                <div class="col-4 align-self-center text-center">
                                    <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="#" onClick="history.back()">
                                        <i class="fa-solid fa-reply fa-2xl"></i>
                                        <span class="fs-5">{{ __('rooms.back') }}</span>
                                    </a>
                                </div>
                                <div class="col-4 ms-auto text-center">
                                    @if(Auth::user()->id === $room->user_id)
                                        <div class="dropdown custom-room-button">
                                            <button type="button" class="btn btn-secondary shadow dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                {{ __('rooms.edit') }}
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
                                                <button type="button" class="btn btn-primary shadow" id="room-edit">{{ __('rooms.update') }}</button>
                                            </form>
                                            @include("rooms.edit_script")
                                        </div>
                                        <div class="custom-room-button ms-3">
                                            <form method="POST" action="{{ route('rooms.destroy', $room) }}" id="room-delete-form">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-danger shadow">
                                                    {{ __('rooms.delete') }}
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            検索機能
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
            <div class="row">
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
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    {{ $tasks->links() }}
</div>
@endsection
