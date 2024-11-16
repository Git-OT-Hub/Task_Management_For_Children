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
                            <form class="rooms-search-form">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <input type="search" class="form-control" placeholder="{{ __('rooms.name') }}" id="" name="room_name" value="">
                                    </div>
                                    <div class="col-6">
                                        <input type="search" class="form-control" placeholder="{{ __('rooms.user_name') }}" id="" name="user_name" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <select class="form-select" id="" name="participation_status">
                                            <option value="">{{ __('rooms.select_participation_status') }}</option>
                                            <option value="false">{{ __('rooms.not_participating') }}</option>
                                            <option value="1">{{ __('rooms.participating') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <button type="button" class="btn btn-primary shadow" id="rooms-search-btn"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
                                    </div>
                                    <div class="col-3 text-end">
                                        <a href="{{ route('rooms.index') }}" class="btn btn-secondary shadow">{{ __('rooms.reset') }}</a>
                                    </div>
                                </div>
                            </form>
                            @include("rooms.search_script")
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
            <div class="row mt-4" id="rooms-list">
                @include("rooms.room_list")
            </div>
        </div>
    </div>
</div>
@endsection
