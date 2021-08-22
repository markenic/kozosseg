<?php
  session_name("kozossegLogin");
    session_start();
    include("conn.php");
    include("isAdmin.php");
    if(isset($_SESSION['user'])){
        if($_SESSION['user']['admin']==1){
            if(isset($_POST["id"],$_POST["value"])){
                $value = trim($_POST["value"]);
                $id = trim($_POST["id"]);        
                $stmt = $conn->prepare("UPDATE user SET isAdmin=? WHERE id=?");     
                $stmt->bind_param("si", $value, $id);
                if ($stmt->execute()) { 
                    echo(json_encode(["success" => true,"response" => "",]));
                    $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                    "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                    $_SESSION["user"]["userName"]." gave Admin to ID: ".$id.PHP_EOL.
                    "-------------------------".PHP_EOL;
                    file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                }else{
                    echo(json_encode(["success" => false,"response" => $stmt->error,]));
                    $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                    "User: ".$_SESSION["user"]["userName"].PHP_EOL.
                    "error when you tried to give admin to ".$id." - ".$stmt->error.PHP_EOL.
                    "-------------------------".PHP_EOL;
                    file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
                }
            }
        }else{
            echo(json_encode(["success" => false,"response" => "notAdmin",]));
            $log = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "User: ".$_SESSION["user"]["userName"].PHP_EOL.
            "error when you tried to give admin to ".$id." - You don't have admin".PHP_EOL.
            "-------------------------".PHP_EOL;
            file_put_contents('../logs/other_'.date("j.n.Y").'.log', $log, FILE_APPEND);
        }

    }
?>
