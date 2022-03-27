$('#fullname-box').on("focus", function () {
    $("#password-owner").removeClass("section-right-inputowner-active");
    $("#email-owner").removeClass("section-right-inputowner-active");
    $("#fullname-owner").toggleClass("section-right-inputowner-active");
});
$('#email-box').on("focus", function () {
    $("#password-owner").removeClass("section-right-inputowner-active");
    $("#fullname-owner").removeClass("section-right-inputowner-active");
    $("#email-owner").toggleClass("section-right-inputowner-active");
});
$('#password-box').on("focus", function () {
    $("#fullname-owner").removeClass("section-right-inputowner-active");
    $("#email-owner").removeClass("section-right-inputowner-active");
    $("#password-owner").toggleClass("section-right-inputowner-active");
});

$("#button-login").on("click", function () {
    $("#error-box").text("").css({display: "none"});
    var email = $('#email-box').val();
    var password = $('#password-box').val();
    var haserror = false;
    if (password.length < 8) {
        haserror = true;
    }
    if (!(email.length > 5 && email.includes("@") && email.includes("."))) {
        haserror = true;
    }

    if (!haserror) {
        var access_token = $("#hidden-access-token").val();
        if (access_token.length > 0) {
            postdata = "{\"command\":\"check_credentials\",\"access_token\":\"" + access_token + "\",\"email\":\"" + email + "\",\"password\":\"" + password + "\"}";
            var req = new XMLHttpRequest();
            req.onerror = function () {
                seterror("unexpected error, try again");
            };
            req.open("POST", "http://localhost/ExchangeWebsite/backend/auth.php?ref=login", true);
            req.setRequestHeader("Content-Type", "application-json");
            req.onload = function () {
                if (req.readyState === 4) {
                    if (req.responseText.includes("status")) {
                        var obj = JSON.parse(req.responseText);
                        if (obj["status"]) {
                            window.location = "main.php";
                        } else {
                            seterror(obj["error"]);
                        }
                    } else {
                        seterror("unexpected error, try again");
                    }
                }
            };
            req.send(postdata);
        } else {
            var postdata = "{\"command\":\"generate_access_token\"}";
            var xml = new XMLHttpRequest();
            xml.onerror = function () {
                seterror("unexpected error, try again");
            };
            xml.open("POST", "http://localhost/ExchangeWebsite/backend/auth.php?ref=login", true);
            xml.setRequestHeader("Content-Type", "application-json");
            xml.send(postdata);
            xml.onload = function () {
                if (xml.readyState === 4) {
                    var source = xml.responseText;
                    if (source.includes("status")) {
                        var obj = JSON.parse(source);
                        if (obj["status"]) {
                            var access_token = obj["token"];
                            $("#hidden-access-token").val(access_token);
                            postdata = "{\"command\":\"check_credentials\",\"access_token\":\"" + access_token + "\",\"email\":\"" + email + "\",\"password\":\"" + password + "\"}";
                            var req = new XMLHttpRequest();
                            req.onerror = function () {
                                seterror("unexpected error, try again");
                            };
                            req.open("POST", "http://localhost/ExchangeWebsite/backend/auth.php?ref=login", true);
                            req.setRequestHeader("Content-Type", "application-json");
                            req.onload = function () {
                                if (req.readyState === 4) {
                                    if (req.responseText.includes("status")) {
                                        var obj = JSON.parse(req.responseText);
                                        if (obj["status"]) {
                                            window.location = "main.php";
                                        } else {
                                            seterror(obj["error"]);
                                        }
                                    } else {
                                        seterror("unexpected error, try again");
                                    }
                                }
                            };
                            req.send(postdata);
                        } else {
                            seterror(obj["error"]);
                        }
                    } else {
                        seterror("unexpected error, try again");
                    }
                }
            };
        }
    } else {
        seterror("invalid credentials");
    }
});
$('#button-signup').on("click", function () {
    $("#error-box").text("").css({display: "none"});
    var checked = $("#iaggree-check").is(":checked");
    if (checked) {
        var email = $('#email-box').val();
        var password = $('#password-box').val();
        var haserror = false;
        if (password.length < 8) {
            haserror = true;
        }
        if (!(email.length > 5 && email.includes("@") && email.includes("."))) {
            haserror = true;
        }

        if (!haserror) {
            var access_token = $("#hidden-access-token").val();
            if (access_token.length > 0) {
                postdata = JSON.stringify({
                    "command": "create_user",
                    "access_token": access_token,
                    "email": email,
                    "password": password
                });
                var req = new XMLHttpRequest();
                req.onerror = function () {
                    seterror("unexpected error, try again");
                };
                req.open("POST", "http://localhost/ExchangeWebsite/backend/auth.php?ref=signup", true);
                req.setRequestHeader("Content-Type", "application-json");
                req.onload = function () {
                    if (req.readyState === 4) {
                        if (req.responseText.includes("status")) {
                            var obj = JSON.parse(req.responseText);
                            if (obj["status"]) {
                                window.location = "login.php";
                            } else {
                                seterror(obj["error"]);
                            }
                        } else {
                            seterror("unexpected error, try again");
                        }
                    }
                };
                req.send(postdata);
            } else {
                var postdata = JSON.stringify({"command": "generate_access_token"});
                var xml = new XMLHttpRequest();
                xml.onerror = function () {
                    seterror("unexpected error, try again");
                };
                xml.open("POST", "http://localhost/ExchangeWebsite/backend/auth.php?ref=signup", true);
                xml.setRequestHeader("Content-Type", "application-json");
                xml.send(postdata);
                xml.onload = function () {
                    if (xml.readyState === 4) {
                        var source = xml.responseText;
                        if (source.includes("status")) {
                            var obj = JSON.parse(source);
                            if (obj["status"]) {
                                var access_token = obj["token"];
                                $("#hidden-access-token").val(access_token);
                                postdata = JSON.stringify({
                                    "command": "create_user",
                                    "access_token": access_token,
                                    "email": email,
                                    "password": password
                                });
                                var req = new XMLHttpRequest();
                                req.onerror = function () {
                                    seterror("unexpected error, try again");
                                };
                                req.open("POST", "http://localhost/ExchangeWebsite/backend/auth.php?ref=signup", true);
                                req.setRequestHeader("Content-Type", "application-json");
                                req.onload = function () {
                                    if (req.readyState === 4) {
                                        if (req.responseText.includes("status")) {
                                            var obj = JSON.parse(req.responseText);
                                            if (obj["status"]) {
                                                window.location = "login.php";
                                            } else {
                                                seterror(obj["error"]);
                                            }
                                        } else {
                                            seterror("unexpected error, try again");
                                        }
                                    }
                                };
                                req.send(postdata);
                            } else {
                                seterror(obj["error"]);
                            }
                        } else {
                            seterror("unexpected error, try again");
                        }
                    }
                };
            }
        } else {
            seterror("invalid credentials");
        }
    } else {
        alert("you must accept our terms and conditions");
    }
});
$('#button-change-pass').on("click", function () {
    var password = $("#password-box").val();
    var confirm = $("#password-confirm-box").val();
    if (password === confirm) {
        var postdata = JSON.stringify({
            "new_password": password,
            "confirm_password": confirm,
            "vrkey": $("#vr-key").val()
        });
        var req = new XMLHttpRequest();
        req.onerror = function () {
            seterror("unexpected error, try again");
        };
        req.open("POST", "http://localhost/ExchangeWebsite/backend/tools.php?command=reset_change_password&main=true", true);
        req.setRequestHeader("Content-Type", "application-json");
        req.onload = function () {
            if (req.readyState === 4) {
                if (req.responseText.includes("status")) {
                    var obj = JSON.parse(req.responseText);
                    if (obj["status"]) {
                        alert("your password has been changed, please relogin now");
                        window.location = "http://localhost/ExchangeWebsite/backend/login.php";
                    } else {
                        seterror(obj["error"]);
                    }
                } else {
                    seterror("unexpected error, try again");
                }
            }
        };
        req.send(postdata);
    } else {
        alert("invalid confirm password");
    }
});
$("#button-send-recovery").on("click", function () {
    $("#error-box").text("").css({display: "none"});
    var email = $('#email-box').val();
    var haserror = false;

    if (!(email.length > 5 && email.includes("@") && email.includes("."))) {
        haserror = true;
    }

    if (!haserror) {
        var postdata = JSON.stringify({"email": email});
        var req = new XMLHttpRequest();
        req.onerror = function () {
            seterror("unexpected error, try again");
        };
        req.open("POST", "http://localhost/ExchangeWebsite/backend/tools.php?command=reset_password&main=true", true);
        req.setRequestHeader("Content-Type", "application-json");
        req.onload = function () {
            if (req.readyState === 4) {
                if (req.responseText.includes("status")) {
                    var obj = JSON.parse(req.responseText);
                    if (obj["status"]) {
                        alert("link has been sent");
                    } else {
                        seterror(obj["error"]);
                    }
                } else {
                    seterror("unexpected error, try again");
                }
            }
        };
        req.send(postdata);
    } else {
        seterror("invalid email");
    }
});

function seterror(text) {
    $("#error-box").text(text).css({display: "unset"});
}
