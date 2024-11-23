@extends('layouts.layout')

@section('title', 'プロフィール')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header text-center fs-5 custom-main-color">{{ __('profiles.profile') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-4 align-self-center text-center">
                            <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('rooms.index') }}">
                                <i class="fa-solid fa-reply"></i>
                                {{ __('rooms.list') }}
                            </a>
                        </div>
                        <div class="col-4 ms-auto text-center">
                            <a class="btn btn-secondary shadow" href="{{ route('profiles.edit') }}">
                                {{ __('profiles.edit') }}
                            </a>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <div class="ratio ratio-1x1 w-25 custom-user-icon">
                                @if(Auth::user()->icon)
                                    <img src="{{ Storage::url(Auth::user()->icon) }}" alt="" class="img-thumbnail rounded-circle shadow">
                                @else
                                    <img src="{{ asset('images/no_image.png') }}" alt="" class="img-thumbnail rounded-circle shadow">
                                @endif
                            </div>
                            @if(Auth::user()->icon)
                                <form method="POST" action="{{ route('profiles.icon.destroy') }}" id="icon-delete" class="custom-icon-button align-bottom ms-2">
                                    @method("DELETE")
                                    @csrf
                                    <button type="submit" class="btn btn-danger shadow">{{ __('profiles.delete') }}</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-4 fs-5">
                        <div class="col-12">
                            <p>{{ __('profiles.name') }}：{{ Auth::user()->name }}</p>
                        </div>
                        <div class="col-12">
                            <p>{{ __('profiles.email') }}：{{ Auth::user()->email }}</p>
                        </div>
                        <div class="col-12">
                            {{ __('profiles.goal') }}：
                            <p class="border border-2 p-2">{!! nl2br(e(Auth::user()->goal)) !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
