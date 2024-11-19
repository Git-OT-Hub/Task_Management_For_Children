<script type="module">
    // search
    $(document).ready(function() {
        let searchBtn = $("#tasks-search-btn");
        if (searchBtn) {    
            searchBtn.on("click", function() {
                let title = $("form.tasks-search-form input[name='title']").val();
                let status = $("form.tasks-search-form select[name='status']").val();
                let deadlineFrom = $("form.tasks-search-form input[name='deadline_from']").val();
                let deadlineUntil = $("form.tasks-search-form input[name='deadline_until']").val();
                let pointFrom = $("form.tasks-search-form input[name='point_from']").val();
                let pointUntil = $("form.tasks-search-form input[name='point_until']").val();
                let roomId = $("form.tasks-search-form input[name='room_id']").val();

                if (!(title || status || deadlineFrom || deadlineUntil || pointFrom || pointUntil)) {
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

                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                
                $.ajax({
                    type: "GET",
                    url: "/rooms/tasks/search/" + title + status + deadlineFrom + deadlineUntil + pointFrom + pointUntil,
                    dataType: "html",
                    data: {
                        title: title,
                        status: status,
                        deadline_from: deadlineFrom,
                        deadline_until: deadlineUntil,
                        point_from: pointFrom,
                        point_until: pointUntil,
                        room_id: roomId,
                    },
                })
                .done(function(res) {
                    $('#tasks-list').empty();
                    $('#tasks-list').html(res);
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
            tasksPaginate(url);
        });

        function tasksPaginate(url)
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
                $('#tasks-list').empty();
                $('#tasks-list').html(res);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                alert("画面切り替えに失敗しました。");
            });
        }
    });
</script>
