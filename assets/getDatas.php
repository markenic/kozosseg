<?php
  session_name("kozossegLogin");
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
                echo(json_encode(["success" => true,"response" => $arr,]));
                
            } else {
                echo(json_encode(["success" => false,"response" => "empty",]));
            }
        }else if($_POST["wData"]=="categories"){
            $sql = "SELECT * FROM categories";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $arr2 = Array();
                while($row=$result->fetch_assoc()){
                    array_push($arr2,$row);
                }
                echo(json_encode(["success" => true,"response" => $arr2,]));
            } else {
                echo(json_encode(["success" => false,"response" => "empty",]));
            }
        }else if($_POST['wData']=='teachers'){
            $sql = "SELECT * FROM teachers";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $arr2 = Array();
                while($row=$result->fetch_assoc()){
                    array_push($arr2,$row);
                }
                echo(json_encode(["success" => true,"response" => $arr2,]));
            } else {
                echo(json_encode(["success" => false,"response" => "empty",]));
            }          
        
        }else if($_POST["wData"]=="classes"){
            $sql = "SELECT * FROM classes";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $arr2 = Array();
                while($row=$result->fetch_assoc()){
                    array_push($arr2,$row); 
                }
                echo(json_encode(["success" => true,"response" => $arr2,]));
            } else {
                echo(json_encode(["success" => false,"response" => "empty",]));
            }            
        }else if($_POST["wData"]=="userPlaces"){
            if(isset($_SESSION["user"])){
                $sql = "SELECT * FROM userplaces WHERE uid=?";
                $stmt = $conn->prepare($sql); 
                $stmt->bind_param("s", intval($_SESSION["user"]['ID']));
                $gotPlace = [];
                $stmt->execute();
                $result = $stmt->get_result();
                $ids = [];
                while($row = $result->fetch_assoc()){
                    array_push($gotPlace, $row);
                    array_push($ids, $row["placeid"]);
                }
                echo(json_encode(["success" => true,"response" => $gotPlace,]));
            }else{
                echo(json_encode(["success" => false,"response" => "Not logined user",]));
            }
        }     
        else if($_POST["wData"]=="getPlaces"){
            if(isset($_SESSION["user"])){
                if($_SESSION["user"]["admin"]==1){
                    $sql = "SELECT * FROM userplaces";
                    $stmt = $conn->prepare($sql); 
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $gotPlace = [];
                    while($row = $result->fetch_assoc()){
                        array_push($gotPlace, $row);
                    }    
                    echo(json_encode(["success" => true,"response" => $gotPlace,]));
                }else{
                    echo(json_encode(["success" => false,"response" => "Not Admin",]));
                }
            }else{
                echo(json_encode(["success" => false,"response" => "Not logined user",]));
            }
        } 
        else if($_POST["wData"]=="getUserPlaces"){
            if(isset($_SESSION["user"],$_POST["uid"]) and $_SESSION["user"]["admin"]==1){
                $sql = "SELECT * FROM userplaces WHERE uid=?";
                $stmt = $conn->prepare($sql); 
                $id = trim($_POST["uid"]);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $gotPlace = [];
                while($row = $result->fetch_assoc()){
                    array_push($gotPlace, $row);
                }

                echo(json_encode(["success" => true,"response" => $gotPlace,]));
            }
        }else{
            echo(json_encode(["success" => false,"response" => "No wData. Requested ".$_POST['wData'],]));
        }
    }else{
        echo(json_encode(["success" => false,"response" => "No wData. Requested ".$_POST['wData'],]));
    }
?>
