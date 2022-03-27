document.addEventListener("DOMContentLoaded", function () {
    $(".top-menu-tools-settingbutton").on("click", function () {
        var req = new XMLHttpRequest();
        req.onerror = function () {

        };
        req.onload = function () {
            if (req.readyState === 4) {
                window.location = "http://localhost/ExchangeWebsite/backend/login.php";
            }
        };
        req.open("GET","http://localhost/ExchangeWebsite/backend/auth.php?command=logout");
        req.send();
    });
    $('.bottom-menu-item').on("click", function () {
        $('.bottom-menu-item').removeClass("bottom-menu-item-active");
        $(this).toggleClass("bottom-menu-item-active");
    });
    $('.top-menu-exchange-box-row-left-button').on("click", function () {
        var priority = $('#priority-select').children("option:selected").val();
        var section = $('#section-select').children("option:selected").val();
        var subject = $('#subject-text').val();
        var text = $('.top-menu-exchange-box-row-left-textarea').val();
        if (subject.length > 3) {
            if (text.length > 5) {
                var req = new XMLHttpRequest();
                req.onerror = function () {
                    alert("we got unexpected error, try agian");
                };
                req.ontimeout = function () {
                    alert("please check your connection and try again");
                };
                var post = JSON.stringify({"subject": subject, "text": text, "priority": priority, "section": section});
                req.open("POST", "http://localhost/ExchangeWebsite/backend/tools.php?command=send_ticket", false);
                req.onload = function () {
                    if (req.readyState === 4) {
                        var source = req.responseText;
                        if (source.includes("status")) {
                            var obj = JSON.parse(source);
                            if (obj["status"]) {
                                window.location = window.location;
                            } else {
                                if (obj["error"] === "auth required") {
                                    window.location = "http://localhost/ExchangeWebsite/backend/login";
                                } else {
                                    alert(obj["error"]);
                                }
                            }
                        } else {
                            alert("we got unexpected error, try agian");
                        }
                    }
                };
                req.setRequestHeader("Content-Type", "application/json");
                req.send(post);
            } else {
                alert("Minimum message length is 5");
            }
        } else {
            alert("Set a valid subject for your message");
        }
    });
});
