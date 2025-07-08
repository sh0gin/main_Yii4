export { getCommentOne };

function getCommentOne($oneCommentObject, $idActive, $role) {
	if (!(typeof $oneCommentObject === 'string')) {
		$idActive = Number($idActive)
		
		if ($role === "0") {
			$role = false;
		} else {
			$role = true;
		}

		const el = `<li ` + ($oneCommentObject.comment_id ? `id='special-li'` : ``) + `class="comment">
											
		<div class="comment-body">
		
			<div class="d-flex justify-content-between">
			<h3>${$oneCommentObject.user.login}</h3>` + 
			($oneCommentObject.user.id == $idActive || $role ?
			`<a href="#" data-com='${$oneCommentObject.id}' class="text-danger delete-button-comment" style="font-size: 1.8em;"
				title="Удалить">🗑</a>` : "") +
		`</div>
		<div class="meta">
			${$oneCommentObject.date}
		</div>
		<p>
			${$oneCommentObject.message}
		</p>` +
		((!$oneCommentObject.comment_id && !$role) ? `<p><a href="#"  data-com='${$oneCommentObject.id}' class="reply"> Ответить</a></p>` : ``) + `<!-- <p><a href="#" class="reply" > Ответить</a></p> -->
	</div>
	
</li>`;
		return el;
	}

	return "";


}
