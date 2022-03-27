document.addEventListener("DOMContentLoaded", function () {

    document.getElementById("amount-send").addEventListener("input", function (e) {
        var valwe = e.target.value;
        var we = $("#currency-send").val().toString().toLowerCase();
        var pricewe = parseFloat($("#" + we + "-price").val());
        var they = $("#currency-receive").val().toString().toLowerCase();
        var pricethey = parseFloat($("#" + they + "-price").val());
        var finalnew = (valwe * pricewe) / pricethey;
        $('#amount-receive').val(Math.round(finalnew * 10000) / 10000);
    });
    $('#toggle-send').on("click", function () {
        if ($('#box-send').css("display") === "flex") {
            $('#box-send').css({display: "none"});
        } else {
            $('#box-send').css({display: "flex"});
            $('#box-receive').css({display: "none"});
            $(document).on("click", perv);
        }
    });
    $('#toggle-receive').on("click", function () {
        if ($('#box-receive').css("display") === "flex") {
            $('#box-receive').css({display: "none"});
        } else {
            $('#box-receive').css({display: "flex"});
            $('#box-send').css({display: "none"});
            $(document).on("click", perv);
        }
    });
    $(".section-top-exchange-row-cryptos-list-item.send").on("click", function () {
        $('.section-top-exchange-row-cryptos-list-item.send').removeClass("active");
        $(this).toggleClass("active");
        var newcurrencyname = $(this)[0].firstElementChild.children[1].innerHTML;
        var newcurrencysign = $(this)[0].lastElementChild.innerHTML;
        $('#send-currency').text(newcurrencysign);
        $('#currency-send').val(newcurrencysign);
        $('#selector-send-currency-name').text(newcurrencyname);
        setTimeout(function () {
            $('#box-send').css({display: "none"});
            $(document).on("click", function () {
            });
        }, 300);
    });
    $(".section-top-exchange-row-cryptos-list-item.receive").on("click", function () {
        $('.section-top-exchange-row-cryptos-list-item.receive').removeClass("active");
        $(this).toggleClass("active");
        var newcurrencyname = $(this)[0].firstElementChild.children[1].innerHTML;
        var newcurrencysign = $(this)[0].lastElementChild.innerHTML;
        $('#receive-currency').text(newcurrencysign);
        $('#currency-receive').val(newcurrencysign);
        $('#selector-receive-currency-name').text(newcurrencyname);

        setTimeout(function () {
            $('#box-receive').css({display: "none"});
            $(document).on("click", function () {
            });
        }, 300);
    });
    $('.section-top-exchange-value-amount').on("keypress", function (e) {
        var key = e.key;
        if (key.match(/\D/)) {
            if (key !== ".") {
                return false;
            } else {
                var text = $(this).val();
                if (text.includes(".")) {
                    return false;
                }
            }
        }
    });
    $('.section-top-exchange-buttonreverse').on("click", function () {
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

        updateprice();
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
    $('.section-top-exchange-button').on("click", function () {
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


    setInterval(function () {
        $('.main-prices-item').each(function () {
            var id = $(this)[0].id.toString().split("-")[0];
            var unique = id;
            id = id + "USDT";
            getprice(id.toUpperCase(), function (data) {
                $("#" + unique + "-price").val(data["price"]);
            });
        });
    }, 5000);
});

function getprice(symbol, target) {
    var req = new XMLHttpRequest();
    req.open("GET", "http://localhost/ExchangeWebsite/backend/tools.php?command=get_crypto_price&main=true&crypto=" + symbol, true);
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

function updateprice() {
    var valwe = $("#amount-send").val();
    var we = $("#currency-send").val().toString().toLowerCase();
    var pricewe = parseFloat($("#" + we + "-price").val());
    var they = $("#currency-receive").val().toString().toLowerCase();
    var pricethey = parseFloat($("#" + they + "-price").val());
    var finalnew = (valwe * pricewe) / pricethey;
    $('#amount-receive').val(Math.round(finalnew * 100000) / 100000);
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