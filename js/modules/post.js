import { getFullPost, addBlogsHide, hideAll, getPost } from "./blogs.js";
import { clearPost } from "./asists.js";

export { giveInputPost, edit }

function giveInputPost($id = false) { // нужен чтобы взять id пользователя по токену и передать в функцию giveInputPostPlus, чтобы создать новый пост
    $(".post-action-form").submit(function (e) {
        let $url_string = (window.location.href);
        var $url = new URL($url_string);
        var $id_post = $url.searchParams.get("id");

        e.preventDefault();

        let $token = localStorage.getItem("token");
        let $formData = new FormData(this);
        $formData.append("token", $token);

        if ($id) {
            $formData.append("id_post", $id_post);
        }

        $formData.append("id_post", $id_post);
        console.log($formData);
        $.ajax({
            url: "./basic/web/post/load",
            method: 'POST',
            dataType: "json",
            contentType: false,
            processData: false,
            data: $formData,
            success: function ($response) {
                // console.log(Number($response.id));
                if (!$response.status) {
                    addBlogsHide();
                    console.log('GOOO');
                    // getFullPost(); // чтобы выводилась страница постов
                    getPost(Number($response.id));
                    clearPost(); // очищает форму
                }

                $("input").each(function () { // убираем is-invalid(красное окно + показ ошибок) в input в форме
                    $(this).removeClass("is-invalid");
                })
                $("textarea").removeClass("is-invalid");

                Object.keys($response).map(function ($elem) { // для каждого элемента вывода work_register.php делаем следующеее
                    if ($elem.includes("valid_")) {
                        if ($response[$elem]) {
                            $(`input[id='${$elem.slice(6)}']`).addClass('is-invalid'); // добавляем is-invalud
                            $(`textarea[id='${$elem.slice(6)}']`).addClass('is-invalid'); // добавляем is-invalud
                            $(`.${$elem.slice(6)}-message`).text($response[$elem]); // текст в сообщение ошибки. Нужно потом по проверять здесь
                        }
                    }
                })
            }
        })

    })
}

function edit() {
    $("body").on("click", '.text-warning', function (elem) {
        elem.preventDefault();
        let $id_post = $(this).attr("data-id");
        hideAll();
        $('.post-action').removeClass("not-active"); // страница добавление поста
        let $url = `index.html?id=${$id_post}`;
        history.pushState({ id: $id_post }, "", $url);
        let $token = localStorage.getItem("token");

        $.ajax({
            url: "/getPost.php",
            method: "POST",
            dataType: "json",
            data: { id: $id_post, token: $token },
            success: function ($response) {
                $('input[id=title]').val($response[0].title);
                $('input[id=preview]').val($response[0].preview);
                $('textarea[id=content]').val($response[0].content);
            }
        })
        // localStorage.setItem("id", $id_post);
        // по идее тут пишу чем заполнять и всё работает

    })
}



// function giveInputPostPlus($autor_id, $formData) { // создаёт пост и записывает его в базу данных. Не выводит, только записывает в БД.

//     $.ajax({
//         url: '/work_post-create.php',
//         method: 'POST',
//         dataType: "json",
//         contentType: false,
//         processData: false,
//         data: $formData,
//         success: function ($response) {
//             if (!$response.status) {
//                 addBlogsHide();
//                 getFullPost();
//                 $(".post-action-form").find("input").attr("value", "");
//                 $("#title").attr("value", "");
//             }

//             $("input").each(function () { // убираем is-invalid(красное окно + показ ошибок) в input в форме
//                 $(this).removeClass("is-invalid");
//             })
//             $("textarea").removeClass("is-invalid");

//             Object.keys($response).map(function ($elem) { // для каждого элемента вывода work_register.php делаем следующеее
//                 if ($elem.includes("valid_")) {
//                     if ($response[$elem]) {
//                         $(`input[id='${$elem.slice(6)}']`).addClass('is-invalid'); // добавляем is-invalud
//                         $(`textarea[id='${$elem.slice(6)}']`).addClass('is-invalid'); // добавляем is-invalud
//                         $(`.${$elem.slice(6)}-message`).text($response[$elem]); // текст в сообщение ошибки. Нужно потом по проверять здесь
//                     }
//                 }
//             })
//         }
//     })
// }

//
// giveInputPost
// $(".creat-post-btn").on("click", function (e) {
//     e.preventDefault();
//     let $obj = {};
//     let $formData = $(".post-action-form");
//     console.log($formData);
//     $.ajax({
//         url: '/work_post-create.php',
//         method: 'POST',
//         dataType: "json",
//         contentType: false,
//         processData: false,
//         data: $formData,
//         success: function ($response) { //
//             console.log($response);


//         }
//     })
// })
