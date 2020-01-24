<?php require("../../resources/config.php"); ?>
<?php include(TEMPLATE_BACK. DS . "header.php") ?>

<?php if (!isset($_SESSION['username'])) {
    redirect("../../public/login.php");
} 

?>

        <div id="page-wrapper">

            <div class="container-fluid">


             <?php 

             
                if($_SERVER['REQUEST_URI'] == "/ClientProjects/ourMarket/public/admin/" || $_SERVER['REQUEST_URI'] == "/ClientProjects/ourMarket/public/admin/index.php") {
                    include(TEMPLATE_BACK . "/admin_content.php");
                }

                if(isset($_GET['orders'])) {
                    include(TEMPLATE_BACK . "/orders.php");
                }

                if(isset($_GET['add_products'])) {
                    include(TEMPLATE_BACK . "/add_product.php");
                }


                if(isset($_GET['categories'])) {
                    include(TEMPLATE_BACK . "/categories.php");
                }

                if(isset($_GET['edit'])) {
                    include(TEMPLATE_BACK . "/edit_product.php");
                }


                if(isset($_GET['products'])) {
                    include(TEMPLATE_BACK . "/products.php");
                }


             ?>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

        <?php include(TEMPLATE_BACK. DS . "footer.php"); ?>