<?php

//upload directory
$upload_directory = "uploads";

/*****Helper fucntions****/


    //crsf function for form protection

function form_protect () {
    //create a key for hash_hmac function

    if (empty($_SESSION['key'])) 
        $_SESSION['key'] = bin2hex(random_bytes(32));

    //create CRSF token

    return $crsf = hash_hmac('sha256', 'This is our market web app', $_SESSION['key'], false);
    
    
}


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

//cart function

function cart_count () {
    //global $cart_data;

    if (isset($_SESSION['conta'])) {
        $cart_data = $_SESSION['conta'];

        return $cart_data;

        
    }
}


// get products fucntions

function get_products() {
    $query = query("SELECT * FROM products");
    confirm($query);

    //pagination setup
    $number_rows = mysqli_num_rows($query);

    if (isset($_GET['page'])) {

        //replacing non numbers with empty string using regular expressions

        $page = preg_replace('#[^0-9]#', '', $_GET['page'] );

    } else {
        $page = 1;
    }


    //number of items per page
    $perPage = 8;

    $lastPage = ceil($number_rows/$perPage);

    if ($page < 1) {
        $page = 1;
    } elseif ($page > $lastPage) {

        $page = $lastPage;

    }


    //setting middle numbers for pagination clicks

    $middleNumbers = '';

    $sub1 = $page  - 1;
    $sub2 =  $page - 2;
    $add1 =  $page + 1;
    $add2 = $page  + 2;

    if ($page == 1) {

        $middleNumbers .= '<li class="page-item active"><a>'.$page.'</a><li>';
        $middleNumbers .= '<li class="page-item"><a class="page_link" href=" '
                            .$_SERVER['PHP_SELF'].'?page='.$add1.' ">' .$add1. '</a><li>';

    } elseif($page == $lastPage) {

        $middleNumbers .= '<li class="page-item"><a class="page_link" href=" '
                            .$_SERVER['PHP_SELF'].'?page='.$sub1.' ">' .$sub1. '</a><li>';
        $middleNumbers .= '<li class="page-item active"><a>'.$page.'</a><li>';

    } elseif($page > 2 && $page < ($lastPage - 1)) {

        $middleNumbers .= '<li class="page-item"><a class="page_link" href=" '
                            .$_SERVER['PHP_SELF'].'?page='.$sub2.' ">' .$sub2. '</a><li>';

        $middleNumbers .= '<li class="page-item"><a class="page_link" href=" '
                            .$_SERVER['PHP_SELF'].'?page='.$sub1.' ">' .$sub1. '</a><li>';

        $middleNumbers .= '<li class="page-item active"><a>'.$page.'</a><li>';

        $middleNumbers .= '<li class="page-item"><a class="page_link" href=" '
                            .$_SERVER['PHP_SELF'].'?page='.$add1.' ">' .$add1. '</a><li>';

        $middleNumbers .= '<li class="page-item"><a class="page_link" href=" '
                            .$_SERVER['PHP_SELF'].'?page='.$add2.' ">' .$add2. '</a><li>';

    }elseif ($page > 1 && $page < $lastPage) {

        $middleNumbers .= '<li class="page-item"><a class="page_link" href=" '
                            .$_SERVER['PHP_SELF'].'?page='.$sub1.' ">' .$sub1. '</a><li>';

        $middleNumbers .= '<li class="page-item active"><a>'.$page.'</a><li>';

        $middleNumbers .= '<li class="page-item"><a class="page_link" href=" '
                            .$_SERVER['PHP_SELF'].'?page='.$add1.' ">' .$add1. '</a><li>';


    }

    //creating the limit variable to use in the query


    $limit = 'LIMIT ' . ($page-1) * $perPage . ',' . $perPage;


    $query2 = query("SELECT * FROM products {$limit}");
    confirm($query2);
   
    $outputPagination = "";

    //Setting prev and next button

    if ($lastPage != 1 && $page != 1) {
        $prev = $page-1;

        $outputPagination .= '<li class="page-item"><a class="page_link" href=" '
        .$_SERVER['PHP_SELF'].'?page='.$prev.' ">Back</a><li>';
    }

    $outputPagination .= $middleNumbers;

    if ($page != $lastPage) {
        $next = $page + 1;
        $outputPagination .= '<li class="page-item"><a class="page_link" href=" '
        .$_SERVER['PHP_SELF'].'?page='.$next.' ">Next</a><li>';
    }


    

    while($row = fetch_array($query2)) {

    $product_image = display_image ($row['product_image']);

        // heredoc
    $product = <<<DELIMETER

<div class="col-sm-3 col-lg-3 col-md-3">
<div class="thumbnail">
<a href="item.php?id={$row['product_id']}"><img style="height:170px;" src="../resources/$product_image" alt=""></a>
<div class="caption">
<h4 class="pull-right">&#8358;{$row['product_price']}</h4>
<h4><a href="item.php?id={$row['product_id']}">{$row['product_title']}</a>
</h4>
<p>{$row['short_desc']}</p>
<a class="btn btn-primary cartLink" target="_blank" rel="noopener" href="../resources/cart.php?add={$row['product_id']}">Add to Cart</a>
</div>

</div>
</div>

DELIMETER;

echo $product;

// target="_blank" href="../resources/cart.php?add={$row['product_id']}"

// <form method="post" class="submit_pro">
// <button type="submit" class="btn btn-sm bg-primary pc_data" data-dataid="{$row['product_id']}">Add to Cart</button>
// </form>

    
    }

    //pagination echo line

    echo "<div style='clear:both;' class='text-center'><ul class='pagination'>{$outputPagination}</ul></div>";

}




