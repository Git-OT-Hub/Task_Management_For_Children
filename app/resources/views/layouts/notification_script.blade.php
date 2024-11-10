<script type="module">
    // 通知既読
    $(document).ready(function() {
        $("#notice-content").on("click", "form button", function() {
            let notificationId = $(this).val();

            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
            
            $.ajax({
                type: "POST",
                url: `/notifications/${notificationId}/read`,
                dataType: "json",
                data: {
                    "_method": "POST",
                },
            })
            .done(function(res) {
                let notificationId = res.notification.id;
                let count = res.count;

                $('#ajax-flash-message').empty();
                $("#notice-count").empty();
                $(`#notice-${notificationId}`).remove();
                $(`#notice-divider-${notificationId}`).remove();

                if (count !== 0) {
                    let newCount = `
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger custom-notice-numbers">
                            ${count}
                        </span>
                    `;
                    $("#notice-count").append(newCount);
                }
                
                let dom = '<div class="p-1"><div class="alert alert-info mb-0" role="alert">既読にしました。</div></div>'
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
                alert("既読処理に失敗しました。");
            });
        });
    });
</script>
