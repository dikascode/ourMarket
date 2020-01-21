<?php
//the subject
$sub = "Just a test";
//the message
$msg = "Testing if my php mail works";
//recipient email here
$rec = "dikaemanuel@gmail.com";
//send email
mail($rec,$sub,$msg);
?>