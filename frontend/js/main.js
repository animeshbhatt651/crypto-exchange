document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("amount-send").addEventListener("input", function (e) {
        var valwe = e.target.value;
        var we = $("#currency-send").val().toString().toLowerCase();
        var pricewe = parseFloat($("#" + we + "-price").text());
        var they = $("#currency-receive").val().toString().toLowerCase();
        var pricethey = parseFloat($("#" + they + "-price").text());
        var finalnew = (valwe * pricewe) / pricethey;
        $('#amount-receive').val(Math.round(finalnew * 100000) / 100000);
    });
    setInterval(function () {
        $('.main-prices-item').each(function () {
            var id = $(this)[0].id.toString().split("-")[2];
            var unique = id;
            id = id + "USDT";
            getprice(id.toUpperCase(), function (data) {
                $("#" + unique + "-price").text(data["price"]);
                $("#" + unique + "-percent").text(data["percent"]);
            });
        });
        checkauth();
    }, 5000);

    $('.bottom-menu-item').on("click", function () {
        $('.bottom-menu-item').removeClass("bottom-menu-item-active");
        $(this).toggleClass("bottom-menu-item-active");
    });
    $('.svgemption').on("click", function () {
        $(".svgemption").removeClass("svg-emotion-active");
        $(this).toggleClass("svg-emotion-active");
    });
    $('.section-top-exchange-row-cryptos-list-item.send').on("click", function (e) {
        e.stopPropagation();
        $('.section-top-exchange-row-cryptos-list-item.send').removeClass("active");
        $(this).toggleClass("active");
        var newcurrencysign = $(this)[0].lastElementChild.innerHTML;
        var newcurrentyimage = $(this)[0].firstElementChild.children[0].src;
        var newcurrencyname = $(this)[0].firstElementChild.children[1].innerHTML;
        $("#currency-send").val(newcurrencysign);
        $('#send-currency').text(newcurrencysign);
        $('#selector-send-currency-name').text(newcurrencyname);
        $('#selector-send-currency-image').attr("src", newcurrentyimage);
        setTimeout(function () {
            $('#box-send').css({display: "none"});
            $(document).on("click", function () {
            });
        }, 300);
    });
    $('.section-top-exchange-row-cryptos-list-item.receive').on("click", function (e) {
        e.stopPropagation();
        $('.section-top-exchange-row-cryptos-list-item.receive').removeClass("active");
        $(this).toggleClass("active");
        var newcurrencysign = $(this)[0].lastElementChild.innerHTML;
        var newcurrentyimage = $(this)[0].firstElementChild.children[0].src;
        var newcurrencyname = $(this)[0].firstElementChild.children[1].innerHTML;
        $("#currency-receive").val(newcurrencysign);
        $('#receive-currency').text(newcurrencysign);
        $('#selector-receive-currency-name').text(newcurrencyname);
        $('#selector-receive-currency-image').attr("src", newcurrentyimage);
        setTimeout(function () {
            $('#box-receive').css({display: "none"});
            $(document).on("click", function () {
            });
        }, 300);
    });

    $('.top-menu-exchange-box-cryptoselect.send').on("click", function () {
        if ($('#box-send').css("display") === "none") {
            $('#box-send').css("display", "flex");
            $('#box-receive').css("display", "none");
            $(document).on("click", perv);
        }
    });
    $('.top-menu-exchange-box-cryptoselect.receive').on("click", function () {
        if ($('#box-receive').css("display") === "none") {
            $('#box-receive').css("display", "flex");
            $('#box-send').css("display", "none");
            $(document).on("click", perv);
        }
    });
    $('.top-menu-exchange-box-cryptoselect-swap').on("click", function () {
        //swap amounts
        var old_amount = $('#amount-send').val();
        var new_amount = $('#amount-receive').val();
        $('#amount-receive').val(old_amount);
        $('#amount-send').val(new_amount);

        //swap currencies sign
        var old_currency = $("#send-currency").text();
        var new_currency = $("#receive-currency").text();
        $("#receive-currency").text(old_currency);
        $("#send-currency").text(new_currency);
        $('#currency-send').val(new_currency);
        $('#currency-receive').val(old_currency);

        //swap toggle currencies
        var old_toggle = $('#selector-send-currency-name').text();
        var new_toggle = $('#selector-receive-currency-name').text();
        $('#selector-receive-currency-name').text(old_toggle);
        $('#selector-send-currency-name').text(new_toggle);

        //swap selected items
        var old_select = $('.section-top-exchange-row-cryptos-list-item.send.active')[0].id;
        var new_select = $('.section-top-exchange-row-cryptos-list-item.receive.active')[0].id;
        var newtemp = new_select;
        new_select = old_select.replace("send", "receive");
        old_select = newtemp.replace("receive", "send");
        $('.section-top-exchange-row-cryptos-list-item.receive.active').removeClass("active");
        $('.section-top-exchange-row-cryptos-list-item.send.active').removeClass("active");
        $("#" + new_select).toggleClass("active");
        $("#" + old_select).toggleClass("active");

        //swap images
        var old_image = $('#selector-send-currency-image').attr("src");
        var new_image = $('#selector-receive-currency-image').attr("src");
        $('#selector-receive-currency-image').attr("src", old_image);
        $('#selector-send-currency-image').attr("src", new_image);
        updateprice();
    });
    $('#main-ex-one-submit').on("click", function () {
        updateprice();
        var from = $('#currency-send').val();
        var to = $("#currency-receive").val();
        var fromamount = $('#amount-send').val();
        var toamount = $('#amount-receive').val();
        var postdata = "{\"command\":\"generate_access_token\"}";
        var req = new XMLHttpRequest();
        req.onerror = function () {
            alert("unexpected error, try again");
        };
        req.open("POST", "http://localhost/ExchangeWebsite/backend/auth.php?ref=mainexchange", true);
        req.setRequestHeader("Content-Type", "application-json");
        req.send(postdata);
        req.onload = function () {
            if (req.readyState === 4) {
                var source = req.responseText;
                if (source.length > 3) {
                    var obj = JSON.parse(source);
                    if (obj["status"]) {
                        var access_token = obj["token"];
                        req = new XMLHttpRequest();
                        req.open("GET", "http://localhost/ExchangeWebsite/backend/tools.php?command=create_bill&from=" + from + "&to=" + to + "&fromamount=" + fromamount + "&toamount=" + toamount, true);
                        req.onload = function () {
                            if (req.readyState === 4) {
                                source = req.responseText;
                                if (source.length > 5) {
                                    obj = JSON.parse(source);
                                    if (obj["status"]) {
                                        window.location = "http://localhost/ExchangeWebsite/backend/main-exchange.php?id=" + obj["id"] + "&access_token=" + access_token;
                                    }
                                }
                            }
                        };
                        req.send();
                    } else {
                        alert(obj["error"]);
                    }
                }
            }
        };
    });
    $("#crypto-select-search-send").on("input", function (e) {
        var text = $(this).val();
        if (text.length <= 0) {
            $('.section-top-exchange-row-cryptos-list-item.send').css("display", "flex");
        } else {
            var list = $('.section-top-exchange-row-cryptos-list-item.send');
            for (let i = 0; i < list.length; i++) {
                if (list[i].firstElementChild.children[1].innerHTML.toLowerCase().includes(text.toLowerCase()) === false) {
                    $(list[i]).css("display", "none");
                } else {
                    $(list[i]).css("display", "flex");
                }
            }
        }
    });
    $("#crypto-select-search-receive").on("input", function (e) {
        var text = $(this).val();
        if (text.length <= 0) {
            $('.section-top-exchange-row-cryptos-list-item.receive').css("display", "flex");
        } else {
            var list = $('.section-top-exchange-row-cryptos-list-item.receive');
            for (let i = 0; i < list.length; i++) {
                if (list[i].firstElementChild.children[1].innerHTML.toLowerCase().includes(text.toLowerCase()) === false) {
                    $(list[i]).css("display", "none");
                } else {
                    $(list[i]).css("display", "flex");
                }
            }
        }
    });
});

