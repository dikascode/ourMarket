<?php require_once("../resources/config.php"); ?>


<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<?php   
    transaction_verification();

    //echo $_GET['txref'];

    //session_destroy();

    // unset($_SESSION['item_cart']);
    // unset($_SESSION['item_cart_qty']);
    // unset($_SESSION['total_price']);


?>

    <!-- Page Content -->
    <div class="container">

        <h1 class='text-center'>THANK YOU</h1>
    

    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
