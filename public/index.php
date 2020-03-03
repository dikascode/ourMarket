<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>


	<!-- HOME -->
	<div id="home">
			<!-- container -->
			<div class="container">
				<!-- home wrap -->
				<div class="home-wrap">
					<!-- home slick -->
					<div id="home-slick">
						<!-- banner -->
						<div class="banner banner-1">
							<img src="./img/banner01.jpg" alt="">
							<div class="banner-caption text-center">
								<h1>Bags sale</h1>
								<h3 class="white-color font-weak">Up to 50% Discount</h3>
								<a href="products.php" class="primary-btn">Shop Now</a>
							</div>
						</div>
						<!-- /banner -->

						<!-- banner -->
						<div class="banner banner-1">
							<img src="./img/banner02.jpg" alt="">
							<div class="banner-caption">
								<h1 class="primary-color">HOT DEAL<br><span class="white-color font-weak">Up to 50% OFF</span></h1>
								<a href="products.php" class="primary-btn">Shop Now</a>
							</div>
						</div>
						<!-- /banner -->

						<!-- banner -->
						<div class="banner banner-1">
							<img src="./img/banner03.jpg" alt="">
							<div class="banner-caption">
								<h1 class="white-color">New Product <span>Collection</span></h1>
								<a href="products.php" class="primary-btn">Shop Now</a>
							</div>
						</div>
						<!-- /banner -->
					</div>
					<!-- /home slick -->
				</div>
				<!-- /home wrap -->
			</div>
			<!-- /container -->
	</div>
		<!-- /HOME -->
	</div>
    

    <!-- Section -->

    <?php include(TEMPLATE_FRONT . DS . "section.php") ?>

    <!-- /section -->
    

    <!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">Latest Products</h2>
					</div>
				</div>
				<!-- section title -->

				<!-- Product Single -->
				<?php echo get_latest_products (); ?>
				<!-- /Product Single -->
			</div>
			<!-- /row -->

			<!-- row -->
			<div class="row">
				<!-- section title -->
				<div class="col-md-12">
					<div class="section-title">
						<h2 class="title">Picked For You</h2>
					</div>
				</div>
				<!-- section title -->

				<!-- Product Single -->
				<?php echo get_products_in_review_page (); ?>	
				<!-- /Product Single -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->



<?php include(TEMPLATE_FRONT . DS . "footer.php") ?>

   <!-- <?php include(TEMPLATE_FRONT . DS . "slider.php") ?> -->

   
