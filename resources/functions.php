<?php

// Helper fucntions

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
function escape_string ($string){
    global $connection;

    return mysqli_real_escape_string($connection, $string);
}


function fetch_array($result){
    return mysqli_fetch_array($result);
}


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
<h4><a href="product.html">{$row['product_title']}</a>
</h4>
<p>{$row['product_desc']}</p>

<a class="btn btn-primary" target="_blank" href="">Add to Cart</a>
</div>

</div>
</div>

DELIMETER;

    Echo $product;
    }

}


function get_categories(){

    $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)) {
       
        // heredoc
    $product = <<<DELIMETER
    
    DELIMETER;

    }

}


?>