export { hideAll, hideCorolLibAll, clearForm, clearPost, get,  clearMessage, removeInvalidInput }

function hideAll() { // Скрыват все страницы
    $("section").each(function () {
        $(this).addClass("not-active");
    });
}

function hideCorolLibAll() { // Убирает у всех пунктов меню подсветку
    $("nav[id=colorlib-main-menu] > ul > li > a").each(function () {
        $(this).removeClass("colorlib-active");
    });
}

function clearForm() {
    $("input").val("");
}

function clearPost() {
    $("input").val("");
    $("textarea").val("");
}

function clearMessage() {
    $("textarea").val("");
}

function get(arg) {
    let $url_string = (window.location.href);
    var $url = new URL($url_string);
    var $id = $url.searchParams.get(arg);
    return $id;
}

function removeInvalidInput() {
  $("input").each(function () {
    // убираем is-invalid(красное окно + показ ошибок) в input в форме
    $(this).removeClass("is-invalid");
  });
}