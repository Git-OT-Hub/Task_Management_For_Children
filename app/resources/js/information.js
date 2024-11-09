"use strict";

{
    const noticeCount = document.querySelector("#notice-count");
    const noticeCountChild = document.querySelector("#notice-count span");

    window.Echo.private('App.Models.User.' + window.userId)
    .notification((notification) => {
        if (noticeCountChild) {
            noticeCountChild.remove();
        }
        console.log(notification.count);
        //testB.textContent = notification.content;
    });
}
