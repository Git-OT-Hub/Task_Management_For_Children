<script type="module">
    // search
    $(document).ready(function() {
        let searchBtn = $("form.admin-rewards-search-form #rewards-search-btn");
        if (searchBtn) {    
            searchBtn.on("click", function() {
                let reward = $("form.admin-rewards-search-form input[name='reward']").val();
                let pointFrom = $("form.admin-rewards-search-form input[name='point_from']").val();
                let pointUntil = $("form.admin-rewards-search-form input[name='point_until']").val();        
                let status = $("form.admin-rewards-search-form select[name='status']").val();
                let roomId = $("form.admin-rewards-search-form input[name='room_id']").val();

                if (!(reward || status || pointFrom || pointUntil || roomId)) {
                    alert("検索ワードが全て未入力です。");
                    return;
                }
                
                if (pointFrom && pointUntil) {
                    if (pointFrom > pointUntil) {
                        alert("「ポイント」の範囲を正しく入力してください。");
                        return;
                    }
                }

                if (pointFrom < 0 || pointUntil < 0) {
                    alert("「ポイント」は 0 以上で入力してください。");
                    return;
                }

                if (roomId) {
                    if (roomId < 1) {
                        alert("「ルームID」は 1 以上で入力してください。");
                        return;
                    }
                }

                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                
                $.ajax({
                    type: "GET",
                    url: "/admin/rewards/search/" + reward + pointFrom + pointUntil + status + roomId,
                    dataType: "html",
                    data: {
                        reward: reward,
                        point_from: pointFrom,
                        point_until: pointUntil,
                        status: status,
                        room_id: roomId,
                    },
                })
                .done(function(res) {
                    $('#admin-rewards-list').empty();
                    $('#admin-rewards-list').html(res);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                    alert("検索に失敗しました。");
                });
            });
        }
    });

    // pagination
    $(document).ready(function() {
        $(document).on("click", ".pagination a", function(e) {
            e.preventDefault();
            
            let url = $(this).attr("href");
            adminRewardsPaginate(url);
        });

        function adminRewardsPaginate(url)
        {
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $.ajax({
                type: "GET",
                url: url,
                dataType: "html",
            })
            .done(function(res) {
                $('#admin-rewards-list').empty();
                $('#admin-rewards-list').html(res);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                alert("ページ切り替えに失敗しました。");
            });
        }
    });

    // delete
    $(document).ready(function() {
        $("#admin-rewards-list").on("click", "form.reward-delete-form button", function() {
            let rewardId = $(this).val();
            let roomId = $(`#admin-rewards-list #reward-${rewardId} td.reward-room-id`).text();
            let reward = $(`#admin-rewards-list #reward-${rewardId} td.reward`).text();

            if (!confirm(`報酬「 ルームID：${roomId} / 報酬ID：${rewardId} / ${reward} 」を削除しますか?`)) {
                return;
            }

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            
            $.ajax({
                type: "POST",
                url: `/admin/rewards/${rewardId}`,
                dataType: "json",
                data: {
                    "_method": "DELETE",
                },
            })
            .done(function(res) {
                $('#ajax-flash-message').empty();
                $(`#admin-rewards-list #reward-${res.id}`).remove();
                
                let dom = '<div class="p-1"><div class="alert alert-info mb-0" role="alert">報酬を削除しました。</div></div>'
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
</script>
