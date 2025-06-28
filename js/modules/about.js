export { aboutShow }


function aboutShow() { // "показывает страницу О нас"
    $('.about').removeClass("not-active");
    $('a[data-section=about]').addClass("colorlib-active");
}