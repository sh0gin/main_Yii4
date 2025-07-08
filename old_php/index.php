<?php
require_once "main.php";
require_once "include/header.php";
?>

<body>

	<div id="colorlib-page">
		<div id="colorlib-page">
			<aside id="colorlib-aside" role="complementary" class="js-fullheight">
				<nav id="colorlib-main-menu" role="navigation">
					<?= $ep->give_html() ?>
				</nav>
			</aside> <!-- END COLORLIB-ASIDE -->
			<div id="colorlib-main">
				<section class="ftco-no-pt ftco-no-pb">
					<div class="container">
						<div class="row d-flex">
							<div class="col-xl-8 py-5 px-md-2">
								<div class="row pt-md-4">
									<!-- один пост/превью -->
									<div class="col-md-12">
										<div class="blog-entry ftco-animate d-md-flex">
											<!-- 
											изображение для поста 
											<a href="single.html" class="img img-2"
											style="background-image: url(images/image_1.jpg);"></a> 
										-->
											<div class="text text-2 pl-md-4">
												<h3 class="mb-2"><a href="single.html">Название (тема) поста</a></h3>
												<div class="meta-wrap">
													<p class="meta">
														<!-- <img src='avatar.jpg' /> -->
														<span class="text text-3">login</span>
														<span><i class="icon-calendar mr-2"></i>June 28, 2019</span>
														<span><i class="icon-comment2 mr-2"></i>5 Comment</span>
													</p>
												</div>
												<p class="mb-4">Preview post</p>
												<p><a href="post.html" class="btn-custom">Подробнее... <span
															class="ion-ios-arrow-forward"></span></a></p>
											</div>
										</div>
									</div>


								</div><!-- END-->

								<!-- 
								pagination
								<div class="row">
								<div class="col">
									<div class="block-27">
										<ul>
											<li><a href="#">&lt;</a></li>
											<li class="active"><span>1</span></li>
											<li><a href="#">2</a></li>
											<li><a href="#">3</a></li>
											<li><a href="#">4</a></li>
											<li><a href="#">5</a></li>
											<li><a href="#">&gt;</a></li>
										</ul>
									</div>
								</div>
							</div> -->

							</div>

						</div>
					</div>
				</section>
			</div><!-- END COLORLIB-MAIN -->
		</div><!-- END COLORLIB-PAGE -->

		<!-- loader -->
		<?php
		include "include/loader.php";
		?>


		<?php
		include "include/script.php";
		?>


</body>

</html>