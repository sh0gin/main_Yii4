export { indexShow, getFullPostTen }
import { getHtmlTen } from "./blogs.js";

function indexShow() { // Отображает главную страницу
    $('.index').removeClass("not-active");
    $('a[data-section=index]').addClass("colorlib-active");
}

function getFullPostTen() { // отображает все посты на странице.
    let $url = `index.html`;
    history.pushState({}, "", $url);
    getHtmlTen();
    indexShow();
    $(this).addClass("colorlib-active");
    // $(".list-posts").html("");
}

