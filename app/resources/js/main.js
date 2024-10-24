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
}