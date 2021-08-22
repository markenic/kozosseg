<?php
    if(isset($_POST["session"]) and $_POST["session"]==true){  session_name("kozossegLogin");session_start();} 
    include("conn.php");
    if(isset($_SESSION["user"]["ID"])){
        if($_POST["wData"] == "allPeople"){  
            if($_SESSION["user"]["admin"]==1){           
                $sql = "SELECT id,name,email,isAdmin,class FROM user";
                $stmt = $conn->prepare($sql); 
                if($stmt->execute()){
                    $result = $stmt->get_result();
                    $gotDatas = [];
                    while($row = $result->fetch_assoc()){
                        array_push($gotDatas, $row);
                    }
                    echo(json_encode(["success" => true,"response" => $gotDatas,]));
                }else{
                    echo(json_encode(["success" => false,"response" => $stmt->error,]));  
                }
            }
        }else if($_POST["wData"] == "onePerson"){
            if(isset($_SESSION["user"],$_POST["userid"]) and $_SESSION["user"]["admin"]==1){
                $id = trim($_POST["userid"]);
                
                $sql = "SELECT id,name,email,isAdmin,class FROM user WHERE id=?";
                $stmt = $conn->prepare($sql); 
                $id = trim($_SESSION["user"]["id"]);
                $stmt->bind_param("i", $id);
                if($stmt->execute()){
                    $result = $stmt->get_result();
                    $gotDatas = [];
                    while($row = $result->fetch_assoc()){
                        array_push($gotDatas, $row);
                    }
                    echo(json_encode(["success" => true,"response" => $gotDatas,]));
                }else{
                    echo(json_encode(["success" => false,"response" => $stmt->error,]));  
                }
            }
        }
        else if($_POST["wData"] == "own"){
            $id = trim($_SESSION["user"]["ID"]);
            $sql = "SELECT id,name,email,isAdmin,class FROM user WHERE id=?";
            $stmt = $conn->prepare($sql); 

            $stmt->bind_param("i", $id);
            if($stmt->execute()){
                $result = $stmt->get_result();
                $gotDatas = [];
                while($row = $result->fetch_assoc()){
                    array_push($gotDatas, $row);
                }
                echo(json_encode(["success" => true,"response" => $gotDatas,]));
            }else{
                echo(json_encode(["success" => false,"response" => $stmt->error,]));  
            }
        }else{
            echo(json_encode(["success" => false,"response" => "no wData",]));  
        }

    }else{
        echo(json_encode(["success" => false,"response" => "Not logined user",]));  
    }
?>