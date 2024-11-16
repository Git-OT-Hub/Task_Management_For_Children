<script type="module">
    // search
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
                    dataType: "html",
                    data: {
                        room_name: roomName,
                        user_name: userName,
                        participation_status: participationStatus,
                    },
                })
                .done(function(res) {
                    $('#rooms-list').empty();
                    $('#rooms-list').html(res);
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
            roomsPaginate(url);
        });

        function roomsPaginate(url)
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
                $('#rooms-list').empty();
                $('#rooms-list').html(res);
            })
            .fail(function(jqXHR, textStatus, errorThrown) {
                console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                alert("画面切り替えに失敗しました。");
            });
        }
    });
</script>
