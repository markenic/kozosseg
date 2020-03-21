<?php
    session_start();
    include("conn.php");
    include("isAdmin.php");
    if(isset($_SESSION['user'])){
        if($isAdmin==1){
            if(isset($_POST["id"],$_POST["value"])){
                $sql = "UPDATE user SET isAdmin = ".$_POST["value"]." WHERE id = ".$_POST['id'];
                if ($conn->query($sql) === TRUE) {           
                    echo(json_encode(["success" => true,"response" => "",]));

                } else {
                    echo(json_encode(["success" => false,"response" => $sql."\n".$conn->error,]));
                }
            }
        }else{
            echo(json_encode(["success" => false,"response" => "notAdmin",]));
        }

    }

?>