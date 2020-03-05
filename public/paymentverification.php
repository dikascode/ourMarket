<?php require_once("../resources/config.php"); ?>


<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

  <!-- CRSF returned token -->
  <?php $crsf = form_protect(); ?>


<!-- BREADCRUMB -->
<div id="breadcrumb">
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="index.php">Home</a></li>
				<li class="active">Purchase Report</li>
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
				
                <div class="col-md-12">
						<div class="order-summary clearfix">
							<div class="section-title">
								<h3 class="title">Purchase Report</h3>
                                <h4 class="bg-danger text-center"><?php display_message(); ?></h4>
							</div>
							<table class="shopping-cart-table table">
								<thead>
									<tr>
                                        <th>S/N</th>	
                                        <th class="text-center">Product</th>
										<th><th>
										<th class="text-center">Price</th>
										<th class="text-center">Quantity</th>
										<th class="text-center">SubTotal</th>
										<th class="text-center">Status</th>
                                        
										
									</tr>
								</thead>
								<tbody>
									<?php transaction_verification();  ?>
					
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
										<th>Transaction Ref</th>
										<td colspan="2"><?php if (isset($_SESSION['transaction_ref'])) {
                                                            echo $_SESSION['transaction_ref'];
                                                        } 
                                                        ?>
                                        </td>
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
					

				</div>

			
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->

    <!-- Page Content -->
    <div class="container">

        <h1 class='text-center'>THANK YOU FOR SHOPPING WITH OUR MARKET. PLEASE COME BACK AGAIN, <a href="index.php">Home</a></h1>
    

    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
