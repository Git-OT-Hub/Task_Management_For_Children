@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header text-center fs-5 custom-main-color">{{ __('profiles.profile') }} {{ __('profiles.edit') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 align-self-center">
                            <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('profiles.index') }}">
                                <i class="fa-solid fa-reply"></i>
                                {{ __('profiles.profile') }}
                            </a>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <form method="POST" action="{{ route('profiles.update') }}">
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

                                <div class="row mb-3">
                                    <label for="goal" class="col-12 col-form-label">{{ __('profiles.goal') }}</label>

                                    <div class="col-12">
                                        <textarea id="goal" name="goal" rows="4" class="form-control @error('goal') is-invalid @enderror">{{ old('goal', Auth::user()->goal) }}</textarea>

                                        @error('goal')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary shadow">
                                                {{ __('profiles.update') }}
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
