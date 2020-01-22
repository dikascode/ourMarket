<?php require_once("../resources/config.php"); ?>



<?php

    //Detecting the get request

    if(isset($_GET['add'])){

        $query = query("SELECT * FROM products WHERE product_id= " . escape_string($_GET['add']) . " ");
        confirm($query);

        while($row = fetch_array($query)){

            if($row['product_quantity'] != $_SESSION['product_'. $_GET['add']]){

                $_SESSION['product_' . $_GET['add']] +=1;
                redirect("checkout.php");

            }else{

                set_message("We only have " . $row['product_quantity'] . " " . $row['product_title'] . " available.");
                redirect("checkout.php");

            }
        }

       
    }


    // Decrement condition

    if(isset($_GET['remove'])) {
        $_SESSION['product_' . $_GET['remove']]--;

        if($_SESSION['product_' . $_GET['remove']] < 1) {

            unset($_SESSION['item_quantity']);
            unset($_SESSION['total_price']);
            redirect('checkout.php');
        }else{
            redirect('checkout.php');
        }
    }


    // Delete condition

    if(isset($_GET['delete'])) {

        $_SESSION['product_' . $_GET['delete']] = '0';

        //unset the value

        unset($_SESSION['item_quantity']);
        unset($_SESSION['total_price']);
        
        redirect('checkout.php'); 
    }

    // Cart function

    function cart() {

        $total = 0;
        $item_quantity = 0;

        $item_name = 1;
        $item_number = 1;
        $amount = 1;
        $quantity = 1;
        

        foreach ($_SESSION as $name => $value) {
            
            if ($value > 0) {

                // Getting the substring of the session amd comparing to get the product id
                if (substr($name, 0, 8) == "product_") {

                    $length = strlen($name) - 8;
                    $id = substr($name, 8, $length);

                    //Select product from database
                    $query = query("SELECT * FROM products WHERE product_id =" . escape_string($id) . " ");
                    confirm($query);
            
                    while($row = fetch_array($query)) {

                        //getting the sub-total of the product

                        $sub = $row['product_price'] * $value;
                        $item_quantity += $value;
            
                        $product = <<<DELIMETER
                        <tr>
                            <td>{$row['product_title']}</td>
                            <td>&#8358;{$row['product_price']}</td>
                            <td>$value</td>
                            <td>&#8358;$sub</td>
                            <td>
                            <a class='btn btn-warning' href='cart.php?remove={$row['product_id']}'><span class='glyphicon glyphicon-minus'></span></a> 
                            <a class='btn btn-success' href='cart.php?add={$row['product_id']}'><span class='glyphicon glyphicon-plus'></span></a> 
                            <a class='btn btn-danger' href='cart.php?delete={$row['product_id']}'><span class='glyphicon glyphicon-remove'></span></a>
                            </td>
                        
                        </tr>


                        <input type="hidden" name="item_name_{$item_name}" value="{$row['product_title']}">
                        <input type="hidden" name="item_number_{$item_number}" value="{$row['product_id']}">
                        <input type="hidden" name="amount_$amount" value="{$row['product_price']}">
                        <input type="hidden" name="quantity_{$quantity}" value="{$value}">

                      
                        DELIMETER;
            
                        echo $product;

                        $item_name++;
                        $item_number++;
                        $amount++;
                        $quantity++;

                        //total price
                        $_SESSION['total_price'] = $total += $sub;


                        $_SESSION['item_quantity'] = $item_quantity;
                    }
        
                    }

            }

            
        }

    }


function show_paypal() {

    if (isset($_SESSION['item_quantity'])){

        $paypal_button = <<<DELIMETER

        <input type="image" name="upload"
        src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
        alt="PayPal - The safer, easier way to pay online">
    
        DELIMETER;
    
        return $paypal_button;
    }

   
}

// flutter wave api
function flutter_wave (){

    if (isset($_SESSION['item_quantity'])){

    $rave = <<<DELIMETER

        <form>
        <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
        <button class="btn btn-danger" type="button" onClick="payWithRave()">Pay Now</button>
        </form>

        <script>
        const API_publicKey = "FLWPUBK-69349e40463f5677a1cf8c8d719af2bf-X";

        function payWithRave() {
        var x = getpaidSetup({
        PBFPubKey: "FLWPUBK-69349e40463f5677a1cf8c8d719af2bf-X",
        customer_email: "user@example.com",
        amount: {$_SESSION['total_price']},
        customer_phone: "234099940409",
        currency: "NGN",
        txref: "rave-123456",
        meta: [{
        metaname: "flightID",
        metavalue: "AP1234"
        }],
        onclose: function() {},
        callback: function(response) {
        var txref = response.tx.txRef; // collect txRef returned and pass to a 	server page to complete status check.
        console.log("This is the response returned after a charge", response);
        if (
        response.tx.chargeResponseCode == "00" ||
        response.tx.chargeResponseCode == "0"
        ) {
        // redirect to a success page
        } else {
        // redirect to a failure page.
        }

        x.close(); // use this to close the modal immediately after payment.
        }
        });
        }
        </script>

    DELIMETER;

    return $rave;

    }
}


?>