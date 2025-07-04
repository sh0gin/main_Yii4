export { getPostOne };

function getPostOne($onePostObject) { // HTML код для отображения страницы ПРОСМОТРА поста
	
	if ($onePostObject.role === "0" || $onePostObject.role === 0) {
		$onePostObject.role = false;
	} else {
		$onePostObject.role = true;
	}

	const el = `<div class="post">
								<h1 class="mb-3">${$onePostObject.post.title}</h1>
								<div class="meta-wrap">
									<p class="meta">
										<!-- <img src='avatar.jpg' /> -->
										<span class="text text-3">${$onePostObject.user.login}</span>
										<span><i class="icon-calendar mr-2"></i>${$onePostObject.post.date}</span>
										<span><i class="icon-comment2 mr-2"></i>${$onePostObject.post.comments ?? "0"} Comment</span>
									</p>
								</div>
								<p>
                                    ${$onePostObject.post.content}
								</p>

								<p>
									<img src="${$onePostObject.url_image ?? ""}" alt="" class="img-fluid">
								</p>
								<div>` + 
								($onePostObject.user.id == $onePostObject.id  ?
									`<a href="#" class="text-warning"  style="font-size: 1.8em;"
										data-id="${$onePostObject.post.id}" title="Редактировать">🖍</a>` : "" ) +
								($onePostObject.user.id === $onePostObject.id || $onePostObject.role ?
									`<a href="#" class="text-danger delete-post-button" style="font-size: 1.8em;"
										data-id="${$onePostObject.post.id}" title="Удалить">🗑</a>` : "" ) +
								`</div>

							</div>
							<div class="comments pt-5 mt-5">
								<h3 class="mb-5 font-weight-bold">${$onePostObject.comment_count} комментариев</h3>
								<ul data-com="${$onePostObject.post.id}" class="comment-list">
									
								</ul>
								<!-- END comment-list -->
								<div class="comment-form-wrap pt-5" data-id="${$onePostObject.post.id}">` + 
									(!$onePostObject.role && $onePostObject.id != '0' ?
									`<h3 class="mb-5">Оставьте комментарий</h3><form action="#" class="p-3 p-md-5 bg-light">
										<div class="form-group">
											<label for="message">Сообщение</label>
											<textarea name="message" id="message" cols="30" rows="10"
												class="form-control"></textarea>
											<div class="invalid-feedback name-message-comment"></div>
											</div>
										<div class="form-group">
											<input type="submit" value="Отправить" name="send_comment"
												class="btn py-3 px-4 btn-primary">
										</div>
									</form>` : "") +
								`</div>
							</div>`;
	return el;

}
