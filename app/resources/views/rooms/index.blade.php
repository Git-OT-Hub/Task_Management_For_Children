@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header text-center custom-main-color">{{ __('rooms.list') }}</div>

                        <div class="card-body">
                            検索機能
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-start mt-3">
                <div class="col">
                    <a class="btn btn-primary shadow" href="{{ route('rooms.create') }}">
                        {{ __('rooms.create') }}
                    </a>
                </div>
            </div>
            <div class="row">
                @forelse ($results as $result)
                    @if ($result["join_status"] == 0)
                        <div class="col-12 col-lg-6 mt-3">
                            <div class="p-3 rounded shadow h-100">
                                <h2>
                                    {{ $result["room_name"] }}
                                </h2>
                                <div class="card">
                                    <div class="card-header text-center custom-main-color">{{ __('rooms.master') }}</div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                                    @if($result["room_master_icon"])
                                                        <img src="{{ Storage::url($result['room_master_icon']) }}" alt="" class="img-thumbnail rounded-circle">
                                                    @else
                                                        <img src="{{ asset('images/no_image.png') }}" alt="" class="img-thumbnail rounded-circle">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-9 align-self-center">
                                                <p class="mb-0 fs-4">{{ $result["room_master"] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-0 fs-4 text-danger">{{ __('rooms.invited') }}</p>
                                </div>
                                <div class="mt-3 text-center">
                                    <form method="post" action="{{ route('rooms.join', ['room' => $result['room_id']]) }}" id="room-join-form">
                                        @csrf
                                        <button type="submit" class="btn btn-primary shadow">
                                            {{ __('rooms.join') }}
                                        </button>
                                    </form>
                                </div>
                                <p class="mb-0 mt-3">
                                    {{ __('rooms.date') }}：
                                    <time datetime="{{ $result['created_at'] }}">
                                        {{ $result['created_at']->format('Y/m/d') }}
                                    </time>
                                </p>
                            </div>
                        </div>
                    @elseif ($result["join_status"] == 1)
                        <div class="col-12 col-lg-6 mt-3">
                            <div class="p-3 rounded shadow h-100">
                                <h2>
                                    <a href="{{ route('rooms.show', ['room' => $result['room_id']]) }}" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{ $result["room_name"] }}</a>
                                </h2>
                                <div class="card">
                                    <div class="card-header text-center custom-main-color">{{ __('rooms.master') }}</div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                                    @if($result["room_master_icon"])
                                                        <img src="{{ Storage::url($result['room_master_icon']) }}" alt="" class="img-thumbnail rounded-circle">
                                                    @else
                                                        <img src="{{ asset('images/no_image.png') }}" alt="" class="img-thumbnail rounded-circle">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-9 align-self-center">
                                                <p class="mb-0 fs-4">{{ $result["room_master"] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-3">
                                    <div class="card-header text-center custom-main-color">{{ __('rooms.executor') }}</div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                                    @if($result["participant_icon"])
                                                        <img src="{{ Storage::url($result['participant_icon']) }}" alt="" class="img-thumbnail rounded-circle">
                                                    @else
                                                        <img src="{{ asset('images/no_image.png') }}" alt="" class="img-thumbnail rounded-circle">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-9 align-self-center">
                                                <p class="mb-0 fs-4">{{ $result["participant"] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 mt-3">
                                    {{ __('rooms.date') }}：
                                    <time datetime="{{ $result['created_at'] }}">
                                        {{ $result['created_at']->format('Y/m/d') }}
                                    </time>
                                </p>
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-12 mt-3">
                        <p class="mb-0 fs-4">{{ __('rooms.no') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<div class="container mt-5">
    {{ $rooms->links() }}
</div>
@endsection
