<script type="module">
    $(document).ready(function() {
        let roomEditId = $("#room-edit-id").val();
        if (roomEditId) {
            $("#room-edit").click(function() {
                $.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                });

                $.ajax({
                    type: "POST",
                    url: `/rooms/${roomEditId}`,
                    dataType: "json",
                    data: {
                        "_method": "PATCH",
                        room_name: $("input[name='room_name']").val(),
                        user_name: $("input[name='user_name']").val(),
                    },
                })
                .done(function(res) {
                    console.log(res);
                    $("#room-name").text(res.name);
                    $('#room-error-message').empty();
                    $('#ajax-flash-message').empty();
                    var dom = '<div class="p-3"><div class="alert alert-info mb-0" role="alert">ルームを編集しました。</div></div>'
                    $('#ajax-flash-message').append(dom);

                    setTimeout(function() {
                        $('#ajax-flash-message').empty();
                    }, 3000);
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Ajax通信に失敗しました。：' + textStatus + ':\n' + errorThrown);
                    alert("ルーム名の変更に失敗しました。");

                    $('#room-error-message').empty();
                    var text = $.parseJSON(jqXHR.responseText);
                    var errors = text.errors;
                    for (var key in errors) {
                        var errorMessage = errors[key][0];
                        $('#room-error-message').append(`<li>${errorMessage}</li>`);
                    }
                });
            });
        }
    });
</script>
