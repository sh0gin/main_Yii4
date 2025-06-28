export { giveInputComment, answerShow, answerButton, deleteComment };
import { getPost } from "./blogs.js";
import { get, clearMessage } from "./asists.js";

function giveInputComment() {
  // форма для создание комментария к посту
  $("body").on("click", "input[name=send_comment]", function (e) {
    e.preventDefault();

    let $message = $("#message").val();
    let $post_id = $(".comment-form-wrap").attr("data-id");
    let $token = localStorage.getItem("token");

    $.ajax({
      url: "/work_post.php",
      method: "POST",
      dataType: "json",
      data: { message: $message, post_id: $post_id, token: $token },
      success: function ($response) {
        console.log($response);
        if ($response.status) {
          // исполняеться если валидация нашла ошибку
          $("textarea[name='message']").addClass("is-invalid");
          $(".name-message-comment").text($response.valid_message);
          // $("body > .post").html(""); // нужно сделать чтобы комментарий добавлялся сразу же
        } else {
          $("textarea[name='message']").removeClass("is-invalid");
          getPost($post_id);
        }
      },
    });
  });
}

function answerShow() {
  $("body").on("click", ".reply", function (elem) {
    clearMessage();

    let $id_com = $(this).attr("data-com");

    let $id = get("id");
    let $url =  window.location.href.slice(0, -1) + `&comment=${$id_com}`;
    history.pushState({}, "", $url);

    elem.preventDefault();

    $(".post-content").html("");
    $(".answer-section").removeClass("not-active");
  });
}

function answerButton() {
  $(".answer-form").submit(function (elem) {
    elem.preventDefault();
    let $message = $(".answer-form-val").val();

    let $token = localStorage.getItem("token");
    let $id_comment = get("comment");
    let $id_post = get("id");

    $.ajax({
      url: "/work_post.php",
      method: "POST",
      dataType: "json",
      data: {
        message: $message,
        token: $token,
        comment_id: $id_comment,
        post_id: $id_post,
      },
      success: function ($response) {
        if ($response.status) {
          // исполняеться если валидация нашла ошибку
          $("textarea[name='message-answer']").addClass("is-invalid");
          $(".content-message-answer").text($response.valid_message);
        } else {
          $("textarea[name='message-answer']").removeClass("is-invalid");
          getPost($id_post);
        }
      },
    });
  });
}

function deleteComment() {
  $("body").on("click", ".delete-button-comment", function () {
    let $id = $(this).attr("data-com");
    let $id_post = get("id");

    $.ajax({
      url: "/deleteComment.php",
      method: "POST",
      dataType: "json",
      data: { id_comment: $id },
      success: function ($response) {
        getPost($id_post);
      },
    });
  });
}
