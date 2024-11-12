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
                    let result = "";
                    $.each(res, function(index, val) {
                        let roomId = val.room_id;
                        let roomName = val.room_name;
                        let master = val.room_master;
                        let masterIcon = val.room_master_icon;
                        let participant = val.participant;
                        let participantIcon = val.participant_icon;
                        let joinStatus = val.join_status;
                        let createdAt = val.created_at;

                        result = `
                        
                        `;

                        //console.log(`${roomId}/${roomName}/${master}/${masterIcon}/${participant}/${participantIcon}/${joinStatus}/${createdAt}`);
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
