import { getUser } from "./getUser.js";
import { hideAll, get } from "./asists.js";
export { usersShow, permanent, banTimeShow, banTimeButton };

function usersShow() {
  // отображает страницу Пользоавтели
  let $url = `index.html`;
  history.pushState({}, "", $url);
  $(".t-body").html("");
  $(".users").removeClass("not-active");
  $("a[data-section=users]").addClass("colorlib-active");
  getUsers();
}

function getUsers() {
  $.ajax({
    url: "./basic/web/user/get-user",
    method: "POST",
    dataType: "json",
    // data: { },
    success: function ($response) {
      let number = 1;
      // console.log($response);

      $response[0].forEach(($value) => {
        $(".t-body").append(getUser($value, number));
        number++;
      });
    },
  });
  // banTimeButton();
}

function permanent() {
  $("body").on("click", ".btn-outline-danger", function () {
    let $id_user = $(this).attr("data-user-id");

    $.ajax({
      url: "./basic/web/user/permanent",
      method: "POST",
      dataType: "json",
      data: { 'user_id': $id_user },
      success: function () { },
    });
    usersShow();
  });
}

function banTimeShow() {
  $("body").on("click", ".btn-outline-warning", function () {
    hideAll();
    $(".contact-section-block").removeClass("not-active");
    let $id_user = $(this).attr("data-user-id");

    let $url = `index.html?id_user=${$id_user}`;

    history.pushState({ id_user: $id_user }, "", $url);
    $(".id-user-block").text(`Пользователь: ${$id_user}`);
    $("input[id=date-block]").removeClass("is-invalid");
  });
}

function banTimeButton() {
  $("body").on("click", ".button-block", function (elem) {
    elem.preventDefault();

    let $user_id = get("id_user");
    let $date = $("input[id=date-block]").val();

    $.ajax({
      url: "./basic/web/user/block-for-date",
      method: "POST",
      dataType: "json",
      data: { 'user_id': $user_id, 'date_end': $date },
      success: function ($response) {
        if ($response.status) {
          hideAll();
          usersShow();
        } else {
          $("input[id=date-block]").addClass("is-invalid");
          $(".message-message").text($response.message);
        }
      },
    });
  });
}
