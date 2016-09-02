<?php
$email= @$_REQUEST['email'];
$message= @$_REQUEST['message'];
$to= @$_REQUEST['to'];
$from= @$_REQUEST['from'];
$subject= @$_REQUEST['subject'];
$body= @$_REQUEST['body'];
$body .='Email: '.$email.' Message: '.$message;
$sub_msg= @$_REQUEST['sub_msg'];
mail($to,$subject,$body);
echo $sub_msg;
?>
