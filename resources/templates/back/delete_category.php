<?php

    require_once("../../config.php");


    if(isset($_GET['id'])) {
        $category_title = show_product_category_title($_GET['id']);
        $query = query("DELETE FROM categories WHERE cat_id =" . escape_string($_GET['id']) ."");
        confirm($query);
        
        set_message($category_title . " Category Deleted");
        redirect("../../../public/admin/index.php?categories");


    }else {
        set_message("No Category Deleted");
        redirect("../../../public/admin/index.php?categories");

    }

?>