"use strict";

{
    // ルーム参加前の確認画面
    document.addEventListener("DOMContentLoaded", () => {
        const roomJoinForm = document.querySelector("#room-join-form");
        if (roomJoinForm) {
            roomJoinForm.addEventListener("submit", (e) => {
                e.preventDefault();
                if (!confirm("このルームに参加しますか?")) {
                    return;
                }
                roomJoinForm.submit();
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