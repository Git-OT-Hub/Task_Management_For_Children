<script type="module">
    $(document).ready(function() {
        let searchBtn = $("#rooms-search-btn");
        if (searchBtn) {    
            searchBtn.on("click", function() {
                let roomName = $("form.rooms-search-form input[name='room_name']").val();
                let userName = $("form.rooms-search-form input[name='user_name']").val();
                let participationStatus = $("form.rooms-search-form select[name='participation_status']").val();

                if (!(roomName || userName || participationStatus)) {
                    alert("検索ワードが全て未入力です。");
                    return;
                }

                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                
                $.ajax({
                    type: "GET",
                    url: "/rooms/search/" + roomName + userName + participationStatus,
                    dataType: "json",
                    data: {
                        room_name: roomName,
                        user_name: userName,
                        participation_status: participationStatus,
                    },
                })
                .done(function(res) {
                    $('#rooms-list').empty();
                    $('#rooms-pagination').remove();

                    if (res.length == 0) {
                        let noContent = `
                            <div class="col-12 mt-3">
                                <p class="mb-0 fs-4">該当する部屋が見つかりませんでした。</p>
                            </div>
                        `;
                        $('#rooms-list').append(noContent);
                        return;
                    }

                    let result = "";
                    let csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.each(res, function(index, val) {
                        let roomId = val.room_id;
                        let roomName = val.room_name;
                        let master = val.room_master;
                        let masterIcon = val.room_master_icon;
                        let participant = val.participant;
                        let participantIcon = val.participant_icon;
                        let joinStatus = val.join_status;
                        let createdAt = val.created_at;

                        if (joinStatus == 0) {
                            let masterIconHtml = masterIcon ? `<img src="/storage/${masterIcon}" alt="" class="img-thumbnail rounded-circle">` : `<img src="http://localhost/images/no_image.png" alt="" class="img-thumbnail rounded-circle">`;
                            result = `
                                <div class="col-12 col-lg-6 mt-3">
                                    <div class="p-3 rounded shadow h-100">
                                        <h2>
                                            ${roomName}
                                        </h2>
                                        <div class="card">
                                            <div class="card-header text-center custom-main-color">ルームマスター</div>

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="ratio ratio-1x1 custom-user-icon" style="width: 60px; height: 60px;">
                                                            ${masterIconHtml}
                                                        </div>
                                                    </div>
                                                    <div class="col-9 align-self-center">
                                                        <p class="mb-0 fs-4">${master}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <p class="mb-0 fs-4 text-danger">招待されています。</p>
                                        </div>
                                        <div class="mt-3 text-center">
                                            <form method="post" action="http://localhost/rooms/${roomId}/join" id="room-join-form-${roomId}">
                                                <input type="hidden" name="_token" value="${csrfToken}" autocomplete="off">
                                                <input type="hidden" name="room_name" value="${roomName}">
                                                <button type="submit" class="btn btn-primary shadow">
                                                    参加する
                                                </button>
                                            </form>
                                        </div>
                                        <p class="mb-0 mt-3">
                                            作成日：
                                            <time>
                                                ${createdAt}
                                            </time>
                                        </p>
                                    </div>
                                </div>
                            `;
                        } else if (joinStatus == 1) {
                            result = `
                        
                            `;
                        }

                        $('#rooms-list').append(result);

                        // console.log(`${roomId}/${roomName}/${master}/${masterIcon}/${participant}/${participantIcon}/${joinStatus}/${createdAt}`);
                    });
                    return;
                    // $('#reward-create-form ul.reward-create-error-message').empty();
                    // $('#ajax-flash-message').empty();
                    // $(`#reward-create-form input[name='point']`).val('');
                    // $(`#reward-create-form input[name='reward']`).val('');
                    // var noReward = $('#creation-rewards-list tr.no_rewards');
                    // if (noReward) {
                    //     noReward.remove();
                    // }
                    
                    // var resRewardId = res.reward.id;
                    // var resRewardPoint = res.reward.point;
                    // var resRewardReward = res.reward.reward;
                    // var resRoomId = res.room.id;
                    // var newReward = `
                        
                    // `;
                    // $('#creation-rewards-list').prepend(newReward);

                    // var dom = '<div class="p-1"><div class="alert alert-info mb-0" role="alert">報酬を作成しました。</div></div>'
                    // $('#ajax-flash-message').append(dom);
                    
                    // setTimeout(function() {
                    //     $('#ajax-flash-message').empty();
                    // }, 3000);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    // if (jqXHR.responseJSON["message"]) {
                    //     alert(jqXHR.responseJSON["message"]);
                    //     return;
                    // }

                    // console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                    // alert("報酬の作成に失敗しました。");

                    // $('#reward-create-form ul.reward-create-error-message').empty();
                    // var text = $.parseJSON(jqXHR.responseText);
                    // var errors = text.errors;
                    // for (var key in errors) {
                    //     var errorMessage = errors[key][0];
                    //     $('#reward-create-form ul.reward-create-error-message').append(`<li>${errorMessage}</li>`);
                    // }
                });
            });
        }
    });
</script>
