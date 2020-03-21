<?php
    session_start();
    include("conn.php");
    if(isset($_POST["wData"])){
        if($_POST["wData"]=="places"){
            $sql = "SELECT * FROM places";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $arr = Array();
                while($row=$result->fetch_assoc()){
                    array_push($arr,$row);
                }
                echo(json_encode($arr));
        
            } else {
            echo "empty";
            }
        }else if($_POST["wData"]=="categories"){
            $sql = "SELECT * FROM categories";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $arr = Array();
                while($row=$result->fetch_assoc()){
                    array_push($arr,$row);
                }
                echo(json_encode($arr));
        
            } else {
            echo "empty";
            }
        }

    }


?>
