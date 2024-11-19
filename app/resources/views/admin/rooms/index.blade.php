@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card shadow">
                <div class="card-header text-center fs-5 custom-main-color">{{ __('admin.rooms_management') }}</div>

                <div class="card-body border-bottom border-3">
                    <div class="mb-4">
                        <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ url('admin/home') }}">
                            <i class="fa-solid fa-reply fa-xl"></i>
                            <span class="fs-5">{{ __('admin.home') }}</span>
                        </a>
                    </div>
                    <form class="admin-rooms-search-form">
                        <div class="row mb-3">
                            <div class="col-6">
                                <input type="search" class="form-control" placeholder="{{ __('admin.room_name') }}" name="room_name" value="">
                            </div>
                            <div class="col-6">
                                <input type="search" class="form-control" placeholder="{{ __('admin.master') }}" name="master" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <input type="search" class="form-control" placeholder="{{ __('admin.implementer') }}" name="implementer" value="">
                            </div>
                            <div class="col-2 text-end">
                                <button type="button" class="btn btn-primary shadow" id="rooms-search-btn"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
                            </div>
                            <div class="col-3 text-end">
                                <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary shadow">{{ __('admin.reset') }}</a>
                            </div>
                        </div>
                    </form>
                    @include("admin.rooms.rooms_script")
                </div>

                <div class="card-body" id="admin-rooms-list">
                    @include("admin.rooms.rooms_list")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
