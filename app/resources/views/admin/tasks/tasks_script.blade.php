<script type="module">
    // search
    $(document).ready(function() {
        let searchBtn = $("form.admin-tasks-search-form #tasks-search-btn");
        if (searchBtn) {    
            searchBtn.on("click", function() {
                let title = $("form.admin-tasks-search-form input[name='title']").val();
                let pointFrom = $("form.admin-tasks-search-form input[name='point_from']").val();
                let pointUntil = $("form.admin-tasks-search-form input[name='point_until']").val();
                let deadlineFrom = $("form.admin-tasks-search-form input[name='deadline_from']").val();
                let deadlineUntil = $("form.admin-tasks-search-form input[name='deadline_until']").val();
                let status = $("form.admin-tasks-search-form select[name='status']").val();
                let roomId = $("form.admin-tasks-search-form input[name='room_id']").val();

                if (!(title || status || deadlineFrom || deadlineUntil || pointFrom || pointUntil || roomId)) {
                    alert("検索ワードが全て未入力です。");
                    return;
                }

                if (deadlineFrom && deadlineUntil) {
                    if (deadlineFrom > deadlineUntil) {
                        alert("「期限」の範囲を正しく選択してください。");
                        return;
                    }
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
                    url: "/admin/tasks/search/" + title + pointFrom + pointUntil + deadlineFrom + deadlineUntil + status + roomId,
                    dataType: "html",
                    data: {
                        title: title,
                        point_from: pointFrom,
                        point_until: pointUntil,
                        deadline_from: deadlineFrom,
                        deadline_until: deadlineUntil,
                        status: status,
                        room_id: roomId,
                    },
                })
                .done(function(res) {
                    $('#admin-tasks-list').empty();
                    $('#admin-tasks-list').html(res);
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
            adminTasksPaginate(url);
        });

        function adminTasksPaginate(url)
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
                $('#admin-tasks-list').empty();
                $('#admin-tasks-list').html(res);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                alert("ページ切り替えに失敗しました。");
            });
        }
    });

    // delete
    $(document).ready(function() {
        $("#admin-tasks-list").on("click", "form.task-delete-form button", function() {
            let taskId = $(this).val();
            let roomId = $(`#admin-tasks-list #task-${taskId} td.task-room-id`).text();
            let title = $(`#admin-tasks-list #task-${taskId} td.task-title`).text();

            if (!confirm(`課題「 ルームID：${roomId} / 課題ID：${taskId} / ${title} 」を削除しますか?`)) {
                return;
            }

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            
            $.ajax({
                type: "POST",
                url: `/admin/tasks/${taskId}`,
                dataType: "json",
                data: {
                    "_method": "DELETE",
                },
            })
            .done(function(res) {
                $('#ajax-flash-message').empty();
                $(`#task-${res.id}`).remove();
                
                let dom = '<div class="p-1"><div class="alert alert-info mb-0" role="alert">課題を削除しました。</div></div>'
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
                alert("課題の削除に失敗しました。");
            });
        });
    });
</script>
