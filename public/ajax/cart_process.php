<?php

    require_once("../../resources/config.php"); 

    $json = array();

    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset($_POST['product_num']) && !empty(trim($_POST['product_num'])) && isset($_POST['product_qty']) &&  !empty(trim($_POST['product_qty'])) ) {

            $product_num = htmlvalidation($_POST['product_num']);
            $product_qty = htmlvalidation($_POST['product_qty']);
            // $product_price = htmlvalidation($_POST['product_price']);


            if (isset($_SESSION['item_cart'])) {

                $cart_val = $_SESSION['item_cart'];

                //checking if the product in the array already.

                if (!in_array($product_num, $cart_val)) {

                    $counter_no = $_SESSION['counter'] + 1;
                    $_SESSION['item_cart'][$counter_no]     = $product_num;
                    $_SESSION['item_cart_qty'][$counter_no] = $product_qty;
                    $_SESSION['counter']                    = $counter_no;
                   // $_SESSION['price'][$counter_no]         += ($product_price * $product_qty);


                    $json['status'] = 100;
                    $json['msg'] = "Product Successfully Added In Cart";

                } else {

                    //product repeated

                    $json['status'] = 103;
                    $json['msg'] = "This Product Already In Cart";

                }

            } else {

                $_SESSION['item_cart'][1] = $product_num;
                $_SESSION['item_cart_qty'][1] = $product_qty;
                $_SESSION['counter'] = 1;
                // $_SESSION['price'][1] =  $product_price*$product_qty;

                $json['status'] = 100;
                $json['msg'] = "Product Successfully Added In Cart";

            }

        } elseif (isset($_POST['rm_val']) && !empty(trim($_POST['rm_val']))){

            //for removing products in cart
            $rm_key = $_POST['rm_val'];
            unset($_SESSION['item_cart'][$rm_key]);
            unset($_SESSION['item_cart_qty'][$rm_key]);


            $json['status'] = 102;
            $json['msg'] = "Product Successfully Removed";
            set_message("Product Successfully Removed");

        }else {

            $json['status'] = 104;
            $json['msg'] = "Invalid Data Values Not Allowed";

        }

} else {

    $json['status'] = 105;
    $json['msg'] = "Invalid Request found";

}
// print_r($_SESSION);
    echo json_encode($json);

?>