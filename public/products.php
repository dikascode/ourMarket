<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>


    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="row">
                <div class="col-md-6" style="margin-top: 2%;">
                    <h2>All Products</h2>
                </div>
            </div>

            <div class="row">

                <?php echo get_products(); ?>


                </div>

                <!-- Row ends here -->

            </div>

        </div>

    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>

    <script>
        //$('a[target="_blank"]').removeAttr('target');
    </script>


   
