@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header text-center custom-main-color">{{ __('Room List') }}</div>

                        <div class="card-body">
                            検索機能
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-start mt-3">
                <div class="col">
                    <a class="btn btn-primary shadow" href="{{ route('rooms.create') }}">
                        {{ __('Create a Room') }}
                    </a>
                </div>
            </div>
            <div class="row">
                {{ print_r($results) }}
                @forelse ($results as $result)
                    @if ($result["join_status"] == 0)
                        <div class="col-12 col-lg-6 mt-3">
                            <div class="p-3 rounded shadow">
                                <div class="card">
                                    <div class="card-header text-center custom-main-color">{{ __('Room Master') }}</div>

                                    <div class="card-body">
                                        <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                            <img src="{{ asset('images/test_header_icon.png') }}" alt="" class="img-thumbnail rounded-circle">
                                        </div>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($result["join_status"] == 1)
                        <div class="col-12 col-lg-6 mt-3">
                            <div class="p-3 rounded shadow">
                                <div class="card">
                                    <div class="card-header text-center custom-main-color">{{ __('Room List') }}</div>

                                    <div class="card-body">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @empty
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection