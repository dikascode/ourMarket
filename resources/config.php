<?php

ob_start();
if(!isset($_SESSION)){
    session_start();
}
// session_destroy();
//define paths and database connections with constants

defined ("DS") ? null : define ("DS", DIRECTORY_SEPARATOR);

defined ("TEMPLATE_FRONT") ? null : define ("TEMPLATE_FRONT", __DIR__ . DS . "templates/front");

defined ("TEMPLATE_BACK") ? null : define ("TEMPLATE_BACK", __DIR__ . DS . "templates/back");

defined ("UPLOAD_DIR") ? null : define ("UPLOAD_DIR", __DIR__ . DS . "uploads");

//constants for database connections

defined ("DB_HOST") ? null : define ("DB_HOST", "us-cdbr-iron-east-04.cleardb.net");

defined ("DB_USER") ? null : define ("DB_USER", "b7cdc74acdf7a5");

defined ("DB_PASS") ? null : define ("DB_PASS", "b31dd65a");

defined ("DB_NAME") ? null : define ("DB_NAME", "heroku_3297a7a3117dadf");



//creating the connection
 $connection = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);

require_once("functions.php");
require_once("cart.php");

?>
