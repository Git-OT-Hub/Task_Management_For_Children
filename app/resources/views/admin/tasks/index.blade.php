@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card shadow">
                <div class="card-header text-center fs-5 custom-main-color">{{ __('admin.tasks_management') }}</div>

                <div class="card-body border-bottom border-3">
                    <div class="mb-4">
                        <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ url('admin/home') }}">
                            <i class="fa-solid fa-reply fa-xl"></i>
                            <span class="fs-5">{{ __('admin.home') }}</span>
                        </a>
                    </div>
                    <form class="admin-tasks-search-form">
                        <div class="row mb-3">
                            <div class="col-6">
                                <input type="search" class="form-control" placeholder="{{ __('admin.task_title') }}" name="title" value="">
                            </div>
                            <div class="col-6">
                                <div class="row align-items-center">
                                    <div class="col-5 pe-0">
                                        <input type="number" class="form-control" name="point_from" value="" placeholder="{{ __('admin.task_point') }}">
                                    </div>
                                    <div class="col-2 text-center px-0">
                                        <span class="">~</span>
                                    </div>
                                    <div class="col-5 ps-0">
                                        <input type="number" class="form-control" name="point_until" value="" placeholder="{{ __('admin.task_point') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3 align-items-center">
                            <div class="col-5 pe-0">
                                <input type="datetime-local" class="form-control" name="deadline_from" value="">
                            </div>
                            <div class="col-2 text-center px-0">
                                <span class="">~</span>
                            </div>
                            <div class="col-5 ps-0">
                                <input type="datetime-local" class="form-control" name="deadline_until" value="">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <select class="form-select" name="status">
                                    <option value="">{{ __('admin.task_select_status') }}</option>
                                    <option value="none">{{ __('admin.no_completion_no_accomplished') }}</option>
                                    <option value="reported">{{ __('admin.completion_report_in_progress') }}</option>
                                    <option value="completed">{{ __('admin.accomplished') }}</option>
                                </select>
                            </div>
                            <div class="col-6">
                                <input type="number" class="form-control" name="room_id" value="" placeholder="{{ __('admin.room_id') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                            </div>
                            <div class="col-2 text-end">
                                <button type="button" class="btn btn-primary shadow" id="tasks-search-btn"><i class="fa-solid fa-magnifying-glass fa-xl"></i></button>
                            </div>
                            <div class="col-3 text-end">
                                <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary shadow">{{ __('admin.reset') }}</a>
                            </div>
                        </div>
                    </form>
                    @include("admin.tasks.tasks_script")
                </div>

                <div class="card-body" id="admin-tasks-list">
                    @include("admin.tasks.tasks_list")
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
