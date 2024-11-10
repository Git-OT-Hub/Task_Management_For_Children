<script type="module">
    // 報酬作成
    $(document).ready(function() {
        let createBtn = $("#reward-create-form #reward-create-btn");
        if (createBtn) {    
            createBtn.click(function() {
                let roomId = $(`#reward-create-form input[name='room-id']`).val();

                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                
                $.ajax({
                    type: "POST",
                    url: `/rooms/${roomId}/rewards`,
                    dataType: "json",
                    data: {
                        "_method": "POST",
                        point: $(`#reward-create-form input[name='point']`).val(),
                        reward: $(`#reward-create-form input[name='reward']`).val(),
                    },
                })
                .done(function(res) {
                    $('#reward-create-form ul.reward-create-error-message').empty();
                    $('#ajax-flash-message').empty();
                    $(`#reward-create-form input[name='point']`).val('');
                    $(`#reward-create-form input[name='reward']`).val('');
                    var noReward = $('#creation-rewards-list tr.no_rewards');
                    if (noReward) {
                        noReward.remove();
                    }
                    
                    var resRewardId = res.reward.id;
                    var resRewardPoint = res.reward.point;
                    var resRewardReward = res.reward.reward;
                    var resRoomId = res.room.id;
                    var newReward = `
                        <tr id="reward-${resRewardId}">
                            <td class="point align-middle">${resRewardPoint} P</td>
                            <td class="reward align-middle">${resRewardReward}</td>
                            <td class="text-end">
                                <div class="dropdown">
                                    <button type="button" class="btn btn-secondary shadow dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                                        編集
                                    </button>
                                    <form class="dropdown-menu p-3 dropdown-menu-end shadow reward-update" id="reward-update-${resRewardId}">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="point" class="form-label mb-0">ポイント</label>
                                                <input id="point" type="number" class="form-control" name="point" value="${resRewardPoint}" required>
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="reward" class="form-label mb-0">報酬</label>
                                                <input id="reward" type="text" class="form-control" name="reward" value="${resRewardReward}" required>
                                            </div>
                                        </div>
                                        <ul class="fw-bold text-danger reward-update-error-message">
                                        </ul>
                                        <input type="hidden" name="room-id" value="${resRoomId}">
                                        <div class="row mb-0">
                                            <div class="col-12 text-end">
                                                <button type="button" class="btn btn-primary shadow reward-update" value="${resRewardId}">更新</button> 
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </td>
                            <td class="text-end">
                                <form class="reward-delete" id="reward-delete-${resRewardId}">
                                    <input type="hidden" name="room-id" value="${resRoomId}">
                                    <button type="button" class="btn btn-danger shadow reward-delete" value="${resRewardId}">削除</button> 
                                </form>   
                            </td>
                            <td class="text-end">
                            </td>
                        </tr>
                    `;
                    $('#creation-rewards-list').prepend(newReward);

                    var dom = '<div class="p-1"><div class="alert alert-info mb-0" role="alert">報酬を作成しました。</div></div>'
                    $('#ajax-flash-message').append(dom);
                    
                    setTimeout(function() {
                        $('#ajax-flash-message').empty();
                    }, 3000);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseJSON["message"]) {
                        alert(jqXHR.responseJSON["message"]);
                        return;
                    }

                    console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                    alert("報酬の作成に失敗しました。");

                    $('#reward-create-form ul.reward-create-error-message').empty();
                    var text = $.parseJSON(jqXHR.responseText);
                    var errors = text.errors;
                    for (var key in errors) {
                        var errorMessage = errors[key][0];
                        $('#reward-create-form ul.reward-create-error-message').append(`<li>${errorMessage}</li>`);
                    }
                });
            });
        }
    });
    // 報酬編集
    $(document).ready(function() {
        $("#creation-rewards-list").on("click", "form.reward-update button.reward-update", function() {
            let rewardId = $(this).val();
            let roomId = $(`#reward-update-${rewardId} input[name='room-id']`).val();

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            
            $.ajax({
                type: "POST",
                url: `/rooms/${roomId}/rewards/${rewardId}`,
                dataType: "json",
                data: {
                    "_method": "PATCH",
                    point: $(`#reward-update-${rewardId} input[name='point']`).val(),
                    reward: $(`#reward-update-${rewardId} input[name='reward']`).val(),
                },
            })
            .done(function(res) {
                $(`#reward-update-${rewardId} ul.reward-update-error-message`).empty();
                $('#ajax-flash-message').empty();
                $(`#reward-${rewardId} td.point`).text(`${res.point} P`);
                $(`#reward-${rewardId} td.reward`).text(res.reward);
                var dom = '<div class="p-1"><div class="alert alert-info mb-0" role="alert">報酬を更新しました。</div></div>'
                $('#ajax-flash-message').append(dom);
                
                setTimeout(function() {
                    $('#ajax-flash-message').empty();
                }, 3000);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.responseJSON["message"]) {
                    alert(jqXHR.responseJSON["message"]);
                    return;
                }
                
                console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                alert("報酬の更新に失敗しました。");

                $(`#reward-update-${rewardId} ul.reward-update-error-message`).empty();
                var text = $.parseJSON(jqXHR.responseText);
                var errors = text.errors;
                for (var key in errors) {
                    var errorMessage = errors[key][0];
                    $(`#reward-update-${rewardId} ul.reward-update-error-message`).append(`<li>${errorMessage}</li>`);
                }
            });
        });
    });
    // 報酬削除
    $(document).ready(function() {
        $("#creation-rewards-list").on("click", "form.reward-delete button.reward-delete", function() {
            let rewardId = $(this).val();
            let roomId = $(`#reward-delete-${rewardId} input[name='room-id']`).val();
            let point = $(`#reward-${rewardId} td.point`).text();
            let reward = $(`#reward-${rewardId} td.reward`).text();

            if (!confirm(`報酬「 ${point} / ${reward} 」を削除しますか?`)) {
                return;
            }

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            
            $.ajax({
                type: "POST",
                url: `/rooms/${roomId}/rewards/${rewardId}`,
                dataType: "json",
                data: {
                    "_method": "DELETE",
                },
            })
            .done(function(res) {
                $('#ajax-flash-message').empty();
                $(`#reward-${res.id}`).remove();
                
                var dom = '<div class="p-1"><div class="alert alert-info mb-0" role="alert">報酬を削除しました。</div></div>'
                $('#ajax-flash-message').append(dom);
                
                setTimeout(function() {
                    $('#ajax-flash-message').empty();
                }, 3000);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.responseJSON["message"]) {
                    alert(jqXHR.responseJSON["message"]);
                    return;
                }
                
                console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                alert("報酬の削除に失敗しました。");
            });
        });
    });
    // 報酬獲得
    $(document).ready(function() {
        $("#creation-rewards-list").on("click", "form.earn-reward button.earn-reward", function() {
            let rewardId = $(this).val();
            let roomId = $(`#earn-reward-${rewardId} input[name='room-id']`).val();
            let point = $(`#earn-reward-${rewardId} input[name='point']`).val();
            let reward = $(`#earn-reward-${rewardId} input[name='reward']`).val();

            if (!confirm(`「${point} P」を消費して、報酬「 ${reward} 」を獲得しますか?`)) {
                return;
            }

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            
            $.ajax({
                type: "POST",
                url: `/rooms/${roomId}/rewards/${rewardId}/earn`,
                dataType: "json",
                data: {
                    "_method": "POST",
                    point: point,
                    reward: reward,
                },
            })
            .done(function(res) {
                $('#ajax-flash-message').empty();
                var noEarned = $('#earned-rewards tr.no_earned');
                if (noEarned) {
                    noEarned.remove();
                }

                $(`#reward-${res.reward.id}`).remove();
                var earnedReward = `<tr><td>${res.reward.point} P</td><td>${res.reward.reward}</td></tr>`;
                $('#earned-rewards').prepend(earnedReward);
                $('#current-points-held').text(res.earnedPoint.point);
                
                var dom = '<div class="p-1"><div class="alert alert-info mb-0" role="alert">報酬を獲得しました。</div></div>'
                $('#ajax-flash-message').append(dom);
                
                setTimeout(function() {
                    $('#ajax-flash-message').empty();
                }, 3000);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                if (jqXHR.responseJSON["message"]) {
                    alert(jqXHR.responseJSON["message"]);
                    return;
                }
                
                console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                alert("報酬の獲得に失敗しました。");
            });
        });
    });
</script>
