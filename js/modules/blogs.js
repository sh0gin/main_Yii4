import { getPosts } from "./getPosts.js";
import { getPostOne } from "./getPostOne.js";
import { getCommentOne } from "./getCommentOne.js";
import { hideAll, get } from "./asists.js";
import { getHtmlPagination } from "./pagination.js";
import { deleteComment } from "./comment.js";

export { blogsShow, getHtml, getPost, getFullPost, addPostButton, moreButton, addBlogsHide, deletePost, hideAll, getComments, getHtmlTen };


function blogsShow() { // отображает страницу блоги

	$(".blogs").removeClass("not-active");
	$("a[data-section=blogs]").addClass("colorlib-active");
}

function addBlogsHide() {
	$('.post-action').addClass("not-active");
}

function getHtml($number) { // берём из getPosts.php массив с пастами и, беря по одному посту, засовывает их в страницу кода.

	let $token = localStorage.getItem("token");
	$.ajax({
		url: "./basic/web/post/get-posts",
		method: "POST",
		dataType: "json",
		data: { "token": $token, number_page: $number},
		success: function ($response) {
			// console.log($response.models.result);
			// console.log($response);
			// getPosts - генерирует html код для одного поста в благах или индексе.
			$response.models.forEach($value => $(".list-posts").append(getPosts($value)));
		},
	});
}

function getFullPost($number_pagin = 0) { // отображает все посты на странице.

	let $url = `index.html?page=1`;
	history.pushState({ page: 1 }, "", $url);

	if (!$number_pagin) {
		$number_pagin = 0;
	}

	// history.pushState({}, "", $url);
	getHtml($number_pagin);
	getHtmlPagination($number_pagin);
	blogsShow();

	$(this).addClass("colorlib-active");
	$(".list-posts").html("");
}

function getHtmlTen() {
	$(".list-10-posts").html("");
	let $token = localStorage.getItem("token");
	$.ajax({
		url: "./basic/web/post/get-ten-posts",
		method: "POST",
		dataType: "json",
		data: { "token": $token, number_page: 0},
		success: function ($response) {
			// getPosts - генерирует html код для одного поста в благах или индексе.
			$response.models.forEach($value => $(".list-10-posts").append(getPosts($value)));
		},
	});
}

function addPostButton() { // кнопка "Создать пост" открывает страницу для создания поста
	$("body").on("click", "a[data-section=post-actions]", function (elem) { // кнопка Создать Пост
		elem.preventDefault();
		hideAll();
		$('.post-action').removeClass("not-active"); // страница добавление поста
	});
}

function moreButton() { // по клику на кнопку "Подробнее..." она же .btn-custom, мы открываем страницу ПРОСМОТРА ПОСТА при помощи getPost
	$("body").on("click", '.btn-custom', function () {
		let $id_post = $(this).attr("data-id"); // тут нужно добавить в get id поста
		let $url = `index.html?id=${$id_post}`
		history.pushState({ id: $id_post }, "", $url);

		getPost();
	})
}

function getPost($id = null) { // отображает страницу ПРОСМОТРА поста 
	hideAll();
	let $token = localStorage.getItem("token");

	if ($id === null) {
		var $id = get("id");
	}

	if ($id) {
		$(".post-content").html("");
		$.ajax({
			url: "./basic/web/post/get-post",
			method: "POST",
			dataType: "json",
			data: { id: $id, token: $token },
			success: function ($response) {

				$(".post").removeClass("not-active");
				$(".post-content").html(getPostOne($response));
				getComments($response.post.id);

			},
		});
		// $(`ul[data-com=${$id_post}]`).html("");
	}
}


function getComments($id_post) {
	let $token = localStorage.getItem("token");
	// $(`ul[data-com=${$id_post}]`).replaceWith("");

	$.ajax({
		url: "./basic/web/comment/get-comments",
		method: "POST",
		dataType: "json",
		data: { id_post: $id_post, token: $token },
		success: function ($response) {
			$response.model.forEach($value => $(`ul[data-com=${$id_post}]`).append(getCommentOne($value, $response.id, $response.role)));
		},
	});
}



function deletePost() { // удаляет пост
	$("body").on("click", '.delete-post-button', function (elem) {
		console.log("POST");
		let $id_post = $(this).attr("data-id");
		$.ajax({
			url: "./basic/web/post/delete",
			method: "POST",
			dataType: "json",
			data: { id_post: $id_post },
			success: function ($response) {
				if ($response.status) {
					getFullPost()
				}
			},
		});

	})
}

// $('body').on( 'change', '.list-posts', function() {
// 	DoSomething();
// });

// let params = new URLSearchParams(document.location.search);
// let value = params.get('id'); // 'key' – это имя целевого параметра\

// if (!value) {
// 	return false;
// }

