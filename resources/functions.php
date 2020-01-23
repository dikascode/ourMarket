<?php

// Helper fucntions

function set_message($msg){
    if(!empty($msg)){
    $_SESSION['message'] = $msg;
}else{
    $msg = "";
}

}


function display_message(){
    if(isset($_SESSION['message'])){

        echo $_SESSION['message'];
        unset ($_SESSION['message']);

    }
}

function redirect($location) {
    header("Location: $location");
}

function query($sql){
    global $connection;

    return mysqli_query($connection, $sql);
}

//confirm connection or show the error message
function confirm($result){
    global $connection;
    
    if(!$result){
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

//escape string helper function
function escape_string($string){
    global $connection;

    return mysqli_real_escape_string($connection, $string);
}


function fetch_array($result){
    return mysqli_fetch_array($result);
}


/********************************** FRONT END FUNCTIONS ****************************************** */


// get products fucntions

function get_products() {
    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)) {

        // heredoc
    $product = <<<DELIMETER

<div class="col-sm-4 col-lg-4 col-md-4">
<div class="thumbnail">
<a href="item.php?id={$row['product_id']}"><img src="{$row['product_image']}" alt=""></a>
<div class="caption">
<h4 class="pull-right">&#8358;{$row['product_price']}</h4>
<h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
</h4>
<p>{$row['short_desc']}</p>

<a class="btn btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add to Cart</a>
</div>

</div>
</div>

DELIMETER;

    Echo $product;
    }

}

// Function to list all categories

function get_categories(){

    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)) {
       
        // heredoc
    $category_links = <<<DELIMETER
<a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
DELIMETER;

echo $category_links;

    }

}


// Function to get category products

function get_category_products(){

    $query = query("SELECT * FROM products WHERE product_category_id = ". escape_string($_GET['id']) . " ");
    confirm($query);

    while($row = fetch_array($query)) {
       
        // heredoc
    $category_links = <<<DELIMETER
    <div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img src="{$row['product_image']}" alt="">
        <div class="caption">
            <h4>{$row['product_title']}</h4>
            <p>{$row['short_desc']}</p>
            <p>
                <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
            </p>
        </div>
    </div>
</div>
DELIMETER;

echo $category_links;

    }

}




function get_products_in_shop_page(){

    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)) {
       
        // heredoc
    $category_links = <<<DELIMETER
    <div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img src="{$row['product_image']}" alt="">
        <div class="caption">
            <h4>{$row['product_title']}</h4>
            <p>{$row['short_desc']}</p>
            <p>
                <a href="#" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
            </p>
        </div>
    </div>
</div>
DELIMETER;

echo $category_links;

    }

}

// function for user login
function login_user(){

if(isset($_POST['submit'])){
    $username = escape_string($_POST['username']);
    $password = escape_string($_POST['password']);

$query = query("SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' ");

confirm($query);

if(mysqli_num_rows($query) === 0){
    set_message('Your Username or Password is wrong');
    redirect("login.php");
}else{
    $_SESSION['username'] = $username;
    // set_message('Welcome to Admin {$username}');
    redirect("admin");
}


}


}



function send_message(){

    if(isset($_POST['submit'])){
        
        $to   = "dikaemanuel@gmail.com";
        $name = $_POST['name'];
        $subject = $_POST['subject'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        // To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$email."\r\n".
    'Reply-To: '.$email."\r\n" .
    'X-Mailer: PHP/' . phpversion();

    $result =  mail($to, $subject, $message, $headers);

    

    if(!$result){
       set_message("Sorry we could not send your message");
       redirect("contact.php");
    }else{
        set_message("Your messsage has been sent");
        redirect("contact.php");
    }

 
    
    }     
}


?>