<?php
session_name("kozossegLogin");
session_start();
unset($_SESSION['user']);
setcookie(session_name(),'',0,'/');
session_regenerate_id(true);
header("Location: helyszin.php");
?>