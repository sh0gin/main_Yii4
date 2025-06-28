export { getPosts };

function getPosts($onePostObject) { // HTML код для КАЖДОГО отображение поста на странице БЛОГИ и ГЛАВНАЯ
	if ($onePostObject[2] === "0") {
		$onePostObject[2] = false;
	}
	const el = `<div class="col-md-12 col-xl-12">
					<div class="blog-entry d-md-flex">		
						<div class="text text-2 pl-md-4">
							<h3 class="mb-2"><a href="single.html">${$onePostObject[0].title}</a></h3>
							<div class="meta-wrap">
								<p class="meta">
									<!-- <img src='avatar.jpg' /> -->
									<span class="text text-3">${$onePostObject[0].user.login}</span>
									<span><i class="icon-calendar mr-2"></i>${$onePostObject[0].date}</span>
									<span><i class="icon-comment2 mr-2"></i>${$onePostObject[0].comments ?? "0"} Comment</span>
								</p>
							</div>
							<p class="mb-4">${$onePostObject[0].preview}</p>
							<div class="d-flex pt-1  justify-content-between">
								<div>
									<a href="#" class="btn-custom more" data-id="${$onePostObject[0].id}">
										Подробнее... <span class="ion-ios-arrow-forward"></span></a>
								</div>
								<div>` + 
								($onePostObject[0].user.id == $onePostObject[1]  ?
									`<a href="#" class="text-warning"  style="font-size: 1.8em;"
										data-id="${$onePostObject[0].id}" title="Редактировать">🖍</a>` : "" ) +
								($onePostObject[0].user.id == $onePostObject[1] || $onePostObject[2] ?
									`<a href="#" class="text-danger delete-post-button" style="font-size: 1.8em;"
										data-id="${$onePostObject[0].id}" title="Удалить">🗑</a>` : "" ) +
								`</div>

							</div>
						</div>
					</div>
				</div>`;
    return el;
}