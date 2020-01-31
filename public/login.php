<?php require_once("../resources/config.php"); ?>

<?php include(TEMPLATE_FRONT . DS . "header.php") ?>

    <!-- Page Content -->
    <div class="container">

    <!-- CRSF returned token -->
    <?php $crsf = form_protect(); ?>

      <header>
            <h1 class="text-center">Login</h1>
            <h4 class='bg-danger text-center'><?php display_message() ?></h4>
        <div class="col-sm-4 col-sm-offset-5">         
            <form class="" action="" method="post" enctype="multipart/form-data">
                <!-- calling login function -->
                    <?php login_user(); ?>

                <div class="form-group"><label for="">
                    username<input type="text" name="username" class="form-control"></label>
                </div>
                 <div class="form-group"><label for="password">
                    Password<input type="password" name="password" class="form-control"></label>
                </div>

                <div class="form-group"><label for="">
                        <input type="hidden" name="crsf" class="form-control" value="<?php echo $crsf; ?>"></label>
                </div>

                <div class="form-group">
                  <input type="submit" name="submit" class="btn btn-primary" >
                </div>
            </form>
        </div>  


    </header>

    </div>
    <!-- /.container -->

    <?php include(TEMPLATE_FRONT . DS . "footer.php") ?>
