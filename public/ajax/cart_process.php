<?php

    require_once("../../resources/config.php"); 

    $json = array();

    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['product_num']) && !empty(trim($_POST['product_num']))) {

            $product_num = escape_string($_POST['product_num']);

            if (isset($_SESSION['item_cart'])) {

                $cart_val = $_SESSION['item_cart'];

                //checking if the product in the array already.

                if (!in_array($product_num, $cart_val)) {

                    $counter_no = $_SESSION['counter'] + 1;
                    $_SESSION['item_cart'][$counter_no] = $product_num;
                    $_SESSION['counter'] = $counter_no;


                    $json['status'] = 100;
                    $json['msg'] = "Product Successfully Added In Cart";

                } else {

                    //product repeated

                    $json['status'] = 103;
                    $json['msg'] = "This Product Already In Cart";

                }

            } else {

                $_SESSION['item_cart'][1] = $product_num;
                $_SESSION['counter'] = 1;

                $json['status'] = 100;
                $json['msg'] = "Product Successfully Added In Cart";

            }

        } else {

            $json['status'] = 104;
            $json['msg'] = "Invalid Data Values Not Allowed";

        }

} else {

    $json['status'] = 105;
    $json['msg'] = "Invalid Request found";

}
print_r($_SESSION);
    echo json_encode($json);

?>