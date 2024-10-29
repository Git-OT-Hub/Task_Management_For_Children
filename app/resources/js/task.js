"use strict";

{
    // 画像生成時の処理中画面
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.querySelector("#image-generation-form");
        const mask = document.querySelector("#loading-overlay-task");

        if (form && mask) {
            form.addEventListener("submit", () => {
                mask.classList.remove("custom-hidden");
            });
        }
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

    // 課題削除の確認画面
    document.addEventListener("DOMContentLoaded", () => {
        const deleteTask = document.querySelector("#delete-task");
        if (deleteTask) {
            deleteTask.addEventListener("submit", (e) => {
                e.preventDefault();
                if (!confirm("この課題を削除しますか?")) {
                    return;
                }
                deleteTask.submit();
            });
        }
    });

    // 課題完了報告の確認画面
    document.addEventListener("DOMContentLoaded", () => {
        const completion = document.querySelector("#completion-report");
        if (completion) {
            completion.addEventListener("submit", (e) => {
                e.preventDefault();
                if (!confirm("この課題の完了報告をしますか?")) {
                    return;
                }
                completion.submit();
            });
        }
    });

    // 課題やり直し報告の確認画面
    document.addEventListener("DOMContentLoaded", () => {
        const redo = document.querySelector("#redo");
        if (redo) {
            redo.addEventListener("submit", (e) => {
                e.preventDefault();
                if (!confirm("この課題のやり直しを依頼しますか?")) {
                    return;
                }
                redo.submit();
            });
        }
    });

    // 課題承認の確認画面
    document.addEventListener("DOMContentLoaded", () => {
        const approval = document.querySelector("#approval");
        if (approval) {
            approval.addEventListener("submit", (e) => {
                e.preventDefault();
                if (!confirm("この課題の完了報告を承認しますか?\n承認すると取消できません。\n承認後は課題実施ユーザーへポイントが付与されます。")) {
                    return;
                }
                approval.submit();
            });
        }
    });
}
