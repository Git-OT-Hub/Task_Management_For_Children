@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header text-center custom-main-color">{{ __('Room List') }}</div>

                        <div class="card-body">
                            検索機能
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-start mt-3">
                <div class="col">
                    <a class="btn btn-primary shadow" href="{{ route('rooms.create') }}">
                        {{ __('Create a Room') }}
                    </a>
                </div>
            </div>
            <div class="row">
                @forelse ($results as $result)
                    @if ($result["join_status"] == 0)
                        <div class="col-12 col-lg-6 mt-3">
                            <div class="p-3 rounded shadow h-100">
                                <div class="card">
                                    <div class="card-header text-center custom-main-color">{{ __('Room Master') }}</div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                                    <img src="{{ asset('images/test_header_icon.png') }}" alt="" class="img-thumbnail rounded-circle">
                                                </div>
                                            </div>
                                            <div class="col-9 align-self-center">
                                                <p class="mb-0 fs-4">{{ $result["room_master"] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <p class="mb-0 fs-4">{{ __('You are invited') }}</p>
                                    <p class="mb-0 mt-2 fs-4">
                                        {{ __('Room Name') }}{{ $result["room_name"] }}
                                    </p>
                                </div>
                                <div class="mt-3 text-center">
                                    <a class="btn btn-primary shadow" href="#">
                                        {{ __('Join') }}
                                    </a>
                                </div>
                                <p class="mb-0 mt-3">
                                    {{ __('Created Date') }}
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
                                    <a href="#" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">{{ $result["room_name"] }}</a>
                                </h2>
                                <div class="card">
                                    <div class="card-header text-center custom-main-color">{{ __('Room Master') }}</div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                                    <img src="{{ asset('images/test_header_icon.png') }}" alt="" class="img-thumbnail rounded-circle">
                                                </div>
                                            </div>
                                            <div class="col-9 align-self-center">
                                                <p class="mb-0 fs-4">{{ $result["room_master"] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mt-3">
                                    <div class="card-header text-center custom-main-color">{{ __('Task Executor') }}</div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                                    <img src="{{ asset('images/test_header_icon.png') }}" alt="" class="img-thumbnail rounded-circle">
                                                </div>
                                            </div>
                                            <div class="col-9 align-self-center">
                                                <p class="mb-0 fs-4">{{ $result["participant"] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-0 mt-3">
                                    {{ __('Created Date') }}
                                    <time datetime="{{ $result['created_at'] }}">
                                        {{ $result['created_at']->format('Y/m/d') }}
                                    </time>
                                </p>
                            </div>
                        </div>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection