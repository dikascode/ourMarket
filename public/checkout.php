<?php require_once("../resources/config.php"); ?>
<?php require_once("cart.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>



    <!-- Page Content -->
    <div class="container">


<!-- /.row --> 

<div class="row">
    
      <h1>Checkout</h1>
      <h4 class="bg-danger text-center"><?php display_message(); ?></h4>

    <!-- form for paypal integration -->
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="business" value="sb-owq43p929237@business.example.com">
    <input type="hidden" name="currency_code" value="US">
    <table class="table table-striped">
        <thead>
          <tr>
           <th>Product</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
            <?php cart(); ?>
        </tbody>
    </table>

   <?php echo show_paypal(); ?>


</form>


<!-- FlutterWave payment integration -->


<?php echo flutter_wave (); ?>



<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">

<tr class="cart-subtotal">
<th>Items:</th>
<td><span class="amount">

   <?php
    
    if (isset($_SESSION['item_quantity'])){
        echo $_SESSION['item_quantity'];
    }else{
        $_SESSION['item_quantity'] = 0;
    }
   
   ?>

</span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount"><?php 
   
    if (isset($_SESSION['total_price'])){
        echo "&#8358;" . $_SESSION['total_price'];
    }else{
        $_SESSION['total_price'] = 0;
    }
?>

</span></strong> </td>
</tr>


</tbody>

</table>

</div><!-- CART TOTALS-->


 </div><!--Main Content-->


           <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; Your Website 2030</p>
                </div>
            </div>
        </footer>


    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>


    

