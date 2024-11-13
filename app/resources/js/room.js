"use strict";

{
    // ルーム参加前の確認画面
    document.addEventListener("DOMContentLoaded", () => {
        const roomsList = document.querySelector("#rooms-list");
        if (roomsList) {
            roomsList.addEventListener("submit", (e) => {
                const targetForm = e.target;
                if (targetForm) {
                    e.preventDefault();
                    const roomName = targetForm.querySelector("input[name='room_name']").value;
                    if (!confirm(`ルーム「 ${roomName} 」に参加しますか?`)) {
                        return;
                    }
                    targetForm.submit();
                }
            });
        }
    });

    // ルーム削除の確認画面
    document.addEventListener("DOMContentLoaded", () => {
        const roomDeleteForm = document.querySelector("#room-delete-form");
        if (roomDeleteForm) {
            roomDeleteForm.addEventListener("submit", (e) => {
                e.preventDefault();
                if (!confirm("このルームを削除しますか?")) {
                    return;
                }
                roomDeleteForm.submit();
            });
        }
    });
}