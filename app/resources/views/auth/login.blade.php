@extends('layouts.layout')

@section('title', 'ログイン')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header text-center custom-main-color fs-5 text-white">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-right-to-bracket fa-xl"></i>
                                    </button>
                                </div>

                                @if (Route::has('register'))
                                    <div class="mt-3">
                                        <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-5" href="{{ route('register') }}">
                                            <i class="fa-solid fa-user-plus fa-xl"></i>
                                            {{ __('User registration here!') }}
                                        </a>
                                    </div>    
                                @endif
                                @if (Route::has('password.request'))
                                    <div class="mt-2">
                                        <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-5" href="{{ route('password.request') }}">
                                            <i class="fa-solid fa-key fa-xl"></i>
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
