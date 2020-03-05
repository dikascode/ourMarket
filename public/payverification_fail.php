<?php require_once("../resources/config.php"); ?>


<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

<?php   
    transaction_verification();

    //echo $_GET['txref'];

    //session_destroy();

?>

    <!-- Page Content -->
    <div class="container">

        <h1 class='bg-danger'>We're really sorry, but something appears to have gone wrong with your payment for <?php if(isset($_GET['txref'])) {echo $_GET['txref'];} ?> transaction. </h1>
        <h3 class="bg-info">Please contact your bank if you were debited. Otherwise click <a style="color:blue" href="checkout.php">here</a>  to try again. Thanks for patronizing Our Market. We love you, always.</h3>

    

    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
