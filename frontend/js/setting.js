document.addEventListener("DOMContentLoaded", function () {
    $('.bottom-menu-item').on("click", function () {
        $('.bottom-menu-item').removeClass("bottom-menu-item-active");
        $(this).toggleClass("bottom-menu-item-active");
    });
    $("#button-submit-setting-change").on("click", function () {
        $("#old-password-input-error").css("display", "none");
        $("#new-password-input-error").css("display", "none");
        $("#new-confirm-password-input-error").css("display", "none");
        var oldpassword = $("#old-password").val();
        if (oldpassword.length < 8) {
            $("#old-password-input-error").css("display", "unset").text("invalid old password");
            return;
        }
        var newpassword = $("#new-password").val();
        if (newpassword.length < 8) {
            $("#new-password-input-error").css("display", "unset").text("invalid new password");
            return;
        }
        var confirmpassword = $("#confirm-password").val();
        if (confirmpassword.length < 8) {
            $("#new-confirm-password-input-error").css("display", "unset").text("invalid confirm password");
            return;
        }
        if (newpassword !== confirmpassword) {
            $("#new-confirm-password-input-error").css("display", "unset").text("confirm password should be same as new");
            return;
        }
        if (newpassword.toLowerCase() === oldpassword.toLowerCase()) {
            $("#new-password-input-error").css("display", "unset").text("new password shouldnot be same as oldone");
            return;
        }
        var postdata = JSON.stringify({
            "old_password": oldpassword,
            "new_password": newpassword,
            "confirm_password": confirmpassword
        });
        var req = new XMLHttpRequest();
        req.ontimeout = function () {
            alert("check your connection and try again");
        };
        req.onerror = function () {
            alert("unexpected error, please try again");
        };
        req.onload = function () {
            if (req.readyState === 4) {
                var source = req.responseText;
                if (source.includes("status")) {
                    var obj = JSON.parse(source);
                    if (obj["status"]) {
                        window.location = "http://localhost/ExchangeWebsite/backend/login.php";
                    } else {
                        var error = obj["error"];
                        if (error.includes("old password is")) {
                            $("#old-password-input-error").css("display", "unset").text(error);
                        } else if (error.includes("new password cannot be")) {
                            $("#new-password-input-error").css("display", "unset").text("new password shouldnot be same as oldone");
                        } else if (error === "auth required") {
                            window.location = "http://localhost/ExchangeWebsite/backend/login.php";
                        } else {
                            alert(error);
                        }
                    }
                } else {
                    alert("unexpected error, please try again");
                }
            }
        };
        req.open("POS", "http://localhost/ExchangeWebsite/backend/tools.php?command=change_password", true);
        req.setRequestHeader("Content-Type", "application/json");
        req.send(postdata);
    });
});
