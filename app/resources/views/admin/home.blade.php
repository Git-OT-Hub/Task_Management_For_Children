@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header text-center fs-5 custom-main-color">{{ __('admin.home') }}</div>

                <div class="card-body border-bottom border-3">
                    <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('admin.users.index') }}">
                        <i class="fa-solid fa-user-group fa-2xl"></i>
                        <span class="fs-4">{{ __('admin.users_management') }}</span>
                    </a>
                </div>
                <div class="card-body border-bottom border-3">
                    <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('admin.rooms.index') }}">
                        <i class="fa-solid fa-person-shelter fa-2xl"></i>
                        <span class="fs-4">{{ __('admin.rooms_management') }}</span>
                    </a>
                </div>
                <div class="card-body border-bottom border-3">
                    <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="#">
                        <i class="fa-solid fa-cubes-stacked fa-2xl"></i>
                        <span class="fs-4">{{ __('admin.tasks_management') }}</span>
                    </a>
                </div>
                <div class="card-body">
                    <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="#">
                        <i class="fa-solid fa-money-check-dollar fa-2xl"></i>
                        <span class="fs-4">{{ __('admin.rewards_management') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
