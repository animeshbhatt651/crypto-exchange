document.addEventListener("DOMContentLoaded", function () {
    setInterval(function () {
        $('.price-table').each(function () {
            try {
                var id = $(this)[0].id;
                var SHORTNAME = id.split('-')[1];
                getprice(SHORTNAME + "USDT", function (data) {
                    var percent = data["percent"];
                    var color = "green";
                    if (percent <= 0) {
                        color = "red";
                    }
                    $("#all-" + SHORTNAME + "-price").text(data["price"]);
                    $("#all-" + SHORTNAME + "-percent").text(percent).css("color", color);

                });
            } catch {
            }
        });
    }, 5000);

    $('.bottom-menu-item').on("click", function () {
        $('.bottom-menu-item').removeClass("bottom-menu-item-active");
        $(this).toggleClass("bottom-menu-item-active");
    });
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
                }
            }
        }
    };
}