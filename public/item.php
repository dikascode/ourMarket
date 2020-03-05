<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<?php $crsf = form_protect(); ?>

<!-- Get the avr ratings for each product -->

<?php 
	$query = query("SELECT id FROM ratings WHERE product_id = ". escape_string($_GET['id']) . " ");
	confirm($query);
	$numR = $query->num_rows;
	
	$rate_query = query("SELECT SUM(rateIndex) AS total FROM ratings WHERE product_id = ". escape_string($_GET['id']) . " ");
	confirm($rate_query);
	$rData 	=  $rate_query->fetch_array();
	$total 	= $rData['total'];
	if($numR !=0){
		$avg	= $total/$numR;
	}
	

?>

    <!-- Page Content -->
<div class="container-fluid">

    <!-- Query for single Product -->

<?php
    $query = query("SELECT * FROM products WHERE product_id = ". escape_string($_GET['id']) . " ");
    confirm($query);

    while($row = fetch_array($query)):

?>



<!-- BREADCRUMB -->
<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="index.php">Home</a></li>
				<li><a href="products.php">Products</a></li>
				<li><a href="#">Category</a></li>
				<li class="active"><?php echo $row['product_title']; ?></li>
			</ul>

			<h4 class="bg-info text-center"><?php display_message(); ?></h4>
		</div>
	</div>
	<!-- /BREADCRUMB -->

	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!--  Product Details -->
				<div class="product product-details clearfix">
					<div class="col-md-6">
						<div id="product-main-view">
							<div class="product-view">
								<img src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">
							</div>
							<div class="product-view">
								<img src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">
							</div>
							<div class="product-view">
								<img src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">
							</div>
							<div class="product-view">
								<img src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">
							</div>
						</div>
						<div id="product-view">
							<div class="product-view">
								<img src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">
							</div>
							<div class="product-view">
								<img src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">
							</div>
							<div class="product-view">
								<img src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">
							</div>
							<div class="product-view">
								<img src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="product-body">
							<div class="product-label">
								<span>New</span>

								<!-- Discount variable	 -->
								<?php $discount = 20; ?>

								<span class="sale">-<?php echo $discount ?>%</span>
							</div>
							<h2 class="product-name"><?php echo $row['product_title']; ?></h2>

                            <!-- old price calculation -->
                            <?php $oldPrice = $row['product_price'] + $row['product_price']*($discount/100)?>

							<h3 class="product-price">&#x20a6;<?php echo $row['product_price']; ?> <del class="product-old-price">&#x20a6;<?php echo $oldPrice; ?></del></h3>
							<div>
								<div class="product-rating">
								<i class="fas fa-star star-avr" data-index="0"></i>
								<i class="fas fa-star star-avr" data-index="1"></i>
								<i class="fas fa-star star-avr" data-index="2"></i>
								<i class="fas fa-star star-avr" data-index="3"></i>
								<i class="fas fa-star star-avr" data-index="4"></i>
								</div>
								<a href="#review-area"><?php echo $numR; ?> Review(s) / Add Review</a>
							</div>
							<p><strong>Availability:</strong> In Stock</p>
							<p><strong>Brand:</strong> OurMarket</p>
							<p><?php echo $row['product_desc'] ?></p>

							<!-- <div class="product-options">
								<ul class="size-option">
									<li><span class="text-uppercase">Size:</span></li>
									<li class="active"><a href="#">S</a></li>
									<li><a href="#">XL</a></li>
									<li><a href="#">SL</a></li>
								</ul>
								<ul class="color-option">
									<li><span class="text-uppercase">Color:</span></li>
									<li class="active"><a href="#" style="background-color:#475984;"></a></li>
									<li><a href="#" style="background-color:#8A2454;"></a></li>
									<li><a href="#" style="background-color:#BF6989;"></a></li>
									<li><a href="#" style="background-color:#9A54D8;"></a></li>
								</ul>
							</div> -->

							<div class="product-btns">
								<!-- <div class="qty-input">
									<span class="text-uppercase">QTY: </span>
									<input class="input" type="number">
								</div> -->
								
			<form method="post" class="submit_pro">
            <input type="hidden" class="pro-price" value="<?php $row['product_price'] ?>">
            <label class="col-6 col-form-label">Quantity :</label>
             <input type="number" class="col-4 pro-qty" value="1" min="1" max="100" required>
             <button type="submit" class="primary-btn pc_data" data-dataid="<?php echo $row['product_id'] ?>">Add to Cart</button>
             
            
             </form>
								<div class="pull-right">
									<button class="main-btn icon-btn"><i class="fa fa-heart"></i></button>
									<!-- <button class="main-btn icon-btn"><i class="fa fa-exchange"></i></button> -->
									<button class="main-btn icon-btn"><i class="fa fa-share-alt"></i></button>
								</div>
							</div>
						</div>
					</div>
					<div id="review-area" class="col-md-12">
						<div class="product-tab">
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
								<li><a data-toggle="tab" href="#tab1">Details</a></li>
								<li><a data-toggle="tab" href="#tab2">Reviews (<?php echo $numR; ?>)</a></li>
							</ul>
							<div class="tab-content">
								<div id="tab1" class="tab-pane fade in active">
									<p><?php echo $row['product_desc'] ?></p>
								</div>
								<div id="tab2" class="tab-pane fade in">

									<div class="row">
										<div class="col-md-6">
											<div class="product-reviews">
												<div class="single-review">
													<!-- review function here -->
													<?php echo get_product_reviews() ?>
												</div>


												

												<ul class="reviews-pages">
													<li class="active">1</li>
													<li><a href="#">2</a></li>
													<li><a href="#">3</a></li>
													<li><a href="#"><i class="fa fa-caret-right"></i></a></li>
												</ul>
											</div>
										</div>
										<div class="col-md-6">
											<h4 class="text-uppercase">Write Your Review</h4>
											<p>Your email address will not be published.</p>
											<!-- Hidden input for avg ratings -->
											<input type="hidden" class="avg_rate" value="<?php echo $avg; ?>">
											<input type="hidden" class="num_row" value="<?php echo $numR; ?>">
											
											<form class="review-form">
												<div class="form-group">
													<input class="input cust_name" type="text" placeholder="Your Name" />
													<input name="crsf" type="hidden" class="form-control crsf" value="<?php echo $crsf; ?>">
												</div>
												
												<div class="form-group">
													<input class="input cust_email" type="email" placeholder="Email Address" />
												</div>
												<div class="form-group">
													<textarea class="input cust_review" placeholder="Your review"></textarea>
												</div>
												<div class="form-group">
													<div class="input-rating">
														<strong class="text-uppercase">Your Rating: </strong>
														<div class="stars">
															<i class="fa fa-star star-rate" data-index="0"></i>
															<i class="fa fa-star star-rate" data-index="1"></i>
															<i class="fa fa-star star-rate" data-index="2"></i>
															<i class="fa fa-star star-rate" data-index="3"></i>
															<i class="fa fa-star star-rate" data-index="4"></i>
														</div>
													</div>
												</div>
												<button class="primary-btn post_rate">Submit</button>
											</form>
										</div>
									</div>



								</div>
							</div>
						</div>
					</div>

				</div>
				<!-- /Product Details -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
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


<!-- Ending while loop after col-md-9 -->

    <?php endwhile; ?>

</div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
