import { getFullPost } from "./blogs.js";
import { removeInvalidInput } from "./asists.js";
export { loginShow, giveInputLogin, getUserStatus, logout };

function loginShow() { // Отображает страницу входа
  $(".login").removeClass("not-active");
  $("a[data-section=login]").addClass("colorlib-active");
}

function loginHide() { // Скрывает страницу входа
  $(".login").addClass("not-active");
}

function getUserStatus() { // Проверяет статус пользователя по токену. После проверки делает соответсвующие пункту видимыми или убирает их.
  let $token = localStorage.getItem("token");
  if ($token) {
    $.ajax({
      url: "/getUser.php",
      method: "POST",
      dataType: "json",
      data: { token: $token },
      success: function ($response) { // response массив атрибутов пользователя

        if (!$response.isAdmin && !$response.isGuest) { // кнопка отображения поста
          $(".div-creat-post").removeClass("not-active");
        }
        if ($response.isAdmin) { // кнопка пункта "Пользовватели" 
          $(".users_menu").removeClass("not-active");
        } else {
          $(".users_menu").addClass("not-active");
        }
        if ($response.token) {
          $(".identity_user").addClass("not-active"); // Скрываем пункт меню Вход
          $(".exting_user").removeClass("not-active"); // Отображем пнкт меню Выход
          $("a[data-section=exting]").html(`Выход <b>(${$response.login})</b>`); // Отображаем логин возле пункта "Выход"
        }
      },
    });
  } else {
    $(".div-creat-post").addClass("not-active"); // по Аналогии с селектами выше
    $(".identity_user").removeClass("not-active");
    $(".users_menu").addClass("not-active");
    $(".exting_user").addClass("not-active");
  }
}

function giveInputLogin() { // Срабатывает по нажатию кнопки Вход(на форма, не в пункте меню)
  let $url = `index.html`;
  history.pushState({}, "", $url);
  $(".login-btn").on("click", function (e) { // кнопка Вход
    e.preventDefault();
    let $obj = {}; // or it create automatelly

    $(".login-form") // забираем данные из формы
      .find("input")
      .each((sd, el) => {
        $obj[$(el).attr("name")] = $(el).val(); // кладём в объект $obj
      });


    $.ajax({
      url: "./basic/web/user/load",
      method: "POST",
      dataType: "json",
      data: $obj,
      success: function ($response) {
        // если данные формы прошли валидацию, мы скрывает страницу логина, отображаем блоги, а также добавляем token в localstorage. Вызываем функцию для проверки статуса кнопок
        console.log($response);
        if ($response.status) {
          
          removeInvalidInput();
          loginHide();
          $("a[data-section=blogs]").addClass("colorlib-active");
          localStorage.setItem("token", $response["token"]);
          getUserStatus(); // после добавления токена, изменяем отображение всех кнопок.
          getFullPost();

        } else {

          $("input").each(function () {
            $(this).removeClass("is-invalid"); // убираем все выводы ошибок в форме
          });

          Object.keys($response).map(function ($elem) {
            // если есть ошибки вставляем их, иначе вставввляем значение прсто\

            if ($elem.includes("valid_")) {
              if ($response[$elem]) {
                $(`input[id='${$elem.slice(6)}']`).addClass("is-invalid");
                $(`.${$elem.slice(6)}-message-auth`).text($response[$elem]);
              }
            } else {
              $(`.login-form > input`).attr("value", $response[$elem]);
            }
          });
        }
      },
    });
  });
}


function logout() { // удаляем токен в localstorage
  $.ajax({
      url: "./basic/web/user/logout",
      method: "POST",
      dataType: "json",
      data: {'token' : localStorage.getItem('token')},
      success: function ($response) {
  }})

  localStorage.removeItem("token");
}
