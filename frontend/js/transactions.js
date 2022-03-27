document.addEventListener("DOMContentLoaded", function () {
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