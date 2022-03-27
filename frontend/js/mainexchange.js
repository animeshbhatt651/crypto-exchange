document.addEventListener("DOMContentLoaded", function () {
    updatewallet("blockchain", true);
    $('.bottom-menu-item').on("click", function () {
        $('.bottom-menu-item').removeClass("bottom-menu-item-active");
        $(this).toggleClass("bottom-menu-item-active");
    });
    $('.top-menu-next-providor-walletbox-item').on("click", function () {
        var providor = $(this)[0].lastElementChild.innerHTML;
        providor = providor.toLowerCase();
        updatewallet(providor, false, this);
    });
    $('.review-info-pop-button-row-no').on("click", function () {
        $('.review-info-pop').css("display", "none");
        $(".body-darker").css("display", "none");
    });
    $('.review-info-pop-button-row-yes').on("click", function () {
        var url = $("#transaction-url").val();
        var wallet = "";
        var mod = $('#have-wl').val();
        if (mod === "true") {
            wallet = $(".top-menu-exchange-wallet-row-item-rad-active")[0].lastElementChild.innerHTML;
        } else {
            wallet = $("#wallet-url").val();
        }
        var bill = $("#exchange-bill-id").val();
        var post = '{"wallet":"' + wallet + '","transaction_url":"' + url + '","bill_id":"' + bill + '"}';
        var req = new XMLHttpRequest();
        req.onerror = function () {
            alert("Try again please");
        };
        req.ontimeout = function () {
            alert("Check your network and try again");
        };
        req.open("POST", "http://localhost/ExchangeWebsite/backend/tools.php?command=submit_bill", false);
        req.setRequestHeader("Content-Type", "application/json");
        req.onload = function () {
            if (req.readyState === 4) {
                var source = req.responseText;
                if (source.includes("status")) {
                    var obj = JSON.parse(source);
                    if (obj["status"]) {
                        $('.review-info-pop').css("display", "none");
                        $('.body-darker').css("display", "unset");
                        $('.otp-box').css("display", "flex");
                    } else {
                        alert(obj["error"]);
                    }
                }
            }
        };
        req.send(post);
    });
    $('.otp-input-item').on("input", function (e) {
        var key = $(this).val();
        if (key.match(/\D/)) {
            $(this).val("");
        } else {
            var id = $(this)[0].id;
            if (!id.includes("5")) {
                var num = id.split("-")[2];
                var newid = "otp-input-" + (parseInt(num) + 1);
                $("#" + newid).select();
            }
        }
    });
    $('.otp-box-buttonrow-back').on("click", function () {
        $('.body-darker').css("display", "none");
        $('.otp-box').css("display", "none");
    });
    $('.otp-box-buttonrow-yes').on("click", function () {
        var codes = $('#otp-input-1').val() + $('#otp-input-2').val() + $('#otp-input-3').val() + $('#otp-input-4').val() + $('#otp-input-5').val();
        var bill = $("#exchange-bill-id").val();
        try {
            if (parseInt(codes) > 0 && codes.toString().length === 5) {
                var req = new XMLHttpRequest();
                req.onerror = function () {
                    alert("we got unexpected error, try agian");
                };
                req.ontimeout = function () {
                    alert("please check your connection and try again");
                };
                var post = '{"otp_code":"' + codes + '","bill_id":"' + bill + '"}';
                req.open("POST", "http://localhost/ExchangeWebsite/backend/tools.php?command=submit_bill", false);
                req.onload = function () {
                    if (req.readyState === 4) {
                        var source = req.responseText;
                        if (source.includes("status")) {
                            var obj = JSON.parse(source);
                            if (obj["status"]) {
                                window.location = "http://localhost/ExchangeWebsite/backend/transactions.php";
                            } else {
                                if (obj["error"] === "invalid code") {
                                    alert("invalid otp code");
                                } else {
                                    alert("we got unexpected error, try agian");
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
                alert("invalid code");
            }
        } catch {
            alert("invalid code");

        }
    });
    $('.top-menu-exchange-wallet-row-item').on("click", function () {
        $('.top-menu-exchange-wallet-row-item').removeClass("top-menu-exchange-wallet-row-item-rad-active");
        $(this).toggleClass("top-menu-exchange-wallet-row-item-rad-active");
    });
    $('#main-ex-two-submit').on("click", function () {
        var url = $("#transaction-url").val();
        if (validurl(url)) {
            $("#reveiw-pop-from-amount").text($('#exchange-fromamount').val());
            $("#reveiw-pop-to-amount").text($('#exchange-toamout').val());
            $("#reveiw-pop-from-sign").text($('#exchange-from').val());
            $("#reveiw-pop-to-sign").text($('#exchange-to').val());
            $("#review-transaction-url").text(url);
            $('.review-info-pop').css("display", "flex");
            $(".body-darker").css("display", "unset");
        } else {
            alert("transaction url is invalid");
        }
    });
    $(".copy").on("click", function () {
        var wallet = $("#our-wallet-address").val();
        var element = document.getElementById("our-wallet-address");
        element.select();
        element.setSelectionRange(0, 99999); /*For mobile devices*/
        document.execCommand("copy");
    });
});

function validurl(url) {
    try {
        var ok = new URL(url);
        return true;
    } catch {
        return false;
    }
}

function updatewallet(providor, notoggle = false, current = null) {
    var cryptoname = $('#exchange-from').val();
    var req = new XMLHttpRequest();
    req.open("GET", "http://localhost/ExchangeWebsite/backend/tools.php?command=get_wallet_address&crypto=" + cryptoname + "&providor=" + providor, false);
    req.onload = function () {
        if (req.readyState === 4) {
            var source = req.responseText;
            if (source.length > 3) {
                var obj = JSON.parse(source);
                if (obj["status"]) {
                    $('#our-wallet-address').val(obj["wallet"]);
                    if (!notoggle) {
                        $('.top-menu-next-providor-walletbox-item').removeClass("top-menu-next-providor-walletbox-item-active");
                        $(current).toggleClass("top-menu-next-providor-walletbox-item-active");
                    }
                } else {
                    alert(obj["error"]);
                }
            }
        }
    };
    req.send();
}