"use strict";

{
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
}
