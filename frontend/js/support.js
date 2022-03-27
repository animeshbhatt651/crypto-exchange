document.addEventListener("DOMContentLoaded", function () {
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

            } else {
                alert("Minimum message length is 5");
            }
        } else {
            alert("Set a valid subject for your message");
        }
    });
});
