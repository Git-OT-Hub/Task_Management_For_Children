"use strict";

{
    // アイコン添付時の画像プレビュー
    document.addEventListener("DOMContentLoaded", () => {
        const iconInput = document.querySelector("div.profile-icon-input #icon");
        const iconPreview = document.querySelector("div.profile-icon-preview #iconPreview");
        
        if (iconInput && iconPreview) {
            iconInput.addEventListener("change", function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function() {
                        iconPreview.src = reader.result;
                        iconPreview.style.display = "block";
                    }
                } else if (!file) {
                    iconPreview.src = "";
                    iconPreview.style.display = "none";
                }
            });
        }
    });

    // アイコン削除時の確認画面
    document.addEventListener("DOMContentLoaded", () => {
        const iconDelete = document.querySelector("#icon-delete");
        if (iconDelete) {
            iconDelete.addEventListener("submit", (e) => {
                e.preventDefault();
                if (!confirm("このアイコンを削除しますか?")) {
                    return;
                }
                iconDelete.submit();
            });
        }
    });
}
