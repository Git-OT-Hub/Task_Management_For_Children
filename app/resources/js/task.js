"use strict";

{
    // 画像生成時の処理中画面
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.querySelector("#image-generation-form");
        const mask = document.querySelector("#loading-overlay-task");

        form.addEventListener("submit", () => {
            mask.classList.remove("custom-hidden");
        });
    });

    // 課題画像削除の確認画面
    document.addEventListener("DOMContentLoaded", () => {
        const deleteTaskImage = document.querySelector("#delete-task-image");
        if (deleteTaskImage) {
            deleteTaskImage.addEventListener("submit", (e) => {
                e.preventDefault();
                if (!confirm("この画像を削除しますか?")) {
                    return;
                }
                deleteTaskImage.submit();
            });
        }
    });
}
