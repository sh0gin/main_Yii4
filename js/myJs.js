import {
  loginShow,
  giveInputLogin,
  getUserStatus,
  logout,
} from "./modules/login.js";
import {
  getPost,
  getFullPost,
  addPostButton,
  moreButton,
  deletePost,
} from "./modules/blogs.js";
import { registerShow, giveInputRegister } from "./modules/register.js";
import { hideAll, hideCorolLibAll, clearPost, removeInvalidInput } from "./modules/asists.js";
import { indexShow, getFullPostTen } from "./modules/index.js";
import { aboutShow } from "./modules/about.js";
import { giveNumPagination } from "./modules/pagination.js";
import {
  usersShow,
  permanent,
  banTimeShow,
  banTimeButton,
} from "./modules/users.js";
import { giveInputPost, edit } from "./modules/post.js";
import {
  giveInputComment,
  answerShow,
  answerButton,
  deleteComment,
} from "./modules/comment.js";

$(() => {
  getPost();
  getFullPostTen(); // показываем Главную и посты на ней генерим
  getUserStatus(); // действивя с пользователей

  $("body").on("click", ".link", function (e) {
    clearPost();
    removeInvalidInput();

    e.preventDefault();

    $("body").find("input").attr("value", "");
    hideCorolLibAll(); // убирает corolLib у всех пунктов

    hideAll(); // убирает все страницы

    switch ($(this).attr("data-section")) {
      case "login":
        loginShow();
        break;
      case "register":
        registerShow();
        break;
      case "blogs":
        getFullPost(); //  посты делает на страице
        addPostButton(); // кнопка Создать пост
        break;
      case "index":
        getFullPostTen();
        break;
      case "about":
        aboutShow();
        break;
      case "users":
        usersShow();
        break;
      case "exting":
        logout();
        getUserStatus();
        indexShow();
        break;
    }
  });

  banTimeShow(); // временная блокировка 1 
  giveInputPost(); // срабатывает когда жмём на кнопку создания поста 1
  giveInputLogin(); // берем данные с форм входа по нажатию кнопки Вход 1 
  giveInputRegister(); // берем данные с формы регистрации по нажатию к нопки Регистрация1 
  deletePost(); // удалить пост 1
  banTimeButton(); // заблокировать на время 1
  deleteComment(); // удалить комментарий 1
  permanent(); // постоянная блокировка 1
  moreButton(); // кнопка Подробнее... 1
  edit(); // окно показа редактирования поста 1
  giveInputComment(); // селектор на нажатии кнопки создания комментария 1
  answerButton(); // кнопка ответить на комментарии 1
  answerShow(); // кнопка ответить на комментарий 1
  giveNumPagination(); // срабатывает когда жмём на кнопки пагинации 0
  getUserStatus(); // проверяет статус пользователя 1
});


// 06.06.2025
// $('.options-sort').each(() =>
//   console.log(this)
// )
// $('.register-btn').on('click', function () {
//   e.preventDefault();
//   console.log("123");
// })
// 05.06.2025
// $("section").each(function (a) {
//     console.log(a);
//     $(a).addClass('not-active');
// })
// let a = document.querySelectorAll("section");
// a.forEach(function (elem) {
//     console.log(elem);
//     elem.classList.add("not-active")
// })