function updateprice() {
    var valwe = $("#amount-send").val();
    var we = $("#currency-send").val().toString().toLowerCase();
    var pricewe = parseFloat($("#" + we + "-price").text());
    var they = $("#currency-receive").val().toString().toLowerCase();
    var pricethey = parseFloat($("#" + they + "-price").text());
    var finalnew = (valwe * pricewe) / pricethey;
    $('#amount-receive').val(Math.round(finalnew * 100000) / 100000);
}

function checkauth() {
    var req = new XMLHttpRequest();
    req.open("GET", "http://localhost/ExchangeWebsite/backend/auth.php?command=validate-auth", true);
    req.send();
    req.onload = function () {
        if (req.readyState === 4) {
            var source = req.responseText;
            if (source.length > 1) {
                var obj = JSON.parse(source);
                if (!obj["status"]) {
                    window.location = "login.php";
                }
            }
        }
    };
}

function getprice(symbol, target) {
    var req = new XMLHttpRequest();
    req.open("GET", "http://localhost/ExchangeWebsite/backend/tools.php?command=get_crypto_price&crypto=" + symbol, true);
    req.send();
    req.onload = function () {
        if (req.readyState === 4) {
            var source = req.responseText;
            if (source.length > 0) {
                var obj = JSON.parse(source);
                if (obj["status"]) {
                    target(obj);
                    updateprice();
                }
            }
        }
    };
}

function perv(e) {
    var targ = e.target;
    if (!$(targ).hasClass("send") &&
        !$(targ).hasClass("receive") &&
        !$(targ).hasClass("top-menu-exchange-box-cryptoselect") &&
        !$(targ).hasClass("section-top-exchange-row-cryptos") &&
        !$(targ).hasClass("section-top-exchange-search") &&
        !$(targ).hasClass("top-menu-exchange-box-cryptoselect") &&
        !$(targ).hasClass("section-top-exchange-search")) {
        $('#box-receive').css("display", "none");
        $('#box-send').css("display", "none");
        $(document).on("click", function () {
        });
    }
}