<tr id="reward-{{ $reward->id }}">
    <td class="point align-middle text-primary">{{ $reward->point }} P</td>
    <td class="reward align-middle">{{ $reward->reward }}</td>
    <td class="text-end">
        @if(Auth::user()->id === $room->user_id)
            <div class="dropdown">
                <button type="button" class="btn btn-secondary shadow dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                    <i class="fa-solid fa-pen-to-square fa-xl"></i>
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
                            <button type="button" class="btn btn-primary shadow reward-update" value="{{ $reward->id }}">
                                <i class="fa-solid fa-pen-to-square fa-xl"></i>
                            </button>
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
                <button type="button" class="btn btn-danger shadow reward-delete" value="{{ $reward->id }}">
                    <i class="fa-solid fa-trash-can fa-xl"></i>
                </button>
            </form>
        @endif
    </td>
    <td class="text-end">
        @if(Auth::user()->id === $recipientUser->id)
            <form class="earn-reward" id="earn-reward-{{ $reward->id }}">
                @csrf
                <input type="hidden" name="room-id" value="{{ $room->id }}">
                <input type="hidden" name="point" value="{{ $reward->point }}">
                <input type="hidden" name="reward" value="{{ $reward->reward }}">
                <button type="button" class="btn btn-success shadow earn-reward" value="{{ $reward->id }}">
                    <i class="fa-solid fa-hand-holding-dollar fa-xl"></i>
                </button> 
            </form>
        @endif
    </td>
</tr>
