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

                if (roomId < 1) {
                    alert("「ルームID」は 1 以上で入力してください。");
                    return;
                }

                return;//ここからスタート

                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                
                $.ajax({
                    type: "GET",
                    url: "/admin/users/search/" + name + email,
                    dataType: "html",
                    data: {
                        name: name,
                        email: email,
                    },
                })
                .done(function(res) {
                    $('#admin-users-list').empty();
                    $('#admin-users-list').html(res);
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
            adminUsersPaginate(url);
        });

        function adminUsersPaginate(url)
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
                $('#admin-users-list').empty();
                $('#admin-users-list').html(res);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                alert("ページ切り替えに失敗しました。");
            });
        }
    });

    // delete
    $(document).ready(function() {
        $("#admin-users-list").on("click", "form.user-delete-form button", function() {
            let userId = $(this).val();
            let name = $(`#admin-users-list #user-${userId} td.user-name`).text();
            let email = $(`#admin-users-list #user-${userId} td.user-email`).text();

            if (!confirm(`ユーザー「 ${name} / ${email} 」を削除しますか?`)) {
                return;
            }

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            
            $.ajax({
                type: "POST",
                url: `/admin/users/${userId}`,
                dataType: "json",
                data: {
                    "_method": "DELETE",
                },
            })
            .done(function(res) {
                $('#ajax-flash-message').empty();
                $(`#user-${res.id}`).remove();
                
                let dom = '<div class="p-1"><div class="alert alert-info mb-0" role="alert">ユーザーを削除しました。</div></div>'
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
                alert("ユーザーの削除に失敗しました。");
            });
        });
    });
</script>
