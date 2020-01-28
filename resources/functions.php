<?php

//upload directory
$upload_directory = "uploads";

// Helper fucntions


function last_id () {
    global $connection;
    return mysqli_insert_id($connection);
}

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

    $product_image = display_image ($row['product_image']);

        // heredoc
    $product = <<<DELIMETER

<div class="col-sm-4 col-lg-4 col-md-4">
<div class="thumbnail">
<a href="item.php?id={$row['product_id']}"><img src="../resources/$product_image" alt=""></a>
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

        $product_image = display_image ($row['product_image']);
        // heredoc
    $category_links = <<<DELIMETER
    <div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img width="100" src="../resources/{$product_image}" alt="{row['product_title']}">
        <div class="caption">
            <h4>{$row['product_title']}</h4>
            <p>{$row['short_desc']}</p>
            <p>
                <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
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

        $product_image = display_image($row['product_image']);
       
        // heredoc
    $category_links = <<<DELIMETER
    <div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img src="../resources/{$product_image}" alt="{$row['product_title']}">
        <div class="caption">
            <h4>{$row['product_title']}</h4>
            <p>{$row['short_desc']}</p>
            <p>
                <a href="../resources/cart.php?add={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?id={$row['product_id']}" class="btn btn-default">More Info</a>
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


//Email function for contact us page

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





/********************************** BACK END FUNCTIONS ****************************************** */

// Admin orders
function display_orders () {

    $query = query("SELECT * FROM orders");
    confirm($query);


    while($row = fetch_array($query)) {
       
        // heredoc
    $orders = <<<DELIMETER
    <tr>
        <td>{$row['order_id']}</td>
        <td>{$row['order_amount']}</td>
        <td>{$row['order_transaction']}</td>
        <td>{$row['order_currency']}</td>
        <td>Order Date</td>
        <td>{$row['order_status']}</td>
        <td><a class="btn btn-danger" href="../../resources/templates/back/delete_order.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
DELIMETER;

echo $orders;

    }

}




// Admin products

function display_image ($picture) {
    global $upload_directory;
    return $upload_directory . DS . $picture;
}

 function get_products_in_admin() {

    $query = query("SELECT * FROM products");
    confirm($query);

    while($row = fetch_array($query)) {

    $category_title =  show_product_category_title ($row['product_category_id']);

    $product_image = display_image ($row['product_image']);

        // heredoc
    $product = <<<DELIMETER

<tr>
    <td>{$row['product_id']}</td>
    <td>{$row['product_title']}<br>
        <a href="index.php?edit_product&id={$row['product_id']}"><img width="100px" src="../../resources/{$product_image}" alt="Image {$row['product_title']}"></a>
    </td>
    <td>$category_title</td>
    <td>&#8358;{$row['product_price']}</td>
    <td>{$row['product_quantity']}</td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
   


</tr>

DELIMETER;

    Echo $product;
     
    }

}





// Adding product in Admin

function add_product () {

    if (isset($_POST['publish'])) {
        $product_title          = escape_string($_POST['product_title']);
        $product_cat_id         = escape_string($_POST['product_category_id']);
        $product_price          = escape_string($_POST['product_price']);
        $product_quantity       = escape_string($_POST['product_quantity']);
        $product_desc           = escape_string($_POST['product_desc']);
        $short_desc             = escape_string($_POST['short_desc']);
        $product_image          = escape_string($_FILES['file']['name']);
        $image_temp_location    = $_FILES['file']['tmp_name'];


        // UPLOAD_FOLDER . DS . $product_image

        move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_DIR . DS . $product_image);
    

        $query = query("INSERT INTO products(product_title, product_category_id, product_price, 
                        product_quantity, product_desc, short_desc, product_image) VALUES('$product_title',
                        '$product_cat_id', '$product_price', '$product_quantity', '$product_desc', '$short_desc',
                        '$product_image' )");
        $last_id = last_id();

        confirm($query);
        set_message("New Product with ID {$last_id} was Successfully Added");
        redirect("index.php?products");

    }

}


function get_categories_add_product_page(){

    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)) {
       
        // heredoc
    $category_options = <<<DELIMETER
    <option value="{$row['cat_id']}">{$row['cat_title']}</option>
DELIMETER;

echo $category_options;

    }

}


    // Fetching category title with passing id as parameter

