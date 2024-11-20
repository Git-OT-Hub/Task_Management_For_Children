<script type="module">
    // search
    $(document).ready(function() {
        let searchBtn = $("#rooms-search-btn");
        if (searchBtn) {    
            searchBtn.on("click", function() {
                let roomName = $("form.admin-rooms-search-form input[name='room_name']").val();
                let master = $("form.admin-rooms-search-form input[name='master']").val(); 
                let implementer = $("form.admin-rooms-search-form input[name='implementer']").val();

                if (!(roomName || master || implementer)) {
                    alert("検索ワードが全て未入力です。");
                    return;
                }

                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });
                
                $.ajax({
                    type: "GET",
                    url: "/admin/rooms/search/" + roomName + master + implementer,
                    dataType: "html",
                    data: {
                        room_name: roomName,
                        master: master,
                        implementer: implementer,
                    },
                })
                .done(function(res) {
                    $('#admin-rooms-list').empty();
                    $('#admin-rooms-list').html(res);
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
            adminRoomsPaginate(url);
        });

        function adminRoomsPaginate(url)
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
                $('#admin-rooms-list').empty();
                $('#admin-rooms-list').html(res);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                alert("ページ切り替えに失敗しました。");
            });
        }
    });

    // delete
    $(document).ready(function() {
        $("#admin-rooms-list").on("click", "form.room-delete-form button", function() {
            let roomId = $(this).val();
            let roomName = $(`#admin-rooms-list #room-${roomId} td.room-name`).text();

            if (!confirm(`ルーム「 ID：${roomId} / ${roomName} 」を削除しますか?`)) {
                return;
            }

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            
            $.ajax({
                type: "POST",
                url: `/admin/rooms/${roomId}`,
                dataType: "json",
                data: {
                    "_method": "DELETE",
                },
            })
            .done(function(res) {
                $('#ajax-flash-message').empty();
                $(`#admin-rooms-list #room-${res.id}`).remove();
                
                let dom = '<div class="p-1"><div class="alert alert-info mb-0" role="alert">ルームを削除しました。</div></div>'
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
                alert("ルームの削除に失敗しました。");
            });
        });
    });
</script>
