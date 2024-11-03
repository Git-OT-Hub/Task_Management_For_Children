<script type="module">
    // 報酬編集
    $(document).ready(function() {
        let updateBtns = $("form.reward-update button.reward-update");
        if (updateBtns) {
            updateBtns.each(function() {
                $(this).click(function() {
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
                        var dom = '<div class="p-3"><div class="alert alert-info mb-0" role="alert">報酬を更新しました。</div></div>'
                        $('#ajax-flash-message').append(dom);
                        
                        setTimeout(function() {
                            $('#ajax-flash-message').empty();
                        }, 3000);
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.responseJSON["message"]) {
                            alert(jqXHR.responseJSON["message"]);
                            exit;
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
        }
    });
    // 報酬削除
    $(document).ready(function() {
        let deleteBtns = $("form.reward-delete button.reward-delete");
        if (deleteBtns) {
            deleteBtns.each(function() {
                $(this).click(function() {
                    if (!confirm("この報酬を削除しますか?")) {
                        return;
                    }

                    let rewardId = $(this).val();
                    let roomId = $(`#reward-delete-${rewardId} input[name='room-id']`).val();

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
                        
                        var dom = '<div class="p-3"><div class="alert alert-info mb-0" role="alert">報酬を削除しました。</div></div>'
                        $('#ajax-flash-message').append(dom);
                        
                        setTimeout(function() {
                            $('#ajax-flash-message').empty();
                        }, 3000);
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.responseJSON["message"]) {
                            alert(jqXHR.responseJSON["message"]);
                            exit;
                        }
                        
                        console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                        alert("報酬の削除に失敗しました。");
                    });
                });
            });
        }
    });
</script>