function show_product_category_title ($product_category_id) {

    $category_query = query("SELECT * FROM categories WHERE cat_id = {$product_category_id}");
    confirm($category_query);

    while($category_row = fetch_array($category_query)) {
        return $category_row['cat_title'];
    }
}


// Edit function for products in admin page

function update_product () {

    if (isset($_POST['update'])) {
        $product_title          = escape_string($_POST['product_title']);
        $product_cat_id         = escape_string($_POST['product_category_id']);
        $product_price          = escape_string($_POST['product_price']);
        $product_quantity       = escape_string($_POST['product_quantity']);
        $product_desc           = escape_string($_POST['product_desc']);
        $short_desc             = escape_string($_POST['short_desc']);
        $product_image          = escape_string($_FILES['file']['name']);
        $image_temp_location    = $_FILES['file']['tmp_name'];

        if (empty($product_image)) {
            $get_pic = query("SELECT product_image FROM products WHERE product_id =" . escape_string($_GET['id']) ."");
            confirm($get_pic);

            while($pic = fetch_array($get_pic)) {

                $product_image = $pic['product_image'];
            }


        }


        move_uploaded_file($_FILES['file']['tmp_name'], UPLOAD_DIR . DS . $product_image);
    
        // Update product query

        $query  = "UPDATE products SET ";
        $query .= "product_title                = '{$product_title}'    , ";
        $query .= "product_category_id          = '{$product_cat_id }'  , ";
        $query .= "product_price                = '{$product_price}'    , ";
        $query .= "product_quantity             = '{$product_quantity}' , ";
        $query .= "product_desc                 = '{$product_desc}'     , ";
        $query .= "short_desc                   = '{$short_desc}'       , ";
        $query .= "product_image                = '{$product_image}'     ";
        $query .= "WHERE product_id =" . escape_string($_GET['id']);
        
        $send_update_query = query($query);
        confirm($send_update_query);
        set_message("Product Updated Successfully");
        redirect("index.php?products");

    }

}



// categories in admin

    // Show categories function

function show_categories_in_admin () {

    $query = query("SELECT * FROM categories");
    confirm($query);

    while ($row = fetch_array($query)) {

        $cat_id     = $row['cat_id'];
        $cat_title  = $row['cat_title'];

$category = <<<DELIMETER

<tr>
    <td>{$row['cat_id']}</td>
    <td>{$row['cat_title']}</td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_category.php?id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>

DELIMETER;

echo $category;

    }

}

    // Create categories in admin

    function add_category () {

        if (isset($_POST['add_category'])) {

            $cat_title = escape_string($_POST['cat_title']);

            if (empty($cat_title) || $cat_title == " ") {

                echo "<h3 class='bg-danger'>Category Title is Required</h3>";

            } else {

                $query = query("INSERT INTO categories(cat_title) VALUES('$cat_title')");

                confirm($query);
                $last_id = last_id();
                $category_title = show_product_category_title($last_id);
                set_message($category_title . " Category Created");
                redirect("index.php?categories");


            }
         
        }
    }



    // Admin Users

    function display_users () {

        $query = query("SELECT * FROM users");
        confirm($query);
    
        while ($row = fetch_array($query)) {
    
            $user_id     = $row['user_id'];
            $username  = $row['username'];
            $email  = $row['email'];
            $password  = $row['password'];
    
    $user = <<<DELIMETER
    
    <tr>
        <td>{$user_id}</td>
        <td>{$username}</td>
        <td>{$email}</td>
        <td><a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$user_id}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
    
    DELIMETER;
    
    echo $user;
    
        }
    
    }



    function add_user() {

        if (isset($_POST['add_user'])) {
            $username       = escape_string($_POST['username']);
            $email          = escape_string($_POST['email']);
            $password       = escape_string($_POST['password']);
            $user_photo     = escape_string($_FILES['file']['name']);
            $photo_temp     = $_FILES['file']['tmp_name'];

            move_uploaded_file($photo_temp, UPLOAD_DIR . DS . $user_photo);

            $query = query("INSERT INTO users(username, email, password) VALUES('$username', '$email', '$password')");
            
            confirm($query);

            set_message("User Created");

            redirect("index.php?users");
        }
    }

?>