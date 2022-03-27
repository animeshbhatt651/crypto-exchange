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
});

function validurl(url) {
    try {
        var ok = new URL(url);
        return true;
    } catch {
        return false;
    }
}