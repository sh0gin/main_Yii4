import { getFullPost } from "./blogs.js";
import { clearForm, removeInvalidInput } from "./asists.js";
export { registerShow, giveInputRegister };

function registerShow() {
  // показать регистрация
  $(".register").removeClass("not-active");
  $("a[data-section=register]").addClass("colorlib-active");
}

function registerHide() {
  // спрятать блок регистрации
  $(".register").addClass("not-active");
  $("a[data-section=register]").removeClass("colorlib-active");
}



function giveInputRegister() {
  let $url = `index.html`;
  history.pushState({}, "", $url);
  $(".btn-register").on("click", function (e) {
    // по нажатию на кнопку регистрация в форме
    e.preventDefault();
    let $obj = {};
    $(".register-form")
      .find("input")
      .not(".form-check-input")
      .each((sd, el) => {
        // забираем данные из формы в $obj
        $obj[$(el).attr("name")] = $(el).val();
      });
    
    $.ajax({
      url: "./basic/web/user/register",
      method: "POST",
      dataType: "json",
      data: $obj,
      success: function ($response) {
        if (!$response.status) {
          // если валидациия прошла успешно, скрываем регистрацию, показываем посты. Иначе должны вывести правильно валидацию в форме
          registerHide();
          getFullPost();
          $("a[data-section=blogs]").addClass("colorlib-active");
          $(".regst").attr("value", "");
          clearForm();
          removeInvalidInput();
        } else {
          removeInvalidInput();
          Object.keys($response).map(function ($elem) {
            // для каждого элемента вывода work_register.php делаем следующеее

            if ($elem.includes("valid_")) {
              // если ключ включает в себя valid_ тогда
              if ($response[$elem]) {
                // если элемент не false тогда
                $(`input[id='${$elem.slice(6)}-r']`).addClass("is-invalid"); // добавляем is-invalud
                $(`.${$elem.slice(6)}-message-reg`).text($response[$elem]); // текст в сообщение ошибки. Нужно потом по проверять здесь
              }
            }
          });
        }
      },
    });
  });
}
