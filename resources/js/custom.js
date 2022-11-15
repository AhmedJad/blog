export function initSuperFish() {
    $(".sf-menu").superfish({
        delay: 50,
        autoArrows: true,
        animation: { opacity: 'show' }
        //cssArrows: true
    });

    // Replace SuperFish CSS Arrows to Font Awesome Icons
    $('nav > ul.sf-menu > li').each(function () {
        if ($(this).find('.sf-with-ul .fa-angle-down').length == 0) {
            $(this).find('.sf-with-ul').append('<i class="fa fa-angle-down"></i>');
        }
    });
}
export function responsiveHeaderToggle() {
    $('.menu-toggle-btn').click(function () {
        $('.responsive_menu').slideToggle();
    });

}
export function initbxSlider() {

    $('.bxslider').bxSlider({
        adaptiveHeight: true,
        controls: false,
        auto: true,
        mode: 'fade',
    });

}

