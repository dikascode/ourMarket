<?php

    require_once("../../resources/config.php");


    if(isset($_GET['delete_slide_id'])) {

        $get_slide_title_query = query("SELECT slide_image FROM slides WHERE slide_id=" . escape_string($_GET['delete_slide_id'])  ." LIMIT 1 ");
        confirm($get_slide_title_query);

        $row = fetch_array($get_slide_title_query);
        $target_path = UPLOAD_DIR . DS . $row['slide_image'];

        unlink($target_path);
        
        $query = query("DELETE FROM slides WHERE slide_id =" . escape_string($_GET['delete_slide_id']) ."");
        confirm($query);


        set_message("Slide Deleted");
        redirect("index.php?slides");


    }else {
        set_message("No Slide Deleted");
        redirect("index.php?slides");

    }

?>