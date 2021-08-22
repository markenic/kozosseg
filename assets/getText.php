<?php
  session_start();
    include("hu.php");
    if(isset($_POST["get"])){
      echo(json_encode(["success" => true,"response" => $lang,]));
    }

?>