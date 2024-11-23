@extends('layouts.layout')

@section('title', 'パスワード再設定の申請')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header text-center custom-main-color text-white fs-5">{{ __('Request a Password Reset') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
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

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-envelope fa-2xl"></i>
                                    </button>
                                </div>

                                @if (Route::has('login'))
                                    <div class="mt-3">
                                        <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover fs-5" href="{{ route('login') }}">
                                            <i class="fa-solid fa-right-to-bracket fa-xl"></i>
                                            {{ __('User login here!') }}
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
