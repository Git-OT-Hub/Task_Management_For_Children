@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header text-center fs-5 custom-main-color">{{ __('rewards.list') }}</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 align-self-center text-start">
                            <a class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="{{ route('rooms.show', $room) }}">
                                <i class="fa-solid fa-reply"></i>
                                {{ __('rooms.show') }}
                            </a>
                        </div>
                    </div>
                    @if(Auth::user()->id === $room->user_id)
                        <div class="accordion mt-4" id="accordionRewardCreation">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        {{ __('rewards.create') }}
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionRewardCreation">
                                    <div class="accordion-body">
                                        <form id="reward-create-form">
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="col-3">
                                                    <label for="point" class="form-label">{{ __('rewards.point') }}</label>
                                                    <input id="point" type="number" class="form-control @error('point') is-invalid @enderror" name="point" value="{{ old('point') }}" required>
                                                </div>
                                                <div class="col-9">
                                                    <label for="reward" class="form-label">{{ __('rewards.reward') }}</label>
                                                    <input id="reward" type="text" class="form-control @error('reward') is-invalid @enderror" name="reward" value="{{ old('reward') }}" required>
                                                </div>
                                            </div>
                                            <ul class="fw-bold text-danger reward-create-error-message">
                                            </ul>
                                            <input type="hidden" name="room-id" value="{{ $room->id }}">
                                            <div class="row mb-0">
                                                <div class="col-12">
                                                    <div class="text-end">
                                                        <button type="button" class="btn btn-primary shadow" id="reward-create-btn">
                                                            {{ __('rewards.create') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <table class="table table-striped border-top border-3 mt-4">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('rewards.point') }}</th>
                                <th scope="col">{{ __('rewards.reward') }}</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="creation-rewards-list">
                            @forelse ($rewards as $reward)
                                <tr id="reward-{{ $reward->id }}">
                                    <td class="point align-middle">{{ $reward->point }} P</td>
                                    <td class="reward align-middle">{{ $reward->reward }}</td>
                                    <td class="text-end">
                                        @if(Auth::user()->id === $room->user_id)
                                            <div class="dropdown">
                                                <button type="button" class="btn btn-secondary shadow dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                                    {{ __('rewards.edit') }}
                                                </button>
                                                <form class="dropdown-menu p-3 dropdown-menu-end shadow reward-update" id="reward-update-{{ $reward->id }}">
                                                    @csrf
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <label for="point" class="form-label mb-0">{{ __('rewards.point') }}</label>
                                                            <input id="point" type="number" class="form-control @error('point') is-invalid @enderror" name="point" value="{{ old('point', $reward->point) }}" required>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <label for="reward" class="form-label mb-0">{{ __('rewards.reward') }}</label>
                                                            <input id="reward" type="text" class="form-control @error('reward') is-invalid @enderror" name="reward" value="{{ old('reward', $reward->reward) }}" required>
                                                        </div>
                                                    </div>
                                                    <ul class="fw-bold text-danger reward-update-error-message">
                                                    </ul>
                                                    <input type="hidden" name="room-id" value="{{ $room->id }}">
                                                    <div class="row mb-0">
                                                        <div class="col-12 text-end">
                                                            <button type="button" class="btn btn-primary shadow reward-update" value="{{ $reward->id }}">{{ __('rewards.update') }}</button> 
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if(Auth::user()->id === $room->user_id)
                                            <form class="reward-delete" id="reward-delete-{{ $reward->id }}">
                                                @csrf
                                                <input type="hidden" name="room-id" value="{{ $room->id }}">
                                                <button type="button" class="btn btn-danger shadow reward-delete" value="{{ $reward->id }}">{{ __('rewards.delete') }}</button> 
                                            </form>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if(Auth::user()->id === $receiveRewardsUser["user_id"])
                                            <form class="earn-reward" id="earn-reward-{{ $reward->id }}">
                                                @csrf
                                                <input type="hidden" name="room-id" value="{{ $room->id }}">
                                                <input type="hidden" name="point" value="{{ $reward->point }}">
                                                <input type="hidden" name="reward" value="{{ $reward->reward }}">
                                                <button type="button" class="btn btn-success shadow earn-reward" value="{{ $reward->id }}">{{ __('rewards.earn') }}</button> 
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr class="no_rewards"><td colspan="5">{{ __('rewards.no_rewards') }}</td></tr>
                            @endforelse
                        </table>
                    </table>
                </div>
            </div>

            <div class="card shadow mt-4">
                <div class="card-header text-center fs-5 custom-main-color">{{ __('rewards.earned') }}</div>

                <div class="card-body">
                    <div class="row border-bottom border-3">
                        <div class="col-3">
                            <div class="ratio ratio-1x1 custom-user-icon" style="width: 40px; height: 40px;">
                                <img src="{{ asset('images/test_header_icon.png') }}" alt="" class="img-thumbnail rounded-circle">
                            </div>
                        </div>
                        <div class="col-9 align-self-center">
                            <p class="mb-0 fs-5">{{ $receiveRewardsUser["user_name"] }}</p>
                        </div>
                        <div class="col-12 border-top border-3 mt-2">
                            <p class="mb-0 fs-5 py-2">
                                {{ __('rewards.points_held') }}：
                                <span id="current-points-held" class="badge text-bg-warning fs-4">{{ $receiveRewardsUser["earned_point"] }}</span> P
                            </p>
                        </div>
                    </div>

                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('rewards.consumption_points') }}</th>
                                <th scope="col">{{ __('rewards.earned') }}</th>
                            </tr>
                        </thead>
                        <tbody id="earned-rewards">
                            @forelse ($earnedRewards as $earnedReward)
                                <tr>
                                    <td>{{ $earnedReward->point }} P</td>
                                    <td>{{ $earnedReward->reward }}</td>
                                </tr>
                            @empty
                                <tr class="no_earned"><td colspan="2">{{ __('rewards.no_earned') }}</td></tr>
                            @endforelse
                        </table>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@include("rooms.rewards.index_script")
@endsection
