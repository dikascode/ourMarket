<?php

    require_once("../../resources/config.php"); 

    if (isset($_POST['save'])) {

        if(isset($_POST['product_num']) && !empty(trim($_POST['product_num'])) && isset($_POST['ratedIndex']) &&  trim($_POST['ratedIndex']) != -1 ) {
            $ratedIndex = escape_string($_POST['ratedIndex']);
            $product_num = escape_string($_POST['product_num']);
            $uID = escape_string($_POST['uID']);
            $cust_name = escape_string($_POST['cust_name']);
            $cust_email = escape_string($_POST['cust_email']);
            $cust_review = escape_string($_POST['cust_review']);

            $ratedIndex++;

            if(!$uID) {
                
                $query = query("INSERT INTO ratings(rateIndex, product_id, cust_name, cust_email, review) 
                VALUES('$ratedIndex','$product_num', '$cust_name', '$cust_email', '$cust_review')");


                confirm($query);
                $uID = last_id();
                set_message("Thanks for rating this product");

            }else{

                $query = query("UPDATE ratings SET rateIndex = '$ratedIndex', review = '$cust_review' WHERE id='$uID' " );
                confirm($query);
                set_message("Thanks for updating your rating for this product");
            }

             exit(json_encode(array('id' => $uID, 'name' => $cust_name, 'email' => $cust_email)));

        }

} 

?>