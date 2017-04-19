// Scroll top button behaviour
$(document).ready(
    function () {
        $(window).scroll(
            function () {
                if ($(this).scrollTop() > 200) {
                    $(".scrollTopButton").fadeIn(300);
                } else {
                    $(".scrollTopButton").fadeOut(300);
                }

            });

        $(".scrollTopButton").click(
            function (event) {
                event.preventDefault();
                $("html, body").animate({
                    scrollTop: 0
                }, 300);
            });
    });
