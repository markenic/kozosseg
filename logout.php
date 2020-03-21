<?php
session_start();
unset($_SESSION["user"]);
header("Location: helyszin.php");
?>