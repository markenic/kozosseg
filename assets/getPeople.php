<?php
    if(isset($_POST["session"]) and $_POST["session"]==true){session_start();} 
    include("conn.php");
    if(isset($_SESSION["user"])){
        $sql = "SELECT id,name,email,isAdmin,place1,place2,place3 FROM user";
        $result = $conn->query($sql);
        if(isset($result->num_rows)){
            if ($result->num_rows > 0) {
                $arr = Array();
                while($row=$result->fetch_assoc()){
                    array_push($arr,$row);
                }
                echo(json_encode(["success" => true,"response" => $arr,]));
        
            }
        }else{
            echo(json_encode(["success" => false,"response" => $conn->error,]));
        }

    }
?>