// Function to list all categories

function get_categories(){

    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)) {
       
        // heredoc
    $category_links = <<<DELIMETER
<li><a href='category.php?id={$row['cat_id']}'>{$row['cat_title']}</a><li>
DELIMETER;

echo $category_links;

    }

}


//get category selection on index page

function get_cat_select() {
    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)) {
        $cat_options = <<<DELIMETER
        <option value="{$row['cat_id']}">{$row['cat_title']}</option>

        DELIMETER;

        echo $cat_options;
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
        <img style="height:170px;" src="../resources/{$product_image}" alt="{row['product_title']}">
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
    
    $crsf = form_protect();
        //validate crsf token
    if (hash_equals($crsf, $_POST['crsf'])) {
         $username = escape_string($_POST['username']);
         $password = escape_string(sha1($_POST['password']));

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

        }else{
            echo "<p class='bg-danger'>CRSF Token failed</p>";
        }
    

}


}


//Email function for contact us page

function send_message(){

    $crsf = form_protect();

    if(isset($_POST['submit'])){

        if (hash_equals($crsf, $_POST['crsf'])) {

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

        } else {
            echo "<p class='bg-danger'>CRSF Token Failed</p>";
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
        <td>&#x20a6;{$row['order_amount']}</td>
        <td>{$row['order_transaction']}</td>
        <td>{$row['order_currency']}</td>
        <td>Order Date</td>
        <td>{$row['order_status']}</td>
        <td><a class="btn btn-danger" href="index.php?delete_order_id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
    </tr>
DELIMETER;

echo $orders;

    }

}



function display_index_orders () {

    $query = query("SELECT * FROM orders ORDER BY order_id DESC LIMIT 20");
    confirm($query);

    
    $conta = 1;

    while($row = fetch_array($query)) {
       
        // heredoc
    $orders = <<<DELIMETER
    <tr>
        <td>$conta</td>
        <td>{$row['order_id']}</td>
        <td>Order Date</td>
        <td>Order Time</td>
        <td>&#x20a6;{$row['order_amount']}</td>
        <td>{$row['order_transaction']}</td>
        <td>{$row['order_currency']}</td>
        <td>Payment Type</td>
        <td>{$row['order_status']}</td>
    </tr>
DELIMETER;

echo $orders;
    $_SESSION['order_conta'] = $conta;
    $conta++;
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
    
    $crsf = form_protect();

    if (isset($_POST['publish'])) {

            //validate crsf token
    if (hash_equals($crsf, $_POST['crsf'])) {
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
    }else {
        echo "<p class='bg-danger'>CRSF Token Failed</p>";
    }
       

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

    $crsf = form_protect();

    if (isset($_POST['update'])) {

            //validate crsf token
    if (hash_equals($crsf, $_POST['crsf'])) {

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

    }else {
        echo "<p class='bg-danger'>CRSF Token Failed</p>";
    }

        

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

            $crsf = form_protect();

                //validate crsf token
            if (hash_equals($crsf, $_POST['crsf'])) {

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
            }else {
                echo "<p class='bg-danger'>CRSF Token Failed</p>";
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

            $crsf = form_protect();

        //validate crsf token
        if (hash_equals($crsf, $_POST['crsf'])) {

            $username       = escape_string($_POST['username']);
            $email          = escape_string($_POST['email']);
            $password       = escape_string(sha1($_POST['password']));
            $user_photo     = escape_string($_FILES['file']['name']);
            $photo_temp     = $_FILES['file']['tmp_name'];

            move_uploaded_file($photo_temp, UPLOAD_DIR . DS . $user_photo);

            $query = query("INSERT INTO users(username, email, password) VALUES('$username', '$email', '$password')");
            
            confirm($query);

            set_message("User Created");

            redirect("index.php?users");

        }else {
            echo "<p class='bg-danger'>CRSF Token Failed</p>";
        }
            
        }
    }




    /************** Reports Page in Admin ****************** */

    function get_reports() {

        $query = query("SELECT * FROM reports");
        confirm($query);
    
        while($row = fetch_array($query)) {
    
        
    
            // heredoc
        $report = <<<DELIMETER
    
    <tr>
        <td>{$row['report_id']}</td>
        <td>{$row['product_id']}</td>
        <td>{$row['order_id']}</td>
        <td>&#8358;{$row['product_price']}</td>
        <td>{$row['product_title']}</td>
        <td>{$row['product_quantity']}</td>
        <td><a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
       
    
    
    </tr>
    
    DELIMETER;
    
        Echo $report;
         
        }
    
    }




    /**************** GLide Functions ****************** */

    function add_slides () {

        if(isset($_POST['add_slide'])) {

            $crsf = form_protect();

                //validate crsf token
         if (hash_equals($crsf, $_POST['crsf'])) {
             
            $slide_title          = escape_string($_POST['slide_title']);
            $slide_image          = escape_string($_FILES['file']['name']);
            $slide_image_loc      = $_FILES['file']['tmp_name'];


            if(empty($slide_title) || empty($slide_image)) {
                echo "<p class='bg-danger'>This field is require</p>";
            } else {
                move_uploaded_file($slide_image_loc, UPLOAD_DIR . DS . $slide_image);

                $query = query("INSERT INTO slides(slide_title, slide_image) VALUES('$slide_title', '$slide_image')");

                confirm($query);
                set_message('Slide Added');

                redirect('index.php?slides');
            }

         }else{

             echo "<p class='bg-danger'>CRSF Token Failed</p>";
             
         }

        }


    }

    function get_current_slide_in_admin () {

        $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
        confirm($query);

        while ($row = fetch_array($query)) {

            $slide_image = display_image ($row['slide_image']);

$slide_active_admin = <<<DELIMETER

<img class="img-responsive"  src="../../resources/$slide_image" alt="{$row['slide_title']}">


DELIMETER;

        echo $slide_active_admin;

        }

    }


    function get_active_slide () {

        $query = query("SELECT * FROM slides ORDER BY slide_id DESC LIMIT 1");
        confirm($query);

        while ($row = fetch_array($query)) {

            $slide_image = display_image ($row['slide_image']);

$slide_active = <<<DELIMETER

<div class="item active">
<img class="slide-image"  src="../resources/$slide_image" alt="{$row['slide_title']}">
</div>

DELIMETER;

        echo $slide_active;

        }

    }



    function get_slides () {

        $query = query("SELECT * FROM slides");
        confirm($query);

        while ($row = fetch_array($query)) {

            $slide_image = display_image ($row['slide_image']);

$slides = <<<DELIMETER

<div class="item">
<img class="slide-image"  src="../resources/$slide_image" alt="{$row['slide_title']}">
</div>


DELIMETER;

        echo $slides;

        }

    }


    function get_slide_thumbnails () {

        $query = query("SELECT * FROM slides ORDER BY slide_id ASC");
        confirm($query);

        while ($row = fetch_array($query)) {

            $slide_image = display_image ($row['slide_image']);

$slide_thumb_admin = <<<DELIMETER

<div class="col-xs-6 col-md-3" style="margin-bottom: 10px;">
    <h4 class="text-primary">{$row['slide_title']}</h4>
    <img style="height:100px;" class="img-responsive" src="../../resources/$slide_image" alt="{$row['slide_title']}">
    <a class="btn btn-danger slide_image_container" title="Delete Slide" href="index.php?delete_slide_id={$row['slide_id']}"><span class="glyphicon glyphicon-remove"></span></a>
    

  </div>


DELIMETER;

        echo $slide_thumb_admin;

        }

    }


    // New collection functions

    function get_new_collections () {

        $query = query("SELECT * FROM products ORDER BY product_id%2=0 DESC LIMIT 3");
        confirm($query);

        while ($row = fetch_array($query)) {

            $slide_image = display_image ($row['product_image']);

$slides = <<<DELIMETER

<div class="col-md-4 col-md-offset-0 col-sm-6 col-sm-offset-3">
    <a class="banner banner-1" href="item.php?id={$row['product_id']}">
        <img src="../resources/$slide_image" alt="{$row['product_title']}">
        <div class="banner-caption text-center">
            <h2 class="white-color">NEW COLLECTION</h2>
            <h4 class="primary-btn">{$row['product_title']}</h4>
        </div>
    </a>
</div>


DELIMETER;

        echo $slides;

        }

    }

?>