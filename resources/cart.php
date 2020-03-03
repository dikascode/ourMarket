<?php 

    require_once("config.php"); ?>

<?php 


    
    // echo "<pre>";
    // print_r($_SESSION);
    // echo "</pre>";

?>


<?php

    //Detecting the get request

    if(isset($_GET['add'])){

        $query = query("SELECT * FROM products WHERE product_id= " . escape_string($_GET['add']) . " ");
        confirm($query);

        while($row = fetch_array($query)){

            if($row['product_quantity'] != $_SESSION['product_'. $_GET['add']]){

                $_SESSION['product_' . $_GET['add']] +=1;
                redirect("../public/checkout.php");

            }else{

                set_message("We only have " . $row['product_quantity'] . " " . $row['product_title'] . " available.");
                redirect("../public/checkout.php");

            }
        }

       
    }


    // Decrement condition

    if(isset($_GET['remove'])) {
        $_SESSION['product_' . $_GET['remove']]--;

        if($_SESSION['product_' . $_GET['remove']] < 1) {

            unset($_SESSION['item_quantity']);
            unset($_SESSION['total_price']);
            redirect('../public/checkout.php');
        }else{
            redirect('../public/checkout.php');
        }
    }


    // Delete condition

    if(isset($_GET['delete'])) {

        $_SESSION['product_' . $_GET['delete']] = '0';

        //unset the value

        unset($_SESSION['item_quantity']);
        unset($_SESSION['total_price']);
        
        redirect('../public/checkout.php'); 
    }

    // Cart function

    function cart() {

        if(isset($_SESSION['item_cart'])){
            
            $cart_data = $_SESSION['item_cart'];
        
        }
        

        
        $total = 0;
        $item_quantity = 0;

        $item_name = 1;
        $item_number = 1;
        $amount = 1;
        $quantity = 1;
        $conta = 1;


      if(isset($_SESSION['item_cart']) && $cart_data) {  
          
        foreach ($cart_data as $cart_key => $cart_value) {
            
            if ($cart_value > 0) {


                    $field_val['p_number'] = $cart_value;
                    $value = $_SESSION['item_cart_qty'][$cart_key];


                    //Select product from database
                    $query = query("SELECT * FROM products WHERE product_id =" . escape_string($field_val['p_number']) . " ");
                    confirm($query);
            
                    while($row = fetch_array($query)) {

                        //fetch the image path using the display_image function
                        $product_image = display_image($row['product_image']);

                        //getting the sub-total of the product

                         $sub = $row['product_price'] * $value;
                         $item_quantity += $value;
                        
            
$product = <<<DELIMETER
<tr>
    <td>$conta</td>
    <td class="thumb"><img width="100" src="../resources/$product_image" alt="{$row['product_title']}"></td>
    <td class="details">
        <a href="#">{$row['product_title']}</a>
    </td>
    <td class="price text-center"><strong>&#8358;{$row['product_price']}</strong></td>
    <td class="price text-center">$value</td>
    <td class="total text-center"><strong class="primary-color">&#8358;$sub</strong></td>
    <td>
        <button class="btn btn-sm btn-danger rm-val" data-dataval="{$cart_key}">
            <span><i class="far fa-trash-alt"></i></span>
            <span>Remove</span>
        </button>
    </td>
   
   
</tr>

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

                        $_SESSION['conta'] = $conta;
                        
                        //increase conta by 1
                        $conta++;
                        
                        

                    // }

                    

            }

            
        }

    }else {

        echo "<tr><td col-span='7'><h1 class='text-center'>Cart is Empty</h1></td></tr>";
    }
        
        

    }

//paypal

function show_paypal() {

    if (isset($_SESSION['item_quantity']) && $_SESSION['item_quantity'] >= 1){

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
  
    if (isset($_SESSION['item_quantity']) && $_SESSION['item_quantity'] >= 1 ){

$rave = <<<DELIMETER
<input type="submit" class="primary-btn flutter_btn" style="cursor:pointer;" value="Pay Now" id="submit" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://ravesandboxapi.flutterwave.com/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
<script type="text/javascript">
 
  document.addEventListener("DOMContentLoaded", function(event) {
    document.getElementById('submit').addEventListener('click', function () {
        let cust_email      = document.getElementById('email').value;
        let cust_number     = document.getElementById('tel').value;
        let cust_name       = document.getElementById('fname').value;
        cust_name           += document.getElementById('lname').value;
        let cust_add = document.getElementById('address').value;
    


    var flw_ref = "", chargeResponse = "", trxref = "OURMARKET"+ Math.random(), API_publicKey = "FLWPUBK_TEST-6921d097ab745d1e299bccf98fbc7ac1-X";

    getpaidSetup(
      {
        PBFPubKey: "FLWPUBK_TEST-6921d097ab745d1e299bccf98fbc7ac1-X",
      	customer_email: cust_email,
      	amount: {$_SESSION['total_price']},
        customer_phone: cust_number,
        currency: "NGN",
        cust_name: cust_name,
        address: cust_add,
      	txref: "OURMARKET"+ Math.random(),
      	meta: [{metaname:"flightID", metavalue: "AP1234"}],
        onclose:function(response) {
        },
        callback:function(response) {
          currency = "NGN"
          amount = {$_SESSION['total_price']};
          txref = response.tx.txRef, chargeResponse = response.tx.chargeResponseCode;
          if (chargeResponse == "00" || chargeResponse == "0") {
            window.location = "../public/paymentverification.php?txref="+txref+"&amt="+amount+"&cur="+currency+"&name="+cust_name+"&address="+cust_add; //Add your success page here
          } else {
            window.location = "../public/payverification_fail.php?txref="+txref;  //Add your failure page here
          }
        }
      }
    );
    });
  });
</script>

DELIMETER;

return $rave;

    }
 
}




// Reports
function transaction_verification () {
    //for flutterwave

    if(isset($_SESSION['item_cart'])){
            
        $cart_data = $_SESSION['item_cart'];
    
    }

    if (isset($_GET['txref'])) {
        $ref = $_GET['txref'];
        $amount = $_GET['amt']; //Correct Amount from Server
        $currency = $_GET['cur']; //Correct Currency from Server
        $name = $_GET['name'];
        $address = $_GET['address'];

        $query = array(
            "SECKEY" => "FLWSECK_TEST-43447f6d36fea2e95bef93811139fcb8-X",
            "txref" => $ref
        );

        $data_string = json_encode($query);
                
        $ch = curl_init('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify');                                                                      
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                              
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);

        curl_close($ch);

        $resp = json_decode($response, true);
        

        $paymentStatus = $resp['data']['status'];
        $tnx_ref = $resp['data']['txref'];
        $chargeResponsecode = $resp['data']['chargecode'];
        $chargeAmount = $resp['data']['amount'];
        $chargeCurrency = $resp['data']['currency'];
        $cust_email = $resp['data']['custemail'];
        $cust_number = $resp['data']['custphone'];
        $cust_name = $name;
        $cust_addr = $address;
        $paymentType = $resp['data']['paymenttype'];
        $custIP = $resp['data']['ip'];
        $orderDate = $resp['data']['created'];


        // echo "<pre>";
        // print_r($resp['data']);
        // echo "</pre>";


        //sessions for customer

        $_SESSION['cust_email']     = $cust_email;
        $_SESSION['cust_number']    = $cust_number;
        $_SESSION['cust_name']      = $cust_name;
        $_SESSION['transaction_ref'] = $tnx_ref;
        

        if (($chargeResponsecode == "00" || $chargeResponsecode == "0") && ($chargeAmount == $amount)  && ($chargeCurrency == $currency)) {

            $total = 0;
            $item_quantity = 0;


           // insert into orders table
           $send_order = query("INSERT INTO orders (order_amount, order_transaction, order_status, order_currency, cust_email, cust_number, cust_name, address, payment_type, cust_ip, order_date)
           VALUES('$chargeAmount', '$tnx_ref', '$paymentStatus', '$chargeCurrency', '$cust_email', '$cust_number', '$cust_name', '$cust_addr', '$paymentType', '$custIP', '$orderDate')");

           //Obtain the last inserted id
           $last_id = last_id();

           confirm($send_order);
        
           if(isset($_SESSION['item_cart'])){
            foreach ($cart_data as $cart_key => $cart_value) {

                // $length = strlen($name);
                // $id     = substr($name, 8, $length);
                     
                if ($cart_value > 0) {

                    $field_val['p_number'] = $cart_value;
                    $value = $_SESSION['item_cart_qty'][$cart_key];
        
                        //Select product from database
                        $product_query = query("SELECT * FROM products WHERE product_id =" . escape_string($field_val['p_number']) . " ");
                        confirm($product_query);
                
                        while($row = fetch_array($product_query)) {
        
                            //getting the sub-total of the product
        
                            $sub = $row['product_price'] * $value;
                            $item_quantity += $value;
                            $product_price = $row['product_price'];
                            $product_title = $row['product_title'];
                            $id = escape_string($field_val['p_number']);
                           
                            // insert into reports table
                            $insert_report = query("INSERT INTO reports (product_id, order_id, product_price, product_title, product_quantity, cust_email, cust_number, cust_name, address, order_date, payment_status)
                            VALUES('$id', '$last_id', '$product_price', '$product_title',  '$value', '{$_SESSION['cust_email']}', '{$_SESSION['cust_number']}', '{$_SESSION['cust_name']}', '$cust_addr', '$orderDate', '$paymentStatus') ");
            
                            confirm($insert_report);
                
                           
            
                            //total price n item quantity
                            $total += $sub;
                            $item_quantity;

                        }
            
                        
        
                }
        
                
            }

        }


            //display transaction details

            if($paymentStatus == 'successful') {

                if(isset($_SESSION['item_cart'])){
            
                    $cart_data = $_SESSION['item_cart'];
                
                }
                
        
                
                $total = 0;
                $item_quantity = 0;
        
                $item_name = 1;
                $item_number = 1;
                $amount = 1;
                $quantity = 1;
                $conta = 1;
        
        
              if(isset($_SESSION['item_cart']) && $cart_data) {  
                  
                foreach ($cart_data as $cart_key => $cart_value) {
                    
                    if ($cart_value > 0) {
        
        
                            $field_val['p_number'] = $cart_value;
                            $value = $_SESSION['item_cart_qty'][$cart_key];
        
        
                            //Select product from database
                            $query = query("SELECT * FROM products WHERE product_id =" . escape_string($field_val['p_number']) . " ");
                            confirm($query);
                    
                            while($row = fetch_array($query)) {
        
                                //fetch the image path using the display_image function
                                $product_image = display_image($row['product_image']);
        
                                //getting the sub-total of the product
        
                                 $sub = $row['product_price'] * $value;
                                 $item_quantity += $value;
                                
                    
        $product = <<<DELIMETER
        <tr>
            <td>$conta</td>
            <td class="thumb"><img width="100" src="../resources/$product_image" alt="{$row['product_title']}"></td>
            <td class="details">
                <a href="#">{$row['product_title']}</a>
            </td>
            <td class="price text-center"><strong>&#8358;{$row['product_price']}</strong></td>
            <td class="price text-center">$value</td>
            <td class="total text-center"><strong class="primary-color">&#8358;$sub</strong></td>
            <td class="total text-center"><strong class="primary-color">$paymentStatus</strong></td>
           
           
        </tr>
        
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
        
                                $_SESSION['conta'] = $conta;
                                
                                //increase conta by 1
                                $conta++;
                            
        
                    }
        
                    
                }
        
            }

            }

            session_destroy();

                // unset($_SESSION['item_cart']);
                // unset($_SESSION['item_cart_qty']);
                // unset($_SESSION['total_price']);
    
        } else {
            //Dont Give Value and return to Failure page

            redirect("../public/payverification_fail.php");
        }
    }

}


function process_transaction() {
        //for paypal

    // Obtain the payment GET details from the url

    if(isset($_GET['tx'])){
        $amount =  $_GET['amt'];
        $currency = $_GET['cc'];
        $transaction = $_GET['tx'];
        $status = $_GET['st'];

         $total = 0;
         $item_quantity = 0;
     
         foreach ($_SESSION as $name => $value) {
                  
             if ($value > 0) {
     
                 // Getting the substring of the session amd comparing to get the product id
                 if (substr($name, 0, 8) == "product_") {
     
                     $length = strlen($name);
                     $id = substr($name, 8, $length);

                    // insert into orders table
                    $send_order = query("INSERT INTO orders (order_amount, order_transaction, order_status, order_currency)
                    VALUES('$amount', '$transaction', '$status', '$currency')");

                    //Obtain the last inserted id
                    $last_id = last_id();

                    confirm($send_order);
     
     
                     //Select product from database
                     $query = query("SELECT * FROM products WHERE product_id =" . escape_string($id) . " ");
                     confirm($query);
             
                     while($row = fetch_array($query)) {
     
                         //getting the sub-total of the product
     
                         $sub = $row['product_price'] * $value;
                         $item_quantity += $value;
                         $product_price = $row['product_price'];
                         $product_title = $row['product_title'];
                        
                         // insert into reports table
                         $insert_report = query("INSERT INTO reports (product_id, order_id, product_price, product_title, product_quantity)
                         VALUES('$id', '$last_id', '$product_price', '$product_title',  '$value')");
         
                         confirm($insert_report);
             
                        
         
                         //total price n item quantity
                         $total += $sub;
                         $item_quantity;
                     }
         
                     }
     
             }
     
             
         }
 
        
 
        //session_destroy();

     }else{
         redirect("index.php");
     }



   

}


//shopping cart list
function shopping_cart_list() {

    if(isset($_SESSION['item_cart'])){
        
        $cart_data = $_SESSION['item_cart'];

    }
    

    
    $total = 0;
    $item_quantity = 0;



  if(isset($_SESSION['item_cart']) && $cart_data) {  
      
    foreach ($cart_data as $cart_key => $cart_value) {
        
        if ($cart_value > 0) {
            

            // Getting the substring of the session amd comparing to get the product id


                $field_val['p_number'] = $cart_value;
                $value = $_SESSION['item_cart_qty'][$cart_key];


                //Select product from database
                $query = query("SELECT * FROM products WHERE product_id =" . escape_string($field_val['p_number']) . " ");
                confirm($query);
        
                while($row = fetch_array($query)) {

                    //fetch the image path using the display_image function
                    $product_image = display_image($row['product_image']);

                    //getting the sub-total of the product

                     $sub = $row['product_price'] * $value;
                     $item_quantity += $value;
                    
        
$product = <<<DELIMETER
<div class="product product-widget">
    <div class="product-thumb">
        <img src="../resources/{$product_image}" alt="">
    </div>
    <div class="product-body">
        <h3 class="product-price">&#8358; {$row['product_price']} <span class="qty">x{$value}</span></h3>
        <h2 class="product-name"><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a></h2>
    </div>
    <button class="cancel-btn"><i class="fa fa-trash"></i></button>
</div>

DELIMETER;

echo $product;


                    
                }

                
                

        }

        
    }

}else {

    echo "<h3 class='text-center'>Cart is Empty</h3>";
}
    
    

}


?>