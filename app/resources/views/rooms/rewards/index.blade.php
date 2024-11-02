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

                    <div class="accordion mt-4" id="accordionRewardCreation">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    {{ __('rewards.create') }}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionRewardCreation">
                                <div class="accordion-body">
                                    <form>
                                        @csrf

                                        <div class="row mb-3">
                                            <div class="col-3">
                                                <label for="point" class="form-label">{{ __('rewards.point') }}</label>
                                                <input id="point" type="number" class="form-control @error('point') is-invalid @enderror" name="point" value="{{ old('point') }}" required>

                                                @error('point')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="col-9">
                                                <label for="reward" class="form-label">{{ __('rewards.reward') }}</label>
                                                <input id="reward" type="text" class="form-control @error('reward') is-invalid @enderror" name="reward" value="{{ old('reward') }}" required>

                                                @error('reward')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-0">
                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary shadow" id="reward-create">
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
                        <tbody>
                            @forelse ($rewards as $reward)
                                <tr>
                                    <td>{{ $reward->point }} P</td>
                                    <td>{{ $reward->reward }}</td>
                                    <td>
                                        編集
                                    </td>
                                    <td>
                                        削除
                                    </td>
                                    <td>
                                        獲得
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5">{{ __('rewards.no_rewards') }}</td></tr>
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
                                {{ __('rewards.points_held') }}：{{ $receiveRewardsUser["earned_point"] }} P
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
                        <tbody>
                            @forelse ($earnedRewards as $earnedReward)
                                <tr>
                                    <td>{{ $earnedReward->point }} P</td>
                                    <td>{{ $earnedReward->reward }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2">{{ __('rewards.no_earned') }}</td></tr>
                            @endforelse
                        </table>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
