document.addEventListener("DOMContentLoaded", function () {
    $('.bottom-menu-item').on("click", function () {
        $('.bottom-menu-item').removeClass("bottom-menu-item-active");
        $(this).toggleClass("bottom-menu-item-active");
    });
    $('#wallet-edit-cancel').on("click", function () {
        $(".wallet-edit-box").css("display", "none");
        $(".body-darker").css("display", "none");
    });
    $('.top-menu-exchange-wallet-button-add').on("click", function () {
        $('#wallet-edit-mod').val("add-new");
        $(".wallet-edit-box").css("display", "flex");
        $(".body-darker").css("display", "unset");
        $('#edit-box-wallet-address').val("");
        $('#edit-box-wallet-name').val("");
    });
    $('.wallet-edit-button').on("click", function () {
        var targetaddress = $(this)[0].firstElementChild.value;
        var targetname = $(this)[0].children[1].value;
        $('#wallet-edit-mod').val("edit-" + targetaddress);
        $(".wallet-edit-box").css("display", "flex");
        $(".body-darker").css("display", "unset");
        $('#edit-box-wallet-address').val(targetaddress);
        $('#edit-box-wallet-name').val(targetname);
    });
    $('#wallet-edit-submit').on("click", function () {
        var mod = $("#wallet-edit-mod").val();
        var new_address = $("#edit-box-wallet-address").val();
        var new_name = $("#edit-box-wallet-name").val();
        var postdata = "";
        var command = "";
        if (new_address.length < 10) {
            alert("Address is invalid");
            return;
        }
        if (new_name.length <= 1) {
            alert("Name is invalid");
            return;
        }
        if (mod.includes("edit")) {
            command = "wallet_edit";
            var old = mod.split('-')[1];
            postdata = JSON.stringify({"old_address": old, "new_address": new_address, "new_name": new_name});
        } else {
            command = "wallet_add";
            postdata = JSON.stringify({"new_address": new_address, "new_name": new_name});
        }
        var req = new XMLHttpRequest();
        req.onerror = function () {
            alert("unexpected error, try again");
        };
        req.ontimeout = function () {
            alert("check your connection and try again");
        };
        req.open("POST", "http://localhost/ExchangeWebsite/backend/tools.php?command=" + command, false);
        req.setRequestHeader("Content-Type", "application/json");
        req.onload = function () {
            if (req.readyState === 4) {
                var source = req.responseText;
                if (source.includes("status")) {
                    var obj = JSON.parse(source);
                    if (obj["status"]) {
                        $(".wallet-edit-box").css("display", "none");
                        $(".body-darker").css("display", "none");
                        window.location = window.location;
                    } else {
                        if (obj["error"] === "auth required") {
                            window.location = "http://localhost/ExchangeWebsite/backend/login.php";
                        } else {
                            alert(obj["error"]);
                        }
                    }
                } else {
                    alert("unexpected error, try again");
                }
            }
        };
        req.send(postdata);
    });
});
