<?php require_once("../resources/config.php"); ?>


<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

  <!-- CRSF returned token -->
  <?php $crsf = form_protect(); ?>


<!-- BREADCRUMB -->
<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="index.php">Home</a></li>
				<li class="active">Checkout</li>
			</ul>
		</div>
</div>
	<!-- /BREADCRUMB -->


<!-- section -->
<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<form id="checkout-form" method="post" class="clearfix">
                <div class="col-md-12">
						<div class="order-summary clearfix">
							<div class="section-title">
								<h3 class="title">Order Review</h3>
                                <h4 class="bg-danger text-center"><?php display_message(); ?></h4>
							</div>
							<table class="shopping-cart-table table">
								<thead>
									<tr>
                                        <th>S/N</th>	
                                        <th>Product</th>
                                        <th></th>
										<th class="text-center">Price</th>
										<th class="text-center">Quantity</th>
										<th class="text-center">SubTotal</th>
										<th></th>
                                        
										
									</tr>
								</thead>
								<tbody>
									<?php cart();  ?>
					
								</tbody>
								<tfoot>
									<tr>
										<th class="empty" colspan="3"></th>
                                        <th class="empty" colspan="3"></th>
										<th>ITEMS</th>
										<th colspan="2" class="sub-total">
                                        <?php 
    
                                            if (isset($_SESSION['item_quantity'])){
												if(isset($_SESSION['item_cart']) && !empty($_SESSION['item_cart'])) {
													echo  $_SESSION['item_quantity'];
												}
                                                
                                            }else{
                                                $_SESSION['item_quantity'] = 0;
                                            }
                                        ?>
                                        </th>
									</tr>
									<tr>
                                    <th class="empty" colspan="3"></th>
										<th class="empty" colspan="3"></th>
										<th>SHIPPING</th>
										<td colspan="2">Free Shipping</td>
									</tr>
									<tr>
                                        <th class="empty" colspan="3"></th>
										<th class="empty" colspan="3"></th>
										<th>TOTAL</th>
										<th colspan="2" class="total">
                                        <?php 
    
                                            if (isset($_SESSION['total_price'])){
												if(isset($_SESSION['item_cart']) && !empty($_SESSION['item_cart'])) {
													echo "&#8358;" . $_SESSION['total_price'];
												}
                                                
                                            }else{
                                                $_SESSION['total_price'] = 0;
                                            }
                                        ?>
                                        </th>
									</tr>
								</tfoot>
							</table>
							
						</div>

					</div>
					<div class="col-md-6">
						<div class="billing-details">
							<p>Already a customer ? <a href="#">Login</a></p>
							<div class="section-title">
								<h3 class="title">Billing Details</h3>
							</div>
							<div class="form-group">
								<input class="input" type="text" name="first-name" id="fname" placeholder="First Name">
							</div>
                            <div class="form-group">
                                <input type="hidden" name="crsf" class="form-control" value="<?php echo $crsf; ?>"></label>
                            </div>
							<div class="form-group">
								<input class="input" type="text" name="last-name" id="lname" placeholder="Last Name">
							</div>
							<div class="form-group">
								<input class="input" type="email" name="email" id="email" placeholder="Email">
							</div>
							<div class="form-group">
								<input class="input" type="text" name="address" id="address" placeholder="Address">
							</div>
							<div class="form-group">
								<input class="input" type="tel" name="tel" id="tel" placeholder="Telephone">
							</div>
						</div>
							
						
						</div>
					</div>

					</form>
				

						<div class="col-md">
							<!-- Remember place something in this free space -->
							<div class="pull-left">
								<!-- FlutterWave payment integration -->
									<?php echo flutter_wave (); ?>
										
							</div>
						</div>
				</div>

			
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->



<!-- /.row --> 

    <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>


    

