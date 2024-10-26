@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header text-center custom-main-color">{{ __('rooms.create') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('rooms.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <small class="col">{{ __('rooms.room_explanation') }}</small>
                        </div>

                        <div class="row mb-4">
                            <label for="room_name" class="col-12 col-form-label">{{ __('rooms.name') }}</label>

                            <div class="col-12">
                                <input id="room_name" type="text" class="form-control @error('room_name') is-invalid @enderror" name="room_name" value="{{ old('room_name') }}" required autocomplete="room_name" autofocus>

                                @error('room_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <small class="col-12">{{ __('rooms.user_explanation') }}</small>
                        </div>
                        <div class="row mb-3">
                            <label for="user_name" class="col-12 col-form-label">{{ __('rooms.user') }}</label>

                            <div class="col-12">
                                <input id="user_name" type="text" class="form-control @error('user_name') is-invalid @enderror" name="user_name" value="{{ old('user_name') }}" required autocomplete="user_name">

                                @error('user_name')
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
                                        {{ __('rooms.create') }}
                                    </button>
                                </div>

                                <div class="mt-3 text-center">
                                    <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('rooms.index') }}">
                                        <i class="fa-solid fa-reply"></i>
                                        {{ __('rooms.list') }}
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
