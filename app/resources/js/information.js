"use strict";

{
    const noticeCount = document.querySelector("#notice-count");
    const noticeCountChild = document.querySelector("#notice-count span");
    const noNotice = document.querySelector("#no-notice");
    const noticeContent = document.querySelector("#notice-content");

    if (window.userId) {
        window.Echo.private('App.Models.User.' + window.userId)
        .notification((notification) => {
            // 通知数
            if (noticeCountChild) {
                noticeCountChild.remove();
            }
            const spanElementCount = document.createElement("span");
            spanElementCount.classList.add("position-absolute", "top-0", "start-100", "translate-middle", "badge", "rounded-pill", "bg-danger", "custom-notice-numbers");
            spanElementCount.textContent = notification.count;
            noticeCount.appendChild(spanElementCount);

            // 通知の表示
            if (noNotice) {
                noNotice.remove();
            }
            const liElementContentOne = document.createElement("li");
            const liElementContentTwo = document.createElement("li");
            const spanElementContent = document.createElement("span");
            const iElementContent = document.createElement("i");
            const aElementContent = document.createElement("a");
            const hrElementContent = document.createElement("hr");
            const formElementContent = document.createElement("form");
            const btnElementContent = document.createElement("button");
            const iElementContentTwo = document.createElement("i");

            spanElementContent.textContent = notification.sender;
            iElementContent.classList.add("fa-solid", "fa-arrow-right", "mx-2");
            spanElementContent.appendChild(iElementContent);

            aElementContent.classList.add("link-secondary", "link-offset-2", "link-underline-opacity-25", "link-underline-opacity-100-hover");
            aElementContent.setAttribute("href", notification.url);
            aElementContent.textContent = notification.content;

            iElementContentTwo.classList.add("fa-solid", "fa-check");
            btnElementContent.classList.add("btn", "btn-outline-primary", "btn-sm", "lh-1");
            btnElementContent.setAttribute("type", "button");
            btnElementContent.setAttribute("value", notification.id);
            btnElementContent.appendChild(iElementContentTwo);
            formElementContent.classList.add("d-inline", "ms-3");
            formElementContent.appendChild(btnElementContent);

            liElementContentOne.setAttribute("id", `notice-${notification.id}`);
            liElementContentOne.appendChild(spanElementContent);
            liElementContentOne.appendChild(aElementContent);
            liElementContentOne.appendChild(formElementContent);

            hrElementContent.classList.add("dropdown-divider");
            liElementContentTwo.setAttribute("id", `notice-divider-${notification.id}`);
            liElementContentTwo.appendChild(hrElementContent);

            noticeContent.prepend(liElementContentTwo);
            noticeContent.prepend(liElementContentOne);
        });
    }
}
