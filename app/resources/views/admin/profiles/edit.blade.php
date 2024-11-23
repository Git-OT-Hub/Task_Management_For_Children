@extends('layouts.admin')

@section('title', 'プロフィール編集(管理者用)')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header text-center fs-5 custom-main-color text-white">{{ __('profiles.profile') }} {{ __('profiles.edit') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 align-self-center">
                            <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('admin.profiles.index') }}">
                                <i class="fa-solid fa-reply fa-xl"></i>
                                <span class="fs-5">{{ __('profiles.profile') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <form method="POST" action="{{ route('admin.profiles.update') }}" enctype="multipart/form-data">
                                @method("PATCH")
                                @csrf

                                <div class="row mb-3">
                                    <label for="name" class="col-12 col-form-label">{{ __('profiles.name') }}</label>

                                    <div class="col-12">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', Auth::user()->name) }}" required autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-12 col-form-label">{{ __('profiles.email') }}</label>

                                    <div class="col-12">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 profile-icon-input">
                                    <label for="icon" class="col-12 col-form-label">{{ __('profiles.icon') }}</label>

                                    <div class="col-12">
                                        <input id="icon" type="file" class="form-control @error('icon') is-invalid @enderror" name="icon" accept="image/jpeg, image/png, image/jpg, image/gif">

                                        @error('icon')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3 profile-icon-preview">
                                    <div class="col-12 text-center">
                                        <div class="ratio ratio-1x1 w-25 custom-user-icon"> 
                                            <img src="#" alt="" class="img-thumbnail rounded-circle shadow" style="display: none;" id="iconPreview">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary shadow">
                                                <i class="fa-solid fa-pen-to-square fa-xl"></i>
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
    </div>
</div>
@endsection